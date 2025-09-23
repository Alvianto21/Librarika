<x-dashboard.layout>
	<x-slot:title>{{ $title }}</x-slot:title>

	<p class="text-xl font-medium text-black">Welcome, {{ Auth::user()->nama }}</p>

</x-dashboard.layout>