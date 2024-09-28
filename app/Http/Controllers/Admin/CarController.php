<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

use function Pest\Laravel\json;

class CarController extends Controller
{
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

    /**
     * Display  Car Page.
     */
    public function index(){
        return view('admin.pages.car');
    }

    /**
     * Update car availability
     */
    public function updateAvailability(Request $request, string $id){
        //if empty car id
        if($request->get('availability') == null){
            return response()->json([
                'success' => false,
                'message' => [
                    ['Value Not Found']
                ]
            ]);
        }

        $car = Car::find($id);

        //if available is not 0 or 1
        if (!in_array($request->get('availability'), [0, 1])) {
            return response()->json([
                'success' => false,
                'message' => [
                    ['Availability must be 0 or 1']
                ]
            ]);
        }

        if (!$car) {
            return response()->json([
                'success' => false,
                'message' => [
                    ['Car Not found']
                ]
            ]);
        }

        $car->update(['availability' => $request->get('availability')]);
        return response()->json([
            'success' => true,
            'message' => [
                ['Car availability updated successfully']
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        try {
            //validate request
            $validated = $request->validate([
                'name' => 'required',
                'brand' => 'required',
                'model' => 'required',
                'year' => 'required',
                'car_type' => 'required',
                'daily_rent_price' => 'required|numeric',
                'availability' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ], [
                'image.required' => 'Image type is required',
                'image.image' => 'Image must be an image',
                'image.mimes' => 'Image must be a file of type: jpeg, png, jpg, gif, svg.',
                'image.max' => 'Image must be a file of type: jpeg, png, jpg, gif, svg and size less than 2MB.',
            ]);


            //upload image
            $imageName = time() . '-' . $validated['car_type'] . '.' . $validated['image']->getClientOriginalExtension();
            $validated['image']->move(public_path('images'), $imageName);

            $validated['image'] = $imageName;

            //create car
            $car = Car::create($validated);

            return response()->json([
                'success' => true,
                'message' => [
                    ['Car created successfully']
                ],
                'data' => $car,
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->errors(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => [
                    [$e->getMessage()]
                ],
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $car = Car::find($id);
        if (!$car) {
            return response()->json([
                'success' => false,
                'message' => [
                    ['Car Not found']
                ]
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => [
                ['Car Details fetched successfully']
            ],
            'data' => $car,
        ]);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        try {
            //validate request
            $validated = $request->validate([
                'name' => 'min:3',
                'brand' => 'min:2',
                'model' => 'min:2',
                'year' => 'min:2',
                'car_type' => 'min:2',
                'daily_rent_price' => 'numeric',
                'availability' => 'boolean',
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ], [
                'image.image' => 'Image must be an image',
                'image.mimes' => 'Image must be a file of type: jpeg, png, jpg, gif, svg.',
                'image.max' => 'Image must be a file of type: jpeg, png, jpg, gif, svg and size less than 2MB.',
            ]);

            //check if any filed is requested to update
            if (empty($validated)) {
                return response()->json([
                    'success' => false,
                    'message' => [
                        ['No field to update']
                    ]
                ]);
            }

            // return $validated;

            //check if image is uploaded
            if ($request->hasFile('image')) {
                //upload image
                $imageName = time() . '-' . $validated['car_type'] . '.' . $validated['image']->getClientOriginalExtension();
                $validated['image']->move(public_path('images'), $imageName);
                $validated['image'] = $imageName;
            }

            //update car
            $car = Car::find($id);
            $car->update($validated);

            return response()->json([
                'success' => true,
                'message' => [
                    ['Car updated successfully']
                ],
                'data' => $car,
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->errors(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => [
                    [$e->getMessage()]
                ],
            ]);
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $car = Car::find($id);
        if (!$car) {
            return response()->json([
                'success' => false,
                'message' => [
                    ['Car Not found']
                ]
            ]);
        }

        $car->delete();
        return response()->json([
            'success' => true,
            'message' => [
                ['Car deleted successfully']
            ]
        ]);
    }
}
