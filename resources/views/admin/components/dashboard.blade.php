<section class="bg-gradient-to-br from-cyan-300 via-blue-300 to-red-100 py-10">
    <div class="container mx-auto">
        <h2 class="text-center text-2xl font-bold mb-6">Dashboard</h2>
        <div class="overflow-x-auto">

            {{-- grid cards for show total_user total_customer total_admin --}}
            <div class="bg-white p-2 md:p-4 rounded">
                <h6 class="p-3 text-center font-extrabold text-blue-600 text-2xl">User Statics</h6>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-white shadow-xl p-4 rounded-lg">
                        <h3 class="text-center text-xl font-bold">Total Users</h3>
                        <p class="text-center text-3xl text-blue-500"><a href="{{ route('adminUsers') }}" id="totalUsers">0</a></p>
                    </div>
                    <div class="bg-white shadow-xl p-4 rounded-lg">
                        <h3 class="text-center text-xl font-bold">Total Customers</h3>
                        <p class="text-center text-3xl text-blue-500"><a href="{{ route('adminUsers') }}" id="totalCustomer">0</a>
                        </p>
                    </div>
                    <div class="bg-white shadow-xl p-4 rounded-lg">
                        <h3 class="text-center text-xl font-bold">Total Admins</h3>
                        <p class="text-center text-3xl text-blue-500"><a href="{{ route('adminUsers') }}" id="totalAdmin">0</a></p>
                    </div>
                </div>

                <h6 class="p-3 text-center font-extrabold text-blue-600 text-2xl mt-4">Car Statics</h6>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-white shadow-xl p-4 rounded-lg">
                        <h3 class="text-center text-xl font-bold">Total Cars</h3>
                        <p class="text-center text-3xl text-blue-500"><a href="{{ route('car.index') }}" id="totalCars">0</a></p>
                    </div>
                    <div class="bg-white shadow-xl p-4 rounded-lg">
                        <h3 class="text-center text-xl font-bold">Available Cars</h3>
                        <p class="text-center text-3xl text-blue-500"><a href="{{ route('car.index') }}" id="availableCars">0</a>
                        </p>
                    </div>
                    <div class="bg-white shadow-xl p-4 rounded-lg">
                        <h3 class="text-center text-xl font-bold">Unavailable Cars</h3>
                        <p class="text-center text-3xl text-blue-500"><a href="{{ route('car.index') }}" id="unavailableCars">0</a></p>
                    </div>
                </div>

                <h6 class="p-3 text-center font-extrabold text-blue-600 text-2xl mt-4">Rentals Statics</h6>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-white shadow-xl p-4 rounded-lg">
                        <h3 class="text-center text-xl font-bold">Total Rentals</h3>
                        <p class="text-center text-3xl text-blue-500"><a href="{{ route('adminRentalsView') }}" id="totalRentals">0</a></p>
                    </div>



                    <div class="bg-white shadow-xl p-4 rounded-lg">
                        <h3 class="text-center text-xl font-bold">Ongoing Rentals</h3>
                        <p class="text-center text-3xl text-blue-500"><a href="{{ route('adminRentalsView') }}" id="ongoingRentals">0</a></p>
                    </div>



                    <div class="bg-white shadow-xl p-4 rounded-lg">
                        <h3 class="text-center text-xl font-bold">Completed Rentals</h3>
                        <p class="text-center text-3xl text-blue-500"><a href="{{ route('adminRentalsView') }}" id="completedRentals">0</a></p>
                    </div>



                    <div class="bg-white shadow-xl p-4 rounded-lg">
                        <h3 class="text-center text-xl font-bold">Cancelled Rentals</h3>
                        <p class="text-center text-3xl text-blue-500"><a href="{{ route('adminRentalsView') }}" id="canceledRentals">0</a></p>
                    </div>



                    <div class="bg-white shadow-xl p-4 rounded-lg">
                        <h3 class="text-center text-xl font-bold">Total Earning</h3>
                        <p class="text-center text-3xl text-blue-500"><a href="{{ route('adminRentalsView') }}" id="totalEarning">0</a></p>
                    </div>

                    <div class="bg-white shadow-xl p-4 rounded-lg">
                        <h3 class="text-center text-xl font-bold">Today's Rentals</h3>
                        <p class="text-center text-3xl text-blue-500"><a href="{{ route('adminRentalsView') }}" id="todaysRentals">0</a></p>
                    </div>

                </div>
            </div>



        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        getDashboardData();
    });

    async function getDashboardData(){
        const response = await fetch("{{ route('dashboardContent') }}");
        const data = await response.json();

        document.getElementById('totalUsers').innerText = data.users.totalUsers;
        document.getElementById('totalCustomer').innerText = data.users.totalCustomer;
        document.getElementById('totalAdmin').innerText = data.users.totalAdmin;


        document.getElementById('totalCars').innerText = data.cars.totalCars;
        document.getElementById('availableCars').innerText = data.cars.totalAvailableCars;
        document.getElementById('unavailableCars').innerText = data.cars.totalUnavailableCars;


        document.getElementById('totalRentals').innerText = data.rentals.totalRentals;
        document.getElementById('ongoingRentals').innerText = data.rentals.totalOnGoingRentals;
        document.getElementById('completedRentals').innerText = data.rentals.totalCompletedRentals;
        document.getElementById('canceledRentals').innerText = data.rentals.totalCanceledRentals;
        document.getElementById('totalEarning').innerText = data.rentals.totalEarning;
        document.getElementById('todaysRentals').innerText = data.rentals.todaysRentals;
    }

</script>
