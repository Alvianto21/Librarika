<x-dashboard.layout>
	<x-slot:title>{{ $title }}</x-slot:title>

	<section class="bg-white dark:bg-gray-900">
		<div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
			<div class="mx-auto max-w-2xl">
				<p class="text-xl font-medium text-black">Welcome, {{ Auth::user()->nama }}</p>
			</div>
		</div>
	</section>

</x-dashboard.layout>