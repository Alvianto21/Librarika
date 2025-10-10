@props(['label', 'img', 'name'])
<label for="{{ $label }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $slot }}</label>
<input type="image" src="{{ asset('storage/' . $img) }}" alt="{{ $name }}" id="{{ $label }}" width="200" readonly>