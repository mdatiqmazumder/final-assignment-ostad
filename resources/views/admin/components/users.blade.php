<section class="bg-gradient-to-br from-cyan-300 via-blue-300 to-red-100 py-10">
    <div class="container mx-auto">
        <div class="flex justify-between">
            <h2 class="text-center text-xl font-bold mb-6">Manage All Cars</h2>
            <button class="block bg-orange-500 text-white p-2 rounded-md mt-4 px-4" onclick="modalOpen()">Add New
                Car</button>
        </div>
        <div class="overflow-x-auto">
            <table id="userTable" class="text-center min-w-full bg-white border border-gray-200">
                <thead>
                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm">

                        <th class="py-3 px-4 text-left">Serial</th>
                        <th class="py-3 px-4 text-left">ID</th>
                        <th class="py-3 px-4 text-left">Name</th>
                        <th class="py-3 px-4 text-left">Email</th>
                        <th class="py-3 px-4 text-left">Role</th>
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
                    <h2 class="text-center font-extrabold text-2xl text-blue-500 mb-4" id="modalText">Update User</h2>

                    <form id="modelForm">
                        <div class="mb-2">
                            <label for="name" class="block text-sm text-gray-600">Name</label>
                            <input type="text" id="name" class="border border-gray-300 rounded-md p-2 w-full"
                                placeholder="Name">
                        </div>

                        <div class="mb-2">
                            <label for="email" class="block text-sm text-gray-600">Email</label>
                            <input type="text" id="email" class="border border-gray-300 rounded-md p-2 w-full"
                                placeholder="Email">
                        </div>

                        <div class="mb-2">
                            <label for="role" class="block text-sm text-gray-600">Role</label>
                            <input type="text" id="role" class="border border-gray-300 rounded-md p-2 w-full"
                                placeholder="role">
                        </div>

                        <div class="mb-2">
                            <label for="address" class="block text-sm text-gray-600">Address</label>
                            <textarea id="address" class="border border-gray-300 rounded-md p-2 w-full"
                                placeholder="Address"></textarea>
                        </div>
                    </form>

                    <div class="mb-2 flex justify-between">
                        <button class="block bg-red-500 text-white p-2 rounded-md mt-4 w-[48%]"
                            onclick="modalClose()">Close</button>

                        <button class="block bg-green-500 text-white p-2 rounded-md mt-4 w-[48%]" id="updateBtn">Update</button>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        getUser();
    });

    async function getUser() {

        axios.get('{{ route('allUsers') }}')
            .then(response => {
                const users = response.data;
                const userTableBody = $('#userTable tbody');

                // console.log(users);

                userTableBody.empty();

                users.forEach((user, index) => {
                    let bgColorClass = '';
                    let textForRole = '';
                    if (user.role == 'admin') {
                        bgColorClass = 'bg-green-200';
                        textForRole = 'Admin'
                    } else if (user.role == 'customer') {
                        bgColorClass = 'bg-red-200 text-sm';
                        textForRole = 'Customer'
                    }

                    const row = `
                        <tr>
                            <td class="py-3 px-4 border-b">${index + 1}</td>
                            <td class="py-3 px-4 border-b">${user.id}</td>
                            <td class="py-3 px-4 border-b">${user.name}</td>
                            <td class="py-3 px-4 border-b">${user.email}</td>

                            <td class="py-3 px-4 border-b ${bgColorClass}">${textForRole}</td>
                            <td class="py-3 px-4 border-b flex">
                                <button class="ml-1 inline-block px-3 py-2 font-bold text-slate-600 rounded w-full bg-blue-300" onclick="updateUserModal('${user.id}','${user.name}','${user.email}','${user.role}','${user.address}')">Show/Edit</button>
                                <button class="ml-1 inline-block px-3 py-2 font-bold text-slate-600 rounded w-full bg-red-300" onclick="destroyUser(${user.id})">Delete</button>
                            </td>
                        </tr>
                    `;
                    userTableBody.append(row);
                });
                // Initialize DataTable
                $('#userTable').DataTable();
            })
            .catch(error => {
                console.error('Error fetching Car data:', error);
            });
    }


    function modalOpen() {
        const modal = document.getElementById('modal');
        modal.classList.remove('hidden');
    }

    function modalClose() {
        const modal = document.getElementById('modal');
        modal.classList.add('hidden');
    }

    async function destroyUser(userId) {
        showProgress();
        let response = await axios.delete(`{{ route('destroyUser', '') }}/${userId}`);

        if (response.data.success) {
            Object.keys(response.data.message).forEach((key) => {
                let messages = response.data.message[key];
                messages.forEach((message) => {
                    notify.success(message);
                });
            });
            getUser();
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


    async function updateUserModal(userId, name, email, role, address) {
        modalOpen();
        document.getElementById('name').value = name;
        document.getElementById('email').value = email;
        document.getElementById('role').value = role;
        document.getElementById('address').value = address;

        const updateBtn = document.getElementById('updateBtn');
        updateBtn.setAttribute('onclick', `updateUser(${userId})`);

    }

    async function updateUser(userId){

        const name = document.getElementById('name').value;
        const email = document.getElementById('email').value;
        const role = document.getElementById('role').value;
        const address = document.getElementById('address').value;

        showProgress();

        let response = await axios.put("{{ route('updateUser', '') }}/"+userId, {
            name: name,
            email: email,
            role: role,
            address: address
        });

        if (response.data.success) {
            Object.keys(response.data.message).forEach((key) => {
                let messages = response.data.message[key];
                messages.forEach((message) => {
                    notify.success(message);
                });
            });
            getUser();
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
