<div class="flex items-center shadow w-full p-2 md:py-4  bg-slate-300 lg:px-10" >
    <img class="max-h-[50px] w-[120px]" src="{{ asset('assets/img/logo.png') }}">

    <nav class="ml-auto md:block group" id="navBar">

        <ul class="hidden py-3 clip-path-noscreen md:clip-path-fullscreen md:flex group-[.showNav]:block
        group-[.showNav]:absolute group-[.showNav]:inset-0 group-[.showNav]:bg-slate-300 group-[.showNav]:clip-path-fullscreen group-[.showNav]:mt-0 transition-clip-path duration-1000 ">

            <div class="mb-4 p-2 px-4 pt-0 items-center shadow-md hidden group-[.showNav]:flex">
                <img class="max-h-[50px] w-[120px]" src="{{ asset('assets/img/logo.png') }}">
                <button onclick="hideMenu()" class="ml-auto text-2xl">
                    <i class="fa-solid fa-times"></i>
                </button>
            </div>



            <li><a onclick="hideMenu()" class="px-6 py-2 mx-2 rounded font-semibold text-slate-200 bg-gradient-to-r from-cyan-700 to-blue-400 hover:from-blue-400 hover:to-cyan-700 transition-all duration-200 group-[.showNav]:block group-[.showNav]:text-center group-[.showNav]:mb-2" href="{{ route('index') }}">Home</a></li>

            <li><a onclick="hideMenu()" class="px-6 py-2 mx-2 rounded font-semibold text-slate-200 bg-gradient-to-r from-cyan-700 to-blue-400 hover:from-blue-400 hover:to-cyan-700 transition-all duration-200 group-[.showNav]:block group-[.showNav]:text-center group-[.showNav]:mb-2" href="{{ route('cars') }}">Cars</a></li>

            <li><a onclick="hideMenu()" class="px-6 py-2 mx-2 rounded font-semibold text-slate-200 bg-gradient-to-r from-cyan-700 to-blue-400 hover:from-blue-400 hover:to-cyan-700 transition-all duration-200 group-[.showNav]:block group-[.showNav]:text-center group-[.showNav]:mb-2" href="{{ route('index') }}#about">About Us</a></li>
            <li><a onclick="hideMenu()" class="px-6 py-2 mx-2 rounded font-semibold text-slate-200 bg-gradient-to-r from-cyan-700 to-blue-400 hover:from-blue-400 hover:to-cyan-700 transition-all duration-200 group-[.showNav]:block group-[.showNav]:text-center group-[.showNav]:mb-2" href="{{ route('index') }}#contact">Contact</a></li>
            <li><a onclick="hideMenu()" class="px-6 py-2 mx-2 rounded font-semibold text-slate-200 bg-gradient-to-r from-cyan-700 to-blue-400 hover:from-blue-400 hover:to-cyan-700 transition-all duration-200 group-[.showNav]:block group-[.showNav]:text-center group-[.showNav]:mb-2" href="{{ route('loginPage') }}">Log In</a></li>

        </ul>
    </nav>


    <button class="ml-auto text-xl block md:hidden" onclick="showMenu()">
        <i class="fa-solid fa-bars"></i>
    </button>
</div>


<script>
    function showMenu() {
        document.querySelector('#navBar').classList.add('showNav');
    }

    function hideMenu() {
        document.querySelector('#navBar').classList.remove('showNav');
    }



</script>
