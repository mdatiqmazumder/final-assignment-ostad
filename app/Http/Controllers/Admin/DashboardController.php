<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index(){
        return view('admin.pages.dashboard');
    }

    function dashboardContent(){
        $totalCustomer = User::where('role','customer')->count();
        $totalAdmin = User::where('role','admin')->count();
        $totalUser = User::count();

        $totalCars = Car::count();
        $totalAvailableCars = Car::where('availability',1)->count();
        $totalUnavailableCars = Car::where('availability',0)->count();

        $totalRentals = Rental::count();
        $totalOnGoingRentals = Rental::where('status','Ongoing')->count();
        $totalCompletedRentals = Rental::where('status','Completed')->count();
        $totalCancelledRentals = Rental::where('status','Canceled')->count();

        $totalEarning = Rental::where('status','Completed')->sum('total_cost');

        $todayRentals = Rental::whereDate('created_at',date('Y-m-d'))->count();

        $data = [
            'users' =>[
                'totalCustomer' => $totalCustomer,
                'totalAdmin' => $totalAdmin,
                'totalUsers' => $totalUser
            ],
            'cars' => [
                'totalCars' => $totalCars,
                'totalAvailableCars' => $totalAvailableCars,
                'totalUnavailableCars' => $totalUnavailableCars
            ],
            'rentals' => [
                'totalRentals' => $totalRentals,
                'totalOnGoingRentals' => $totalOnGoingRentals,
                'totalCompletedRentals' => $totalCompletedRentals,
                'totalCanceledRentals' => $totalCancelledRentals,
                'totalEarning' => $totalEarning,
                'todaysRentals' => $todayRentals
            ]
        ];

        return response()->json($data);
    }
}
