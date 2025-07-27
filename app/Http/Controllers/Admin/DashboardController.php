<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function chartData()
    {
        // Số đơn hoàn thành và hủy
        $completedCount = Rental::where('status', 'completed')->count();

        $canceledCount = Rental::where('status', 'canceled')->count();

        $mostRentedCars = Rental::select('car_id', DB::raw('count(*) as total'))
            ->groupBy('car_id')
            ->orderByDesc('total')
            ->with('vehicle')
            ->take(5)
            ->get();
        $statusCounts = Rental::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');
        $monthlyRevenue = Payment::select(
            DB::raw("MONTH(created_at) as month"),
            DB::raw("SUM(total_price) as total")
        )
            ->groupBy(DB::raw("MONTH(created_at)"))
            ->orderBy('month')
            ->pluck('total', 'month');
            $users = User::paginate(5);

        return view('admin.pages.dashboard', compact(
            'completedCount',
            'canceledCount',
            'monthlyRevenue',
            'statusCounts',
            'users',
            'mostRentedCars'
        ));
    }
}
