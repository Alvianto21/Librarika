<section class="bg-white dark:bg-gray-900">
    <div class="max-w-2xl px-4 py-8 mx-auto lg:py-16">
        <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Update Buku</h2>
        <form wire:submit.prevent="save" enctype="multipart/form-data">
            @csrf
            <div class="grid gap-4 mb-4 sm:grid-cols-2 sm:gap-6 sm:mb-5">
                <div class="sm:col-span-2">
                    <x-forms.input-update-form label="judul" id="judul" type="text" placehold="Judul Buku" value="form.judul" default="$book->judul" model="form.judul" required wire:model.blur="form.judul">Judul Buku</x-forms.input-update-form>
                </div>
                <div class="w-full">
                    <x-forms.input-update-form label="slug" id="slug" type="text" placehold="judul-slug-buku" value="$slug" default="$book->slug" model="form.slug" readonly wire:model.defer="form.slug">Slug Judul Buku</x-forms.input-update-form>
                </div>
                <div class="w-full">
                    <x-forms.input-update-form label="ISBN" id="ISBN" type="text" placehold="9787948373113" value="form.ISBN" default="$book->ISBN" model="form.ISBN" required wire:model.blur="form.ISBN">Nomor ISBN</x-forms.input-update-form>
                </div>
                <div class="w-full">
                    <x-forms.input-update-form label="penulis" id="penulis" type="text" placehold="Olivia Usamah" value="form.penulis" default="$book->penulis" model="form.penulis" required wire:model="form.penulis">Penulis Buku</x-forms.input-update-form>
                </div>
                <div class="w-full">
                    <x-forms.input-update-form label="penerbit" id="penerbit" type="text" placehold="Penerbit Cakrawala" value="form.penerbit" default="$book->penerbit" model="form.penerbit" wire:model="form.penerbit">Penerbit Buku</x-forms.input-update-form>
                </div>
                <div>
                    <x-forms.input-select-update-form label="kondisi" id="kondisi" :options="['bagus' => 'Bagus', 'kusam' => 'Kusam', 'rusak' => 'Rusak']" value="form.kondisi" default="$book->kondisi" model="form.kondisi" required wire:model="form.kondisi">Kondisi Buku</x-forms.input-select-update-form>
                </div>
                <div>
                    <x-forms.input-update-form label="tahun_terbit" id="tahun_terbit" type="date" placehold="2009-05-25" value="form.tahun_terbit" default="$book->tahun_terbit" model="form.tahun_terbit" min="1950-01-01" max="2999-12-31" step="1" required wire:model="form.tahun_terbit">Tahun Terbit</x-forms.input-update-form>
                </div>
                <div>
                    <div wire:loading wire:target="form.foto_sampul">Uploading Foto Sampul......</div>
                    @if ($form->foto_sampul)
                        <img src="{{ $form->foto_sampul->temporaryUrl() }}">
                    @elseif ($book->foto_sampul)
                        <img src="{{ asset('storage/' . $book->foto_sampul) }}" alt="{{ $book->judul }}">
                    @endif
                    <x-forms.input-update-form label="foto_sampul" id="foto_sampul" type="file" placehold="" value="form.foto_sampul" default="$book->foto_sampul" model="form.foto_sampul" accept="image/*" wire:model.blur="form.foto_sampul">Foto Sampul</x-forms.input-update-form>
                </div> 
                <div class="sm:col-span-2">
                    <label for="deskripsi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deskripsi/Sipnosis Buku</label>
                    <textarea id="deskripsi" name="deskripsi" rows="8" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="deskripsi atau sipnosis buku" wire:model="form.deskripsi">{{ old('form.deskripsi', $book->deskripsi) }}</textarea>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <button type="submit" class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                    Update buku
                </button>
            </div>

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
