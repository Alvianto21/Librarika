@props(['label', 'id', 'options', 'value', 'model'])
<label for="{{ $label }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $slot }}</label>
<select name="{{ $id }}" id="{{ $id }}" {{ $attributes }} class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
    <option value="" selected disabled>{{ $slot }}</option>
    @foreach ($options as $option)
        <option value="{{ $option }}" {{ old($value) == $option ? 'selected' : '' }}>{{ $option }}</option>     
    @endforeach
</select>
<x-input-error :messages="$errors->get($model)" class="mt-2" />