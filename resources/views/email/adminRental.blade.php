<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">

    <div style="background-color: #ffffff; padding: 20px; border-radius: 8px; max-width: 600px; margin: 0 auto; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">

        <!-- Header -->
        <div style="background-color: #3490dc; color: #ffffff; padding: 10px; border-radius: 8px 8px 0 0; text-align: center;">
            <h2 style="margin: 0;">New Car Rental Booking</h2>
        </div>

        <!-- Body -->
        <div style="padding: 20px;">
            <p>new rental Created</p>

            <!-- Booking Info -->
            <div style="margin-bottom: 20px;">
                <h3 style="margin-bottom: 10px;">Booking Information:</h3>
                <p><strong>Car Name:</strong> {{ $data['car_name'] }}</p>
                <p><strong>Start Date:</strong> {{ $data['start_date'] }}</p>
                <p><strong>End Date:</strong> {{ $data['end_date'] }}</p>
                <p><strong>Total Cost:</strong> {{ $data['total_cost'] }}</p>
            </div>

            <!-- Button -->
            <p><a href="{{ route('adminRentalsView') }}" style="background-color: #3490dc; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block;">Get Details</a></p>
        </div>

        <!-- Footer -->
        <div style="text-align: center; padding: 10px; font-size: 12px; color: #777;">
            <p>&copy; {{ date('Y') }} Car Rental Company. All rights reserved.</p>
        </div>
    </div>

</body>
