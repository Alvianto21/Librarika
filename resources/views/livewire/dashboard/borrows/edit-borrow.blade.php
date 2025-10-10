<section class="bg-white dark:bg-gray-900">
    <div class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
        <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Update Pinjam Buku</h2>
        <form wire:submit.prevent="save">
            @csrf
            <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                <div class="sm:col-span-2">
                    <x-forms.input-form label="kode_pinjam" id="kode_pinjam" placehold="kode-pinjam" type="text" value="$code" model="form.kode_pinjam" readonly wire:model="form.kode_pinjam">Kode Pinjam</x-forms.input-form>
                </div>
                <div class="w-full">
                    <x-forms.input-form label="tgl_pinjam" id="tgl_pinjam" placehold="tanggal pinjam" type="date" value="form.tgl_pinjam" model="form.tgl_pinjam" required wire:model="form.tgl_pinjam">Tanggal Pinjam</x-forms.input-form>
                </div>
                <div>
                    <x-forms.input-form label="tgl_kembali" id="tgl_kembali" placehold="tanggal Kembali" type="date" value="form.tgl_kembali" model="form.tgl_kembali" wire:model="form.tgl_kembali">Tanggal Kembali</x-forms.input-form>
                </div>
                <div>
                    <label for="book_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Judul Buku</label>
                    <select id="book_id" name="book_id" required wire:model="form.book_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                        <option selected value="">Pilih Buku</option>
                        @foreach ($books as $book)
                            <option value="{{ $book->id }}" {{ old('form.book_id') == $book->id ? 'selected' : '' }}>{{ $book->judul }}</option>                            
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('form.book_id')" class="mt-2" />
                </div>
                <div>
                    <x-forms.input-select-form label="status_pinjam" id="status_pinjam" :options="['dipinjam' => 'Dipinjam', 'dikembalikan' => 'Dikembalikan', 'hilang' => 'Hilang', 'terlambat' => 'Terlambat']" value="form.status_pinjam" model="form.status_pinjam" required wire:model="form.status_pinjam">Status Pinjam</x-forms.input-select-form>
                </div>
            </div>
            <button type="submit" class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                Pinjam
            </button>
            <div role="status" wire:loading wire:target="save">
                <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                </svg>
                <span class="sr-only">Loading...</span>
            </div>
        </form>
    </div>
</section>

