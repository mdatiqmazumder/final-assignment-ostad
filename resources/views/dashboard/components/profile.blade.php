<section class="bg-gradient-to-br from-cyan-300 via-blue-300 to-red-100 py-10">
    <div class="container mx-auto">
        <h2 class="text-center text-2xl font-bold mb-6">Profile Detalis</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-white p-4 rounded-lg shadow-md">
                <h3 class="text-xl font-bold mb-4">Personal Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Name</label>
                        <p class="text-lg font-semibold text-gray-900" id="name">Name</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <p class="text-lg font-semibold text-gray-900" id="email">user@site.com</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-4 rounded-lg shadow-md">
                <h3 class="text-xl font-bold mb-4">Account Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Role</label>
                        <p class="text-lg font-semibold text-gray-900" id="role">User</p>
                    </div>
                    <div>
                        <label  class="block text-sm font-medium text-gray-700">Member From</label>
                        <p class="text-lg font-semibold text-gray-900" id="created_at">5 day ago</p>
                    </div>
                </div>
            </div>
        </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        getProfile();
    });

    async function getProfile(){
        let response = await axios.get('{{ route('profile') }}');
        let data = response.data;

        document.getElementById('name').innerText = data.data.name;
        document.getElementById('email').innerText = data.data.email;
        document.getElementById('role').innerText = data.data.role;
        document.getElementById('created_at').innerText = data.data.created_at_human;
    }

</script>
