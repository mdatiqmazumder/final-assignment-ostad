<section id="cars" class="bg-gradient-to-br from-orange-300 via-green-100 to-red-300 py-10">
    <div class="container">
        <h2 class="h1 font-ex trabold text-green-600 py-4 text-center text-4xl mb-4">Create new account</h2>
        <div class="max-w-[700px] m-auto">
            <div class="bg-slate-400 p-4 rounded w-full">
                <div class="mb-4">
                    <label for="name" class="block font-bold text-green-600">Name</label>
                    <input type="name" name="name" id="name" class="w-full p-2 rounded bg-slate-100"
                        placeholder="Name">
                </div>
                <div class="mb-4">
                    <label for="email" class="block font-bold text-green-600">Email</label>
                    <input type="email" name="email" id="email" class="w-full p-2 rounded bg-slate-100"
                        placeholder="Email">
                </div>
                <div class="mb-4">
                    <label for="password" class="block font-bold text-green-600">Password</label>
                    <input type="password" name="password" id="password" class="w-full p-2 rounded bg-slate-100"
                        placeholder="Password">
                </div>
                <button type="submit"
                    class="bg-green-600 hover:bg-green-800 text-white font-bold py-2 px-4 rounded mt-4 block w-full"
                    onclick="register()">Register</button>

                {{-- dont have an account? create now --}}
                <div class="mt-4">
                    Already have an account <a href="{{ route('loginPage') }}" class="text-lg text-blue-900">Login
                        now</a>
                </div>
            </div>
        </div>

    </div>
</section>
<script>
    async function register() {
        let email = document.getElementById('email').value;
        let password = document.getElementById('password').value;
        let name = document.getElementById('name').value;

        showProgress();

        const response = await fetch('{{ route('register') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                email: email,
                password: password,
                name: name
            })
        });
        const data = await response.json();

        hideProgress();
        if (data.success == true) {
            notify.success(data.message);
            setTimeout(() => {
                window.location.href = '{{ route('login') }}';
            }, 1000);
        } else {
            Object.keys(data.message).forEach((key) => {
                data.message[key].forEach((message) => {
                    notify.error(message);
                });
            });
        }
    }
</script>
