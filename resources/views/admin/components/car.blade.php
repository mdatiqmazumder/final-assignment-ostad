<section class="bg-gradient-to-br from-cyan-300 via-blue-300 to-red-100 py-10">
    <div class="container mx-auto">
        <div class="flex justify-between">
            <h2 class="text-center text-xl font-bold mb-6">Manage All Cars</h2>
            <button class="block bg-orange-500 text-white p-2 rounded-md mt-4 px-4" onclick="modalOpen()">Add New
                Car</button>
        </div>
        <div class="overflow-x-auto">
            <table id="carTable" class="text-center min-w-full bg-white border border-gray-200">
                <thead>
                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm">

                        <th class="py-3 px-4 text-left">Serial</th>
                        <th class="py-3 px-4 text-left">Name</th>
                        <th class="py-3 px-4 text-left">Brand</th>
                        <th class="py-3 px-4 text-left">Model</th>
                        <th class="py-3 px-4 text-left">Daily Rent Price</th>
                        <th class="py-3 px-4 text-left">Image</th>
                        <th class="py-3 px-4 text-left">Status</th>
                        <th class="py-3 px-4 text-left">Action</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>

            {{-- modal for add --}}

            <div class="hidden fixed inset-0 flex items-center justify-center bg-slate-100 bg-opacity-70 overflow-y-auto"
                id="modal">
                <div
                    class="bg-blue-200 p-4 shadow-lg border rounded m-4 w-full max-w-[500px] h-auto max-h-[90vh] overflow-y-auto">
                    <h2 class="text-center font-extrabold text-2xl text-blue-500 mb-4" id="modalText">Add New Car</h2>

                    <form id="modelForm">
                        <div class="mb-2">
                            <label for="name" class="block text-sm text-gray-600">Name</label>
                            <input type="text" id="name" class="border border-gray-300 rounded-md p-2 w-full"
                                placeholder="Name">
                        </div>

                        <div class="mb-2">
                            <label for="brand" class="block text-sm text-gray-600">Brand</label>
                            <input type="text" id="brand" class="border border-gray-300 rounded-md p-2 w-full"
                                placeholder="Brand">
                        </div>

                        <div class="mb-2">
                            <label for="year" class="block text-sm text-gray-600">Year</label>
                            <input type="text" id="year" class="border border-gray-300 rounded-md p-2 w-full"
                                placeholder="Year">
                        </div>

                        <div class="mb-2">
                            <label for="model" class="block text-sm text-gray-600">Model</label>
                            <input type="text" id="model" class="border border-gray-300 rounded-md p-2 w-full"
                                placeholder="Model">
                        </div>

                        <div class="mb-2">
                            <label for="carType" class="block text-sm text-gray-600">Car Type</label>
                            <input type="text" id="carType" class="border border-gray-300 rounded-md p-2 w-full"
                                placeholder="Car Type">
                        </div>

                        <div class="mb-2">
                            <label for="dailyRentPrice"
                                class="block text
                            -sm text-gray-600">Daily Rent
                                Price</label>
                            <input type="text" id="dailyRentPrice"
                                class="border border-gray-300 rounded-md p-2 w-full" placeholder="Daily Rent Price">
                        </div>

                        <div class="mb-2" id="availabilityBox">
                            {{-- radio for availabelity --}}
                            <label for="availability" class="block text-sm text-gray-600">Availability</label>
                            <div class="flex items center">
                                <input type="radio" id="availability" name="availability" value="1"
                                    class="border border-gray-300 rounded-md p-2 w-full" placeholder="Availability">
                                <label for="availability" class="block text-sm text-gray-600">Available</label>
                                <input type="radio" id="availability" name="availability" value="0"
                                    class="border border-gray-300 rounded-md p-2 w-full" placeholder="Availability">
                                <label for="availability" class="block text-sm text-gray-600">Not Available</label>
                            </div>
                        </div>

                        <div class="mb-2">
                            <label for="image" class="block text-sm text-gray-600">Image</label>
                            <input type="file" id="image" class="border border-gray-300 rounded-md p-2 w-full"
                                placeholder="Image">
                        </div>
                    </form>

                    <div class="mb-2 flex justify-between">
                        <button class="block bg-red-500 text-white p-2 rounded-md mt-4 w-[48%]"
                            onclick="modalClose()">Close</button>

                        <button class="block bg-green-500 text-white p-2 rounded-md mt-4 w-[48%]"
                            onclick="addCar()" id="addBtn">Add</button>

                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        getCar();
    });

    async function getCar() {

        axios.get('{{ route('allCars') }}?latestAll')
            .then(response => {
                const cars = response.data;
                const carTableBody = $('#carTable tbody');

                carTableBody.empty();

                cars.forEach((car, index) => {
                    let bgColorClass = '';
                    let textForAvailValue = '';
                    if (car.availability == '1') {
                        bgColorClass = 'bg-green-200';
                        textForAvailValue = 'Available'
                    } else if (car.availability == '0') {
                        bgColorClass = 'bg-red-200 text-sm';
                        textForAvailValue = 'Not Available'
                    }

                    const row = `
                        <tr>
                            <td class="py-3 px-4 border-b">${index + 1}</td>
                            <td class="py-3 px-4 border-b">${car.name}</td>
                            <td class="py-3 px-4 border-b">${car.brand}</td>
                            <td class="py-3 px-4 border-b">${car.model}</td>
                            <td class="py-3 px-4 border-b">${car.daily_rent_price}</td>
                            <td class="py-3 px-4 border-b"><img class="w-full h-[40px]" src="{{ asset('images/${car.image}') }}"></td>

                            <td class="py-3 px-4 border-b ${bgColorClass}">${textForAvailValue}</td>
                            <td class="py-3 px-4 border-b flex">
                                <select class="border border-gray-300 rounded-md p-2 w-full" id="statusBox-${car.id}" onchange="updateStatus(${car.id})">
                                    <option value="1" ${car.availability == '1' ? 'selected' : ''}>Available</option>
                                    <option value="0" ${car.availability == '0' ? 'selected' : ''}>Not Available</option>
                                </select>


                                <button class="ml-1 inline-block px-3 py-2 font-bold text-slate-600 rounded w-full bg-blue-300" onclick="updateCar(${car.id})">Show/Edit</button>

                                <button class="ml-1 inline-block px-3 py-2 font-bold text-slate-600 rounded w-full bg-red-300" onclick="deleteCar(${car.id})">Delete</button>


                            </td>
                        </tr>
                    `;
                    carTableBody.append(row);
                });
                // Initialize DataTable
                $('#carTable').DataTable();
            })
            .catch(error => {
                console.error('Error fetching Car data:', error);
            });
    }

    async function updateStatus(rentalId) {
        const statusBox = document.getElementById('statusBox-' + rentalId);
        const status = statusBox.value;
        showProgress();
        let response = await axios.put(`{{ route('updateAvailability', '') }}/${rentalId}`, {
            availability: status
        })


        if (response.data.success) {
            Object.keys(response.data.message).forEach((key) => {
                let messages = response.data.message[key];
                messages.forEach((message) => {
                    notify.success(message);
                });
            });
            getCar();
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

    function modalOpen() {
        const modal = document.getElementById('modal');
        let availabilityBox = document.getElementById('availabilityBox');
        availabilityBox.classList.remove('hidden');

        let addBtn = document.getElementById('addBtn');
        addBtn.innerText = 'Add';
        //update addbtn method name
        addBtn.setAttribute('onclick', 'addCar()');

        let modelForm = document.getElementById('modelForm');
        modelForm.reset();

        modal.classList.remove('hidden');
    }

    function modalClose() {
        const modal = document.getElementById('modal');
        modal.classList.add('hidden');
    }
    async function deleteCar(carId) {
        showProgress();
        let response = await axios.delete(`{{ route('car.destroy', '') }}/${carId}`);

        if (response.data.success) {
            Object.keys(response.data.message).forEach((key) => {
                let messages = response.data.message[key];
                messages.forEach((message) => {
                    notify.success(message);
                });
            });
            getCar();
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
    async function addCar() {
        const name = document.getElementById('name').value;
        const brand = document.getElementById('brand').value;
        const year = document.getElementById('year').value;
        const model = document.getElementById('model').value;
        const carType = document.getElementById('carType').value;
        const dailyRentPrice = document.getElementById('dailyRentPrice').value;
        const availability = document.getElementById('availability').value;
        const image = document.getElementById('image').files[0];

        const formData = new FormData();
        formData.append('name', name);
        formData.append('brand', brand);
        formData.append('year', year);
        formData.append('model', model);
        formData.append('car_type', carType);
        formData.append('daily_rent_price', dailyRentPrice);
        formData.append('availability', availability);
        formData.append('image', image);

        showProgress();
        let response = await axios.post('{{ route('car.store') }}', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });

        if (response.data.success) {
            Object.keys(response.data.message).forEach((key) => {
                let messages = response.data.message[key];
                messages.forEach((message) => {
                    notify.success(message);
                });
            });
            getCar();
            modalClose();
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

    async function updateCar(carId) {
        modalOpen();

        const name = document.getElementById('name');
        const brand = document.getElementById('brand');
        const year = document.getElementById('year');
        const model = document.getElementById('model');
        const carType = document.getElementById('carType');
        const dailyRentPrice = document.getElementById('dailyRentPrice');
        const availability = document.getElementById('availability');
        let modalText = document.getElementById('modalText');

        let addBtn = document.getElementById('addBtn');
        addBtn.innerText = 'Update';
        //update addbtn method name
        addBtn.setAttribute('onclick', 'updateCarInfo(' + carId + ')');

        let availabilityBox = document.getElementById('availabilityBox');
        availabilityBox.classList.add('hidden');

        let response = await axios.get(`{{ route('car.show', '') }}/${carId}`);

        if (response.data.success) {
            const car = response.data.data;
            name.value = car.name;
            brand.value = car.brand;
            year.value = car.year;
            model.value = car.model;
            carType.value = car.car_type;
            dailyRentPrice.value = car.daily_rent_price;
            availability.value = car.availability;
            modalText.innerText = 'Update Information for ' + car.name + ` ${car.id}`;
        }
    }

    async function updateCarInfo(carId){
        const name = document.getElementById('name').value;
        const brand = document.getElementById('brand').value;
        const year = document.getElementById('year').value;
        const model = document.getElementById('model').value;
        const carType = document.getElementById('carType').value;
        const dailyRentPrice = document.getElementById('dailyRentPrice').value;


        const formData = new FormData();
        formData.append('name', name);
        formData.append('brand', brand);
        formData.append('year', year);
        formData.append('model', model);
        formData.append('car_type', carType);
        formData.append('daily_rent_price', dailyRentPrice);

        //if is upload image then add image
        let image = document.getElementById('image').files[0];
        if(image){
            formData.append('image', image);
        }


        showProgress();
        let response = await axios.post("{{ route('updateCar', '') }}/"+carId, formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
            }
        });

        console.log(response.data);

        if (response.data.success) {
            Object.keys(response.data.message).forEach((key) => {
                let messages = response.data.message[key];
                messages.forEach((message) => {
                    notify.success(message);
                });
            });
            getCar();
            modalClose();
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
</script>
