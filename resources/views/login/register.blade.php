<x-homes.layout>
	<x-slot:title>{{ $title }}</x-slot:title>

	<section class="bg-gray-50 dark:bg-gray-900">
  		<div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
      		<div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
          		<div class="p-6 space-y-4 md:space-y-6 sm:p-8">
              		<h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                  		Buat akun baru
              		</h1>
              		<form class="space-y-4 md:space-y-6" action="#" method="POST" enctype="multipart/form-data">
						@csrf
                  		<div>
                      		<label for="nama" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
                      		<input type="text" name="nama" id="nama" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Sukandi Nirwa" value="{{ old('nama') }}" required>
							<x-input-error :messages="$errors->get('nama')" class="mt-2" />
                  		</div>
                  		<div>
                      		<label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                      		<input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@company.com" value="{{ old('email') }}" required>
							<x-input-error :messages="$errors->get('email')" class="mt-2" />
                  		</div>
                  		<div>
                      		<label for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Username</label>
                      		<input type="text" name="username" id="username" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name123"  value="{{ old('username') }}" required>
							<x-input-error :messages="$errors->get('username')" class="mt-2" />
                  		</div>
                  		<div>
                      		<label for="foto_profil" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Foto Profil</label>
                      		<input type="file" name="foto_profil" id="foto_profil" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" accept="image/*" value="{{ old('foto_profil') }}">
							<x-input-error :messages="$errors->get('foto_profil')" class="mt-2" />
                  		</div>
                  		<div>
                      		<label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                      		<input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
							<x-input-error :messages="$errors->get('password')" class="mt-2" />
                  		</div>
                  		<div>
                      		<label for="confirm-password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirm password</label>
                      		<input type="password" name="password_confirmation" id="password_confirmation" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                  		</div>
                  		<button type="submit" class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Create an account</button>
                  		<p class="text-sm font-light text-gray-500 dark:text-gray-400">
                      		Sudah punya akun? <a href="/login" class="font-medium text-primary-600 hover:underline dark:text-primary-500">Login disini</a>
                  		</p>
              		</form>
          		</div>
      		</div>
  		</div>
	</section>

</x-homes.layout>