<x-dashboard.layout>
	<x-slot:title>{{ $title }}</x-slot:title>

	<section class="bg-white dark:bg-gray-900">
    	<div class="py-8 px-4 mx-auto max-w-screen-xl sm:py-16 lg:px-6">
        	<div class="max-w-screen-md">
            	<h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">Selamat datang pengunna baru.</h2>
            <p class="mb-8 font-light text-gray-500 sm:text-xl dark:text-gray-400">Terima kasi sudah menjadi anggota kami. Sebelum anda dapat mengakses semua fitur kami, mohon untuk verifikasi email anda melalui link yang dikirim ke email anda. Jika anda belum mendapat email tersebut, anda dapat mengirim ulang melalui tombol dibawah ini.</p>
			@if (session('status') == 'verification-link-sent')
            	<p class="mb-8 font-light text-green-500 sm:text-xl dark:text-green-400">Link verifikasi baru telah dikirim.</p>				
			@endif
            <div class="flex flex-col space-y-4 sm:flex-row sm:space-y-0 sm:space-x-4">
				<form action="{{ route('verification.send') }}" method="post">
					@csrf
					<button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">Kirim Ulang notifikasi</button>
				</form>
            </div>
        </div>
    </div>
</section>

</x-dashboard.layout>