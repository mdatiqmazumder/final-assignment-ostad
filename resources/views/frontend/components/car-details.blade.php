<section class="py-10 bg-gradient-to-tr from-cyan-200 to-blue-500 ">
    <div class="container">
        <h2 class="text-4xl text-center font-extrabold text-slate-100 py-4">Car Details</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
            <div class="bg-slate-200 p-4 rounded max-h-[450px]">
                <img id="CarImageBox" src="{{ asset('assets/img/card-ui-skeleton-screen.gif') }}" alt="Car Image"
                    class="w-full h-full rounded">
            </div>
            <div class="bg-slate-200 p-4 rounded">

                <h3 class="text-lg font-bold text-green-600 py-2" id="nameBox">Car Name</h3>

                <p class="font-bold pb-2">Brand: <span id="brandBox" class=" font-normal">Loading...</span></p>
                <p class="font-bold pb-2">Model: <span id="modelBox" class="font-normal">Loading...</span></p>
                <p class="font-bold pb-2">Year: <span id="yearBox" class="font-normal">Loading...</span></p>
                <p class="font-bold pb-2">Daily Rent Price: <span id="priceBox" class="font-normal">0.00</span></p>

                <div class="py-2">
                    <div>
                        <div class="flex justify-between flex-wrap">
                            <label for="totalDays">Total Days</label>
                            <input type="number" id="totalDays" class="w-full p-2 rounded mb-2" value="1">

                            <label for="bookingDate">Enter Booking Date</label>
                            <input type="date" id="bookingDate" class="p-2 rounded w-full ">
                        </div>
                        <p class="text-green font-bold py-2" id="totalPrice">Total Price: <span
                                id="totalPriceValue">00</span></p>
                    </div>

                    <a href="#"
                        class="block bg-gradient-to-tr from-green-300 to-green-600 hover:from-green-600 hover:to-green-300 p-2 rounded font-bold text-slate-100 text-center"
                        onclick="bookNow()">Book Now</a>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    getCarInfo();
    async function getCarInfo() {
        let carId = window.location.pathname.split('/').pop();
        carId = carId.match(/\d+/);
        carId = carId ? carId[0] : '';

        const response = await fetch('{{ route('allCars') }}' + '?id=' + carId +
            '&availability=1&withRentals=Ongoing');
        const data = await response.json();

        if (data.length == 0) {
            notify.error('Car not ready for booking');
            setTimeout(() => {
                window.location.href = '{{ route('cars') }}';
            }, 2000);
            return;
        }

        let car = data[0];

        document.getElementById('nameBox').innerText = car.name;
        document.getElementById('brandBox').innerText = car.brand;
        document.getElementById('modelBox').innerText = car.model;
        document.getElementById('yearBox').innerText = car.year;
        document.getElementById('priceBox').innerText = car.daily_rent_price;

        //image
        let carImageBox = document.getElementById('CarImageBox');
        carImageBox.src = '{{ asset('images') }}/' + car.image;


        const totalDaysInput = document.getElementById('totalDays');
        const totalPriceSpan = document.getElementById('totalPriceValue');

        function updateTotalPrice() {
            let totalDays = totalDaysInput.value || 1;
            let totalPrice = totalDays * car.daily_rent_price;
            totalPriceSpan.innerText = totalPrice.toFixed(2);
        }
        totalDaysInput.addEventListener('input', updateTotalPrice);
        updateTotalPrice();

        disableRentedDates(car.rentals);
    }



    function disableRentedDates(rentals) {
        const bookingDateInput = document.getElementById('bookingDate');

        function parseDate(dateString) {
            const [year, month, day] = dateString.split('-');
            return new Date(year, month - 1, day);
        }
        let rentedDates = [];

        rentals.forEach(rental => {
            let currentDate = parseDate(rental.start_date);
            const endDate = parseDate(rental.end_date);

            while (currentDate <= endDate) {
                rentedDates.push(new Date(currentDate));
                currentDate.setDate(currentDate.getDate() + 1);
            }
        });

        function formatDateToYMD(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        flatpickr(bookingDateInput, {
            minDate: "today",
            disable: rentedDates.map(date => formatDateToYMD(date)),
            dateFormat: "Y-m-d",
        });

    }


    //booking code
    async function bookNow() {
        let carId = window.location.pathname.split('/').pop();
        carId = carId.match(/\d+/);
        carId = carId ? carId[0] : '';
        let totalDays = document.getElementById('totalDays').value;
        let bookingDate = document.getElementById('bookingDate').value;

        if (bookingDate == '') {
            notify.error('Please select booking date');
            return;
        }
        showProgress();
        let response = await fetch('{{ route('rent.store') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                car_id: carId,
                total_days: totalDays,
                start_date: bookingDate
            })
        });

        hideProgress();


        //if need to login
        if (response.redirected) {
            window.location.href = response.url + '?backUrl=' + window.location.href;
            return;
        }

        let data = await response.json();
        console.log(data);
        if (data.success == true) {

            Object.keys(data.message).forEach((key) => {
                data.message[key].forEach((message) => {
                    notify.success(message);
                });
            });

            getCarInfo();
        } else {
            Object.keys(data.message).forEach((key) => {
                data.message[key].forEach((message) => {
                    notify.error(message);
                });
            });
        }



    }
</script>
