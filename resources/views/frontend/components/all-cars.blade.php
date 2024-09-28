<section id="cars" class="bg-gradient-to-br from-cyan-300 via-blue-300 to-red-100 py-10">
    <div class="container">
        <h2 class="h1 font-extrabold text-green-600 py-4 text-center text-4xl mb-4">All Cars</h2>
        <!-- Filter Form Start -->
        <div class="bg-slate-200 p-4 rounded mt-8 mb-4">
            <h3 class="text-xl font-bold text-green-600">Filter Cars</h3>
            <form id="carFilterForm">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div>
                        <label for="availability" class="block font-bold text-green-600">Availability</label>
                        <select id="availability" class="w-full p-2 rounded bg-slate-100">
                            <option value="">All</option>
                            <option value="1">Available</option>
                            <option value="0" >Unavailable</option>
                        </select>
                    </div>
                    <div>
                        <label for="car_type" class="block font-bold text-green-600">Car Type</label>
                        <input type="text" id="car_type" class="w-full p-2 rounded bg-slate-100"
                            placeholder="Car Type">
                    </div>
                    <div>
                        <label for="brand" class="block font-bold text-green-600">Brand</label>
                        <input type="text" id="brand" class="w-full p-2 rounded bg-slate-100"
                            placeholder="Brand">
                    </div>
                    <div>
                        <label for="min_price" class="block font-bold text-green-600">Min Price</label>
                        <input type="number" id="min_price" class="w-full p-2 rounded bg-slate-100"
                            placeholder="Min Price">
                    </div>
                    <div>
                        <label for="max_price" class="block font-bold text-green-600">Max Price</label>
                        <input type="number" id="max_price" class="w-full p-2 rounded bg-slate-100"
                            placeholder="Max Price">
                    </div>
                    <div>
                        <label for="order_by" class="block font-bold text-green-600">Price Order By</label>
                        <select id="order_by" class="w-full p-2 rounded bg-slate-100">
                            <option value="">Select Order</option>
                            <option value="asc">Low To High</option>
                            <option value="desc">High to Low</option>
                        </select>
                    </div>
                    <div>
                        <label for="limit" class="block font-bold text-green-600">Limit</label>
                        <input type="number" id="limit" class="w-full p-2 rounded bg-slate-100"
                            placeholder="Number of Cars">
                    </div>
                </div>
                <button type="submit"
                    class="bg-green-600 hover:bg-green-800 text-white font-bold py-2 px-4 rounded mt-4">Filter</button>
            </form>
        </div>
        <!-- Filter Form End -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" id="carBox"></div>

    </div>
</section>

<script>
    // AFTER FULL PAGE LOAD
    window.addEventListener('load', function() {
        showCars();

        document.getElementById('carFilterForm').addEventListener('submit', function(event) {
            event.preventDefault();
            showCars();
        });

        async function showCars() {
            let carBox = document.getElementById('carBox');
            showProgress();

            // Collect filter values
            const availability = document.getElementById('availability').value;
            const carType = document.getElementById('car_type').value;
            const brand = document.getElementById('brand').value;
            const minPrice = document.getElementById('min_price').value;
            const maxPrice = document.getElementById('max_price').value;
            const orderBy = document.getElementById('order_by').value;
            const limit = document.getElementById('limit').value;

            // Create query params
            let query = '';
            if (availability) query += `availability=${availability}&`;
            if (carType) query += `car_type=${carType}&`;
            if (brand) query += `brand=${brand}&`;
            if (minPrice) query += `min_price=${minPrice}&`;
            if (maxPrice) query += `max_price=${maxPrice}&`;
            if (orderBy) query += `order_by=${orderBy}&`;
            if (limit) query += `limit=${limit}&`;

            // Remove the last & if query exists
            if (query) query = query.slice(0, -1);

            const url = query ? `{{ route('allCars') }}?${query}` : `{{ route('allCars') }}`;

            const response = await fetch(url);
            const data = await response.json();
            let carCard = '';
            data.forEach(car => {
                const buttonClass = car.availability === 0 ?
                    'bg-red-600 cursor-not-allowed' :
                    'bg-gradient-to-tr from-green-300 to-green-600 hover:from-green-600 hover:to-green-300';
                const buttonDisabled = car.availability === 0 ? 'disabled' : '';
                const buttonText = car.availability === 0 ? 'Unavailable' : 'Book Now';

                const imageLink = car.availability === 0 ? '#' : `{{ url('book') }}/${car.id}`;
                carCard += `
                <div class="bg-slate-200 p-4 rounded">
                    <img class="w-full h-[300px] bg-slate-300" src="{{ asset('images/${car.image}') }}" alt="Car Image" class="w-full rounded">
                    <h3 class="text-lg font-bold text-green-600 py-2">${car.name}</h3>
                    <p class="text-md text-slate-600">
                        <span class="font-bold">Brand:</span> ${car.brand} <br>
                        <span class="font-bold"> Model: </span>${car.model} <br>
                        <span class="font-bold"> Car ID: </span>${car.id}
                    </p>
                    <div class="flex justify-between items-center py-2">
                        <span class="text-green-600 font-bold">Price: ${car.daily_rent_price}/Day</span>
                        <a href="${imageLink}"
                           class="${buttonClass} p-2 rounded font-bold text-slate-100" ${buttonDisabled}>
                            ${buttonText}
                        </a>
                    </div>
                </div>
                `;
            });
            hideProgress();
            carBox.innerHTML = carCard;
        }
    });
</script>
