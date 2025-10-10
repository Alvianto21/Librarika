<div class="relative overflow-x-auto">
    <table class="w-full text-md text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-4 py-3">#</th>
                <th scope="col" class="px-4 py-3">Nama Pengguna</th>
                <th scope="col" class="px-4 py-3">Judul Buku</th>
                <th scope="col" class="px-4 py-3">Status</th>
                <th scope="col" class="px-4 py-3" wire:click="sortTable('tgl_pinjam')">
                    <x-symbols.table-short>Tanggal Pinjam</x-symbols.table-short>
                </th>
                <th scope="col" class="px-4 py-3" wire:click="sortTable('tgl_kembali')">
                    <x-symbols.table-short>Tanggal Kembali</x-symbols.table-short>
                </th>
                <th scope="col" class="px-4 py-3">Actions</th>
            </tr>
        </thead>
        <tbody>
			@foreach ($borrows as $borrow)
                <tr class="border-b dark:border-gray-700">
                    <td class="px-4 py-3">{{ $loop->iteration }}</td>
                    <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $borrow->user->nama }}</th>
                    <td class="px-4 py-3">{{ $borrow->book->judul }}</td>
                    <td class="px-4 py-3">{{ $borrow->status_pinjam }}</td>
                    <td class="px-4 py-3">{{ Carbon\Carbon::parse($borrow->tgl_pinjam)->format('d-m-Y') }}</td>
                    <td class="px-4 py-3">{{ Carbon\Carbon::parse($borrow->tgl_kemabli)->format('d-m-Y') }}</td>
                    <td class="px-4 py-3 flex items-center justify-end" wire:key="{{ $borrow->id }}" x-cloak x-data="{ open: false }">
                        <button @click="open = !open" class="inline-flex items-center p-0.5 text-sm font-medium text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100" type="button">
                            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                            </svg>
                        </button>
                        <div wire:ignore x-show="open" @click.outside="open = false" class="z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                            <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="apple-imac-27-dropdown-button">
                                <li>
                                    <a href="{{ route('borrow.show', ['borrow' => $borrow->kode_pinjam]) }}" class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Show</a>
                                </li>
                                <li>
                                @if (Auth::user()->role == 'petugas')
                                            <a href="{{ route('borrow.edit', ['borrow' => $borrow->kode_pinjam]) }}" class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit</a>
                                        </li>
                                    </ul>
                                    @if ($borrow->status_pinjam == 'menunggu')
                                        <div class="py-1">
                                            <button wire:click="approve('{{ $borrow->kode_pinjam }}')" wire:confirm.prompt="Are you sure?\n\nType CONFIRM to confirm|CONFIRM" wire:loading.attr="disabled" class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Confirm</button>
                                            <button wire:click="reject('{{ $borrow->kode_pinjam }}')" wire:confirm.prompt="Are you sure?\n\nType REJECTED to confirm|REJECTED" wire:loading.attr="disabled" class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Reject</button>
                                        </div>                       
                                    @endif    
                                @endif
                        </div>
                    </td>
                </tr>							
			@endforeach
        </tbody>
    </table>
</div>