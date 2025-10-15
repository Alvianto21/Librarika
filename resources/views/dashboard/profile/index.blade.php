<x-dashboard.layout>
	<x-slot:title>{{ $title }}</x-slot:title>

	<section class="bg-white dark:bg-gray-900">
    	<div class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
			<x-alert></x-alert>
        	<h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Info Akun</h2>
        	<div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
				@if ($user->foto_profil)
					<div class="sm:col-span-2">
						<x-forms.read-img-form label="foto_profil" img="{{ $user->foto_profil }}" name="{{ $user->nama }}">Foto Profile</x-forms.read-img-form>
					</div>					
				@else
					<div class="sm:col-span-2">
						<label for="foto_profil" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Foto Profile</label>
						<input type="image" src="{{ asset('imgs/guest_user_profile.jpg') }}" alt="Image by studiogstock on Freepik, businessman-character-avatar-isolated" width="200" readonly>
					</div>					
				@endif
            	<div class="sm:col-span-2">
                	<x-forms.read-form label="nama" name="nama" type="text" value="{{ $user->nama }}">Nama Pengguna</x-forms.read-form>
            	</div>
            	<div class="w-full">
                	<x-forms.read-form label="email" name="email" type="email" value="{{ $user->email }}">Email</x-forms.read-form>
            	</div>
            	<div class="w-full">
                	<x-forms.read-form label="username" name="username" type="text" value="{{ $user->username }}">Username</x-forms.read-form>
            	</div>
        	</div>
        	<a type="button" href="{{ route('profile.edit', ['user' => $user->username]) }}" class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
				Edit Profile
        	</a>
    	</div>
	</section>


</x-dashboard.layout>