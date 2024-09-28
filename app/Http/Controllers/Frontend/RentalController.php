<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\AdminNotification;
use App\Mail\CustomerNotification;
use App\Models\Car;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class RentalController extends Controller
{
    /**
     * Display all listing of the resource.
     */
    public function allRentals(Request $request)
    {
        $user_id = $request->header('user_id');
        $data = Rental::where('user_id', $user_id)
        ->with('car')
        ->orderBy('id', 'desc')
        ->get();

        //if found conver user created at to human readable format
        if ($data) {
            foreach ($data as $key => $value) {
                $value->create_time_human = Carbon::parse($value->created_at)->diffForHumans();
            }
        }

        return response()->json($data);
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.pages.rental');
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        $user_id = $request->header('user_id');
        $user_email = $request->header('email');

        try {
            $validated = $request->validate([
                'car_id' => 'required|numeric',
                'start_date' => 'required|date',
                'total_days' => 'required|numeric',
            ]);

            //convert date to Y-m-d format
            $validated['start_date'] = date('Y-m-d', strtotime($validated['start_date']));

            //start date can nob be less than today
            if (strtotime($validated['start_date']) < strtotime(date('Y-m-d'))) {
                return response()->json([
                    'success' => false,
                    'message' => [['Start date can not be less than today']]
                ]);
            }

            //get end date from start date(total-1 days)
            $end_date = date('Y-m-d', strtotime($validated['start_date'] . ' + ' . ($validated['total_days'] - 1) . ' days'));

            //return $end_date;

            $car = Car::find($validated['car_id']);

            //if not found
            if (!$car) {
                return response()->json([
                    'success' => false,
                    'message' => [['Car not found']]
                ]);
            }
            //if car is not available
            if ($car->availability == 0) {
                return response()->json([
                    'success' => false,
                    'message' => [['Car not available']]
                ]);
            }

            //check car rental history a
            $rentals = Rental::where([
                ['car_id', '=', $validated['car_id']],
                ['status','Ongoing']
            ])->select('start_date', 'end_date')
                ->get();

            //check if car is already booked for this date
            if (count($rentals) > 0) {
                foreach ($rentals as $item) {
                    $existing_start = strtotime($item['start_date']);
                    $existing_end = strtotime($item['end_date']);
                    $new_start = strtotime($validated['start_date']);
                    $new_end = strtotime($end_date);

                    // Check if the new booking overlaps with an existing booking
                    if (($new_start >= $existing_start && $new_start <= $existing_end) ||
                        ($new_end >= $existing_start && $new_end <= $existing_end) ||
                        ($new_start <= $existing_start && $new_end >= $existing_end)
                    ) {

                        return response()->json([
                            'success' => false,
                            'message' => [['Car already booked for this date']]
                        ]);
                    }
                }
            }
            //get total cost
            $total_cost = $car->daily_rent_price * $validated['total_days'];

            //create booking
            $validated['user_id'] = $user_id;
            $validated['end_date'] = $end_date;
            $validated['total_cost'] = $total_cost;

            $save = Rental::create($validated);


            if ($save) {
                //send email to user using blade
                $data = [
                    'rental_id' => $save['id'],
                    'car_name' => $car->name,
                    'start_date' => $validated['start_date'],
                    'end_date' => $end_date,
                    'total_cost' => $total_cost,
                ];

                //send notification to user
                Mail::to($user_email)
                ->send(new CustomerNotification($data));

                // sent to admin
                $admins = User::where('role', 'admin')->get();
                foreach ($admins as $admin) {
                    Mail::to($admin->email)
                    ->send(new AdminNotification($data));
                }


                return response()->json([
                    'success' => true,
                    'message' => [['Car booked successfully']]
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => [['Failed to book car']]
                ]);
            }
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->errors()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => [[$e->getMessage()]]
            ]);
        }
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //

        $user_id = $request->header('user_id');

        try{
            $validated = $request->validate([
                'status' => 'required|string',
            ]);

            $rental = Rental::find($id);

            if(!$rental){
                return response()->json([
                    'success' => false,
                    'message' => [['Rental not found']]
                ]);
            }

            //check rental.user_id == user_id
            if($rental->user_id != $user_id){
                return response()->json([
                    'success' => false,
                    'message' => [['You are not authorized to update this rental']]
                ]);
            }





            //if rental start_day is less than today then user can not cancel
            if(strtotime($rental->start_date) < time() && $validated['status'] == 'Canceled'){
                return response()->json([
                    'success' => false,
                    'message' => [['You can not cancel this rental because it has already started']]
                ]);
            }

            //if rental status is already completed then user can not update
            if($rental->status == 'Completed' && $validated['status'] == 'Completed'){
                return response()->json([
                    'success' => false,
                    'message' => [['You can not update this rental because it is already completed']]
                ]);
            }

            //if rental status is already canceled then user can not update
            if($rental->status == 'Canceled'){
                return response()->json([
                    'success' => false,
                    'message' => [['You can not update this rental because it is already canceled']]
                ]);
            }

            // if rental status is already completed then user can not update
            if ($rental->status == 'Completed') {
                return response()->json([
                    'success' => false,
                    'message' => [['You can not update this rental because it is already completed']]
                ]);
            }

            //user can complete only rental end_date or after
            if($rental->end_date > date('Y-m-d') && $validated['status'] == 'Completed'){
                return response()->json([
                    'success' => false,
                    'message' => [['You can not complete this rental because it has not ended yet']]
                ]);
            }

            $rental->status = $validated['status'];
            $rental->save();

            return response()->json([
                'success' => true,
                'message' => [['Rental updated successfully']]
            ]);

        }catch(ValidationException $e){
            return response()->json([
                'success' => false,
                'message' => $e->errors()
            ]);
        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => [[$e->getMessage()]]
            ]);
        }
    }

}
