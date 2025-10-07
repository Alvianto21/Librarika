<section class="bg-white dark:bg-gray-900">
    <div class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
        <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Info Peminjaman</h2>
        <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
            <div class="sm:col-span-2">
                <x-forms.read-form label="kode_pinjam" name="kode_pinjam" type="text" value="{{ $borrow->kode_pinjam }}">Kode Pinjam</x-forms.read-form>
            </div>
            <div class="w-full">
                <x-forms.read-form label="status_pinjam" name="status_pinjam" type="text" value="{{ $borrow->status_pinjam }}">Status Peminjaman</x-forms.read-form>
            </div>
            <div class="w-full">
                <x-forms.read-form label="nama" name="nama" type="text" value="{{ $borrow->user->nama }}">Nama Pengguna</x-forms.read-form>
            </div>
            <div class="w-full">
                <x-forms.read-form label="username" name="username" type="text" value="{{ $borrow->user->username }}">Username Pengguna</x-forms.read-form>
            </div>
            <div>
                <x-forms.read-form label="tgl_pinjam" name="tgl_pinjam" type="date" value="{{ $tgl_pinjam }}">Tanggal Peminjaman</x-forms.read-form>
            </div>
            <div>
                <x-forms.read-form label="tgl-kembali" name="tgl_kembali" type="date" value="{{ $tgl_kembali }}">Tanggal Dikembalikan</x-forms.read-form>
            </div> 
            @if ($borrow->book->foto_sampul)
                <div class="sm:col-span-2">
                    <x-forms.read-img-form label="foto_sampul" img="{{ $borrow->book->foto_sampul }}" name="{{ $borrow->book->judul }}">Sampul Buku</x-forms.read-img-form>
                </div>
                @endif
            <div>
                <x-forms.read-form label="judul" name="judul" type="text" value="{{ $borrow->book->judul }}">Judul Buku</x-forms.read-form>
            </div>
        </div>
        <a type="button" href="{{ route('users.borrows') }}" class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
            Kembali ke daftar pinjam
        </a>
    </div>
</section>
