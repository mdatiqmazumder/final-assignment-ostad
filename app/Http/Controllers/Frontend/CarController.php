<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    //

    /**
     * Display all Car list.
     */
    public function allCars(Request $request)
    {
        $query = Car::query();

        //apply filter for car type , brand and daily rent price
        if ($request->has('car_type')) {
            $query->where('car_type', $request->car_type);
        }

        if ($request->has('brand')) {
            $query->where('brand', $request->brand);
        }

        //if only min price
        if ($request->has('min_price')) {
            $query->where('daily_rent_price', '>=', $request->min_price);
        }

        //if only max price
        if ($request->has('max_price')) {
            $query->where('daily_rent_price', '<=', $request->max_price);
        }

        //if both min and max price
        if ($request->has('min_price') && $request->has('max_price')) {
            $query->whereBetween('daily_rent_price', [$request->min_price, $request->max_price]);
        }

        //asc order. asc means price low to high
        if ($request->has('order_by') && $request->order_by == 'asc') {
            $query->orderBy('daily_rent_price', 'asc');
        }
        //desc order. desc means price high to low
        if ($request->has('order_by') && $request->order_by == 'desc') {
            $query->orderBy('daily_rent_price', 'desc');
        }

        //add filter for availability
        if ($request->has('availability')) {
            $query->where('availability', $request->availability);
        }
        //get by id
        if ($request->has('id')) {
            $query->where('id', $request->id);
        }

        //if set limit
        if ($request->has('limit')) {
            $query->limit($request->limit);
        }

        //order by id desc
        if($request->has('latestAll')){
            $query->orderBy('id','desc');
        }

        // if set with active rentals from rentals table
        if($request->has('withRentals')){
            $query->with(['rentals' => function ($query) use ($request) {
                if (!empty($request->withRentals)) {
                    $query->where('status', $request->withRentals);
                }
            }]);
        }
        return $query->get();
    }
}
