<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use Illuminate\Http\Request;

class UserRentalController extends Controller
{
    public function index()
{
    $rentals = Rental::where('user_id', auth()->id())
        ->with('vehicle') 
        ->latest()
        ->get();

    return view('client.pages.index', compact('rentals'));
}
}
