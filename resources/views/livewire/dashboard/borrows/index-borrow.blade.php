<section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5">
    <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
        <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
            <x-alert></x-alert>
            <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                <x-forms.search-form></x-forms.search-form>
                <div class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                    <x-forms.status-borrows-filter :values="['Menunggu' => 'menunggu', 'Dipinjam' => 'dipinjam', 'Dikembalikan' => 'dikembalikan', 'Hilang' => 'hilang']"></x-forms.status-borrows-filter>
                </div>
            </div>
            <x-dashboard.table-borrows :borrows="$borrows"></x-dashboard.table-borrows>
            <div class="mt-4 mb-3 justify-content-center p-3">
                {{ $borrows->links() }}
            </div>
        </div>
    </div>
</section>
