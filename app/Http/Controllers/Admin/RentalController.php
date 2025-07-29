<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RentalUpdateRequest;
use App\Models\Payment;
use App\Models\Rental;
use Carbon\Carbon;
use Illuminate\Http\Request;


class RentalController extends Controller
{

    public function index()
    {
        Rental::where('is_read', false)->update(['is_read' => true]);
        
        $rentals = Rental::with('vehicle', 'user')->latest()->paginate(5);

        return view('admin.pages.rentals.index', compact('rentals'));
    }

    public function confirm(Rental $rental)
    {
        $rental->status = Rental::STATUS_CONFIRMED;
        $rental->save();

        $rental->vehicle->status = 'rented';
        $rental->vehicle->save();

        return back()->with('success', 'Rental confirmed !!');
    }

    public function detail(Rental $rental)
    {
        return view('admin.pages.rentals.detail', compact('rental'));
    }

    public function update(RentalUpdateRequest $request, Rental $rental)
    {

        $rental->update($request->validated());

        return back()->with('success', 'Rental updated successfully.');
    }

    public function payment(Rental $rental)
    {
        return view('admin.pages.rentals.payment', compact('rental'));
    }

    public function markAsPaid(Rental $rental)
    {
       
        $total_price = $rental->calculateTotal();

        
        Payment::create([
            'rental_id' => $rental->id,
            'total_price' => $total_price,
            'paid_at' => Carbon::now(),
            'status' => 'paid',
        ]);

        
        $rental->status = 'completed';
        $rental->save();

        $rental->vehicle->status = 'available';
        $rental->vehicle->save();

        return redirect()->route('admin.rentals.index')->with('success', 'Payment Successfull.');
    }
    public function showPayment()
    {
        $payments = Payment::with(['rental.user', 'rental.vehicle'])->latest()->paginate(10);
        return view('admin.pages.rentals.payIndex', compact('payments'));
    }
    public function cancel(Rental $rental)
    {
        $rental->status = 'canceled';
        $rental->vehicle->status = 'available';
        $rental->vehicle->save();
        $rental->save();

        return redirect()->route('admin.rentals.index')->with('success', 'Rental has been canceled.');
    }
}
