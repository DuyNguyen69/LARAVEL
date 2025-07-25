<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\BookingRequest;
use App\Mail\RentalConfirmationMail;
use App\Models\Rental;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ClientController extends Controller
{
    public function index()
    {
        $cars = Vehicle::get();

        return view('client.pages.home', compact('cars'));
    }
    public function show(Request $request)
    {

        $itemPerPage = env('ITEM_PER_PAGE', 6);

        $keyword = $request->keyword ?? null;
        $sort = $request->sort ?? 'latest';

        switch ($sort) {
            case 'oldest':
                $column = 'id';
                $direction = 'asc';
                break;
            case 'price_asc':
                $column = 'price_per_day';
                $direction = 'asc';
                break;
            case 'price_desc':
                $column = 'price_per_day';
                $direction = 'desc';
                break;
            default:
                $column = 'id';
                $direction = 'desc';
        }
        $query = Vehicle::with('ProductCategory')->orderBy($column, $direction);

        if ($keyword) {
            $query->where('name', 'LIKE', "%$keyword%");
        }
        $datas = $query->paginate($itemPerPage);
        return view('client.pages.cars_list', ['datas' => $datas, 'itemPerPage' => $itemPerPage]);
    }
    public function detail(Vehicle $car)
    {
        $relatedCars = Vehicle::latest()->take(3)->get();

        return view('client.pages.detail', compact('car', 'relatedCars'));
    }
    public function showBookingForm()
    {

        $cars = Vehicle::where('status', 'available')->get();
        $user = Auth::user();
        return view('client.pages.booking', [
            'cars' => $cars,
            'user' =>$user
        ]);
    }
    public function submitBooking(BookingRequest $request)
    {
        $data = $request->validated();
        
        $userId = Auth::check() ? Auth::id() : null;
        $rental = new Rental();
        $rental->user_id = $userId;// nếu đăng nhập
        $rental->car_id = $data['car_id'];
        $rental->pickup_date = $data['pickup_date'];
        $rental->dropoff_date = $data['dropoff_date'];
        $rental->pickup_time = $data['pickup_time'];
        $rental->dropoff_time = $data['dropoff_time'];
        $rental->customer_name = $data['customer_name'];
        $rental->customer_phone = $data['customer_phone'];
        $rental->customer_email = $data['customer_email'];
        $rental->customer_id_number = $data['customer_id_number'];
        $rental->delivery_option = $data['delivery_option'];
        $rental->delivery_address = $data['delivery_address'] ?? null;
        $rental->status = Rental::STATUS_PENDING;
        $rental->save();
        
        Mail::to($rental->user?->email ?? $data['customer_email'])->send(new RentalConfirmationMail($rental));

        $car = Vehicle::find($data['car_id']);
        
        if ($car) {
            $car->status = 'pending';
            $car->save();
        }

        return redirect()->route('client.cars.home')->with('booking_success', true);

    }
}
