<div id="contact" class=" bg-gradient-to-br from-cyan-300 via-blue-300 to-red-100 p-0 py-10 md:p-5 md:pb-10">


    <div class="container">

        <h2 class="h1 font-extrabold text-center text-2xl md:text-5xl text-green-600 py-4 ">Contact With Us</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-white p-4 rounded">
                <h3 class="text-xl font-semibold text-green-600">Contact Information</h3>
                <p class="text-lg text-gray-600">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quod.</p>
                <ul class="mt-4">
                    <li class="py-1 text-lg"><i class="fas fa-map-marker-alt"></i> 123 Main Street, New York, NY 10030</li>
                    <li class="py-1 text-lg"><i class="fas fa-phone"></i> +1 234 567 890</li>
                    <li class="py-1 text-lg"><i class="fas fa-envelope"></i>
                        <a href="mailto:admin@easycar.com">admin@easycar.com</a>
                    </li>
                </ul>
            </div>
            <div class="bg-white p-4 rounded">
                <h3 class="text-xl font-semibold text-green-600">Contact Form</h3>
                <form action="" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 gap-4">
                        <input type="text" name="name" placeholder="Your Name" class="border border-gray-300 rounded-md p-2">
                        <input type="email" name="email" placeholder="Your Email" class="border border-gray-300 rounded-md p-2">
                        <textarea name="message" placeholder="Your Message" class="border border-gray-300 rounded-md p-2"></textarea>
                        <button type="submit" class="bg-green-600 text-slate-100 p-2 rounded font-semibold">Send Message</button>
                    </div>
                </form>
            </div>
        </div>




    </div>

</div>
