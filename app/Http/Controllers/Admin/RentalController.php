<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RentalController extends Controller
{
    /**
     * Display rental page.
     */
    public function index()
    {
        return view('admin.pages.rentals');
    }

    /**
     * Display all listing of the resource.
     */
    public function allRentals(Request $request)
    {
        $data = Rental::orderBy('id', 'desc')
            ->with('user', 'car')
            ->get();

        //if found conver user created at to human readable format
        if ($data) {
            foreach ($data as $key => $value) {

                $value->user->created_at_human = Carbon::parse($value->user->created_at)->diffForHumans();
            }
        }
        return response()->json($data);

        return response()->json($data);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validated = $request->validate([
                'status' => 'required|string',
            ]);

            $rental = Rental::find($id);

            if (!$rental) {
                return response()->json([
                    'success' => false,
                    'message' => [['Rental not found']]
                ]);
            }

            $rental->status = $validated['status'];
            $rental->save();

            return response()->json([
                'success' => true,
                'message' => [['Rental updated successfully']]
            ]);
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
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        try {
            $rental = Rental::find($id);

            if (!$rental) {
                return response()->json([
                    'success' => false,
                    'message' => [['Rental not found']]
                ]);
            }

            $rental->delete();

            return response()->json([
                'success' => true,
                'message' => [['Rental deleted successfully']]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => [[$e->getMessage()]]
            ]);
        }
    }
}
