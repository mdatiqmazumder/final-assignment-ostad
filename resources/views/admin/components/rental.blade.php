<section class="bg-gradient-to-br from-cyan-300 via-blue-300 to-red-100 py-10">
    <div class="container mx-auto">
        <h2 class="text-center text-2xl font-bold mb-6">Rental History</h2>
        <div class="overflow-x-auto">
            <table id="rentalTable" class="min-w-full bg-white border border-gray-200">
                <thead>
                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm">

                        <th class="py-3 px-4 text-left">Serial</th>
                        <th class="py-3 px-4 text-left">User Name</th>
                        <th class="py-3 px-4 text-left">User Email</th>
                        <th class="py-3 px-4 text-left">Total Cost</th>
                        <th class="py-3 px-4 text-left">Status</th>
                        <th class="py-3 px-4 text-left">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Rental data will be inserted here by Axios -->
                </tbody>
            </table>

            <div class="hidden fixed inset-0 flex items-center justify-center bg-slate-100 bg-opacity-70 overflow-y-auto"
                id="modal">
                <div
                    class="bg-blue-200 p-4 shadow-lg border rounded m-4 w-full max-w-[500px] h-auto max-h-[90vh] overflow-y-auto">
                    <h2 class="text-center font-extrabold text-2xl text-blue-500 mb-4" id="modalText">Rental Details
                    </h2>

                    {{-- car image  --}}
                    <div class=" bg-white p-2 rounded">
                        <span class="font-bold block mb-2">Car Image:</span>
                        <img src="{{ asset('images/car1.jpg') }}" alt="" id="carImage"
                            class="w-full h-full max-h-[300px] object-cover rounded-md bg-slate-500">

                        {{-- car details in a table --}}
                        <h6 class="text-center pt-3 font-bold text-green-600">Car Info</h6>
                        <hr>
                        <table class="w-full mt-4 border border-collapse border-gray-300">
                            <tr class="border border-gray-300">
                                <td class="font-bold border border-gray-300 p-2">Car ID:</td>
                                <td id="carId" class="border border-gray-300 p-2">01</td>
                            </tr>
                            <tr class="border border-gray-300">
                                <td class="font-bold border border-gray-300 p-2">Car Name:</td>
                                <td id="carName" class="border border-gray-300 p-2">Accord</td>
                            </tr>
                            <tr class="border border-gray-300">
                                <td class="font-bold border border-gray-300 p-2">Car Brand:</td>
                                <td id="carBrand" class="border border-gray-300 p-2">Honda</td>
                            </tr>
                            <tr class="border border-gray-300">
                                <td class="font-bold border border-gray-300 p-2">Car Model:</td>
                                <td id="carModel" class="border border-gray-300 p-2">Sedan</td>
                            </tr>
                            <tr class="border border-gray-300">
                                <td class="font-bold border border-gray-300 p-2">Car Year:</td>
                                <td id="carYear" class="border border-gray-300 p-2">2021</td>
                            </tr>
                            <tr class="border border-gray-300">
                                <td class="font-bold border border-gray-300 p-2">Car Price:</td>
                                <td id="carRentPrice" class="border border-gray-300 p-2">170</td>
                            </tr>
                        </table>



                        {{-- rent details in a table --}}
                        <h6 class="text-center pt-3 font-bold text-green-600">Rent Info</h6>
                        <hr>
                        <table class="w-full mt-4 border border-collapse border-gray-300">

                            <tr class="border border-gray-300">
                                <td class="font-bold border border-gray-300 p-2">Rent ID:</td>
                                <td id="rentId" class="border border-gray-300 p-2">01</td>
                            </tr>
                            {{-- start_date end_date total_cost status --}}
                            <tr class="border border-gray-300">
                                <td class="font-bold border border-gray-300 p-2">Start Date:</td>
                                <td id="startDate" class="border border-gray-300 p-2">2021-10-10</td>
                            </tr>
                            <tr class="border border-gray-300">
                                <td class="font-bold border border-gray-300 p-2">End Date:</td>
                                <td id="endDate" class="border border-gray-300 p-2">2021-10-20</td>
                            </tr>
                            <tr class="border border-gray-300">
                                <td class="font-bold border border-gray-300 p-2">Total Cost:</td>
                                <td id="totalCost" class="border border-gray-300 p-2">2000</td>
                            </tr>
                            <tr class="border border-gray-300">
                                <td class="font-bold border border-gray-300 p-2">Status:</td>
                                <td id="rentStatus" class="border border-gray-300 p-2">Ongoing</td>
                            </tr>
                        </table>

                        {{-- user details in a table --}}
                        <h6 class="text-center pt-3 font-bold text-green-600">User Info</h6>
                        <hr>
                        <table class="w-full mt-4 border border-collapse border-gray-300">
                            <tr class="border border-gray-300">
                                <td class="font-bold border border-gray-300 p-2">User ID:</td>
                                <td id="userId" class="border border-gray-300 p-2">01</td>
                            </tr>
                            <tr class="border border-gray-300">
                                <td class="font-bold border border-gray-300 p-2">User Name:</td>
                                <td id="userName" class="border border-gray-300 p-2">John Doe</td>
                            </tr>
                            <tr class="border border-gray-300">
                                <td class="font-bold border border-gray-300 p-2">User Email:</td>
                                <td id="userEmail" class="border border-gray-300 p-2">
                                    user@gmail.com
                                </td>
                            </tr>
                            <tr class="border border-gray-300">
                                <td class="font-bold border border-gray-300 p-2">Member From:</td>
                                <td id="memberFrom" class="border border-gray-300 p-2">
                                    5 day ago
                                </td>
                            </tr>
                        </table>
                        <button class="mt-4 bg-red-500 text-white font-bold py-2 px-4 rounded w-full" onclick="modalClose()">Close</button>
                    </div>






                </div>
            </div>


        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        getRental();
    });

    async function getRental() {

        axios.get('{{ route('adminAllRentals') }}')
            .then(response => {
                const rentals = response.data;

                const rentalTableBody = $('#rentalTable tbody');

                rentalTableBody.empty();

                rentals.forEach((rental, index) => {



                    let bgColorClass = '';
                    if (rental.status === 'Ongoing') {
                        bgColorClass = 'bg-yellow-200';
                    } else if (rental.status === 'Canceled') {
                        bgColorClass = 'bg-red-200';
                    } else if (rental.status === 'Completed') {
                        bgColorClass = 'bg-green-300';
                    }

                    // console.log(rental.car.id);


                    const row = `
                        <tr>
                            <td class="py-3 px-4 border-b">${index + 1}</td>
                            <td class="py-3 px-4 border-b">${rental.user.name}</td>
                            <td class="py-3 px-4 border-b">${rental.user.email}</td>
                            <td class="py-3 px-4 border-b">${rental.total_cost}</td>
                            <td class="py-3 px-4 border-b ${bgColorClass}">${rental.status}</td>
                            <td class="py-3 px-4 border-b flex">

                                <select class="border border-gray-300 rounded-md p-2 w-full" id="statusBox-${rental.id}" onchange="updateStatus(${rental.id})">
                                    <option value="Ongoing" ${rental.status === 'Ongoing' ? 'selected' : ''}>Ongoing</option>
                                    <option value="Completed" ${rental.status === 'Completed' ? 'selected' : ''}>Completed</option>
                                    <option value="Canceled" ${rental.status === 'Canceled' ? 'selected' : ''}>Canceled</option>
                                </select>

                                <button class="ml-1 inline-block px-3 py-2 font-bold text-slate-600 rounded w-full bg-blue-300" onclick="details('${rental.id}','${rental.start_date}','${rental.end_date}','${rental.total_cost}','${rental.status}','${rental.car.id}','${rental.car.name}','${rental.car.brand}','${rental.car.model}','${rental.car.year}','${rental.car.daily_rent_price}','${rental.car.image}','${rental.user.id}','${rental.user.name}','${rental.user.email}','${rental.user.created_at_human}')">Full Details</button>

                                <button class="ml-1 inline-block px-3 py-2 font-bold text-slate-600 rounded w-full bg-red-300" onclick="deleteRental(${rental.id})">Delete</button>

                            </td>
                        </tr>
                    `;
                    rentalTableBody.append(row);
                });
                // Initialize DataTable
                $('#rentalTable').DataTable();
            })
            .catch(error => {
                console.error('Error fetching rental data:', error);
            });
    }

    async function updateStatus(rentalId) {
        const statusBox = document.getElementById('statusBox-' + rentalId);
        const status = statusBox.value;
        showProgress();
        let response = await axios.put(`{{ route('adminRentalsUpdateStatus', '') }}/${rentalId}`, {
            status: status
        })

        if (response.data.success) {
            Object.keys(response.data.message).forEach((key) => {
                let messages = response.data.message[key];
                messages.forEach((message) => {
                    notify.success(message);
                });
            });
            getRental();
        } else {
            Object.keys(response.data.message).forEach((key) => {
                let messages = response.data.message[key];
                messages.forEach((message) => {
                    notify.error(message);
                });
            });
        }
        hideProgress();
    }

    async function deleteRental(rentalId) {
        showProgress();
        let response = await axios.delete(`{{ route('rentalDestroy', '') }}/${rentalId}`);

        if (response.data.success) {
            Object.keys(response.data.message).forEach((key) => {
                let messages = response.data.message[key];
                messages.forEach((message) => {
                    notify.success(message);
                });
            });
            getRental();
        } else {
            Object.keys(response.data.message).forEach((key) => {
                let messages = response.data.message[key];
                messages.forEach((message) => {
                    notify.error(message);
                });
            });
        }
        hideProgress();
    }

    function details(rental_id, start_date, end_date, total_cost, status, car_id, car_name, car_brand, car_model, car_year, car_rent_price, car_image, user_id, user_name, user_email, member_from) {
        modalOpen();
        car_image = `{{ asset('images') }}/${car_image}`;

        document.getElementById('rentId').innerText = rental_id;
        document.getElementById('startDate').innerText = start_date;
        document.getElementById('endDate').innerText = end_date;
        document.getElementById('totalCost').innerText = total_cost;
        document.getElementById('rentStatus').innerText = status;

        document.getElementById('carId').innerText = car_id;
        document.getElementById('carName').innerText = car_name;
        document.getElementById('carBrand').innerText = car_brand;
        document.getElementById('carModel').innerText = car_model;
        document.getElementById('carYear').innerText = car_year;
        document.getElementById('carRentPrice').innerText = car_rent_price;
        document.getElementById('carImage').src = car_image

        document.getElementById('userId').innerText = user_id;
        document.getElementById('userName').innerText = user_name;
        document.getElementById('userEmail').innerText = user_email;
        document.getElementById('memberFrom').innerText = member_from;


    }


    function modalOpen() {
        const modal = document.getElementById('modal');
        modal.classList.remove('hidden');
    }

    function modalClose() {
        const modal = document.getElementById('modal');
        modal.classList.add('hidden');
    }
</script>
