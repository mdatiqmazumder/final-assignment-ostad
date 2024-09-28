<section id="cars" class="bg-slate-300 py-10">
    <div class="container">

        <h2 class="h1 font-extrabold text-green-600 py-4 text-center text-4xl mb-4">Latest Cars</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" id="carBox">
        </div>

        {{-- all cars link --}}
        <div class="text-center mt-10">
            <a href="{{ route('cars') }}"
                class="bg-gradient-to-tr from-green-300 to-green-600 hover:from-green-600 hover:to-green-300 p-4 rounded font-bold text-slate-100 ">View
                All Cars</a>
        </div>
    </div>
</section>
<script>
    //AFTER FULL PAGE LOAD
    window.addEventListener('load', function() {
        showCars();
        async function showCars() {
            let carBox = document.getElementById('carBox');
            showProgress();
            const response = await fetch('{{ route('allCars') }}' + '?availability=1&limit=6&latestAll');
            const data = await response.json();
            let carCard = '';
            //foreach loop
            data.forEach(car => {
                carCard += `
                <div class="bg-slate-200 p-4 rounded">
                    <img class="w-full h-[300px] bg-slate-300" src="{{ asset('images/${car.image}') }}" alt="Car Image" class="w-full rounded">
                    <h3 class="text-lg font-bold text-green-600 py-2">${car.name}</h3>
                    <p class="text-md text-slate-600"><span class="font-bold">Brand:</span> ${car.brand}.<span class="font-bold"> Model: </span>${car.model}</p>
                    <div class="flex justify-between items-center py-2">
                        <span class="text-green
                        -600 font-bold">Price: ${car.daily_rent_price}/Day</span>
                        <a href="{{ url('book') }}/${car.id}"
                            class="bg-gradient-to-tr from-green-300 to-green-600 hover:from-green-600 hover:to-green-300 p-2 rounded font-bold text-slate-100 ">Book
                            Now</a>
                    </div>
                </div>
                `;
            });
            hideProgress();
            carBox.innerHTML = carCard;


        }
    });
</script>
