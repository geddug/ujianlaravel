@section('title')
    Ujian
@endsection
<div>
    <div class="p-4 sm:ml-64">
        @if (session()->has('message'))
            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                role="alert">
                {{ session('message') }}
            </div>
        @endif
        <p class="mb-5"><a href="{{ route('ujian.create') }}"
                class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
                wire:navigate>Baru</a></p>

        <form class="md:grid grid-cols-4 gap-4 mb-5" wire:submit="find">
            <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-5" wire:model="selectedMapel" wire:change="find">
                <option value="">Mapel</option>
                @foreach ($mapel as $k)
                    <option value="{{ $k->id }}">{{ $k->nama_mapel }}</option>
                @endforeach
            </select>

            <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-5" wire:model="selectedStatus" wire:change="find">
                <option value="">Status</option>
                <option value="yes">aktif</option>
                <option value="no">non aktif</option>
            </select>

            <label for="default-search"
                class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
            <div class="relative mb-5">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input type="search" 
                    class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="Search" wire:model="query" />
                <button type="submit"
                    class="text-white absolute end-2.5 bottom-2.5 bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Search</button>
            </div>
        </form>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            <a wire:click.prevent="sortBy('id')" role="button" href="#">No <svg class="w-3 h-3 inline-block text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.335 6.514 6.91 1.464a1.122 1.122 0 0 0-1.818 0l-3.426 5.05a.988.988 0 0 0 .91 1.511h6.851a.988.988 0 0 0 .91-1.511Zm-8.67 6.972 3.426 5.05a1.121 1.121 0 0 0 1.818 0l3.426-5.05a.988.988 0 0 0-.909-1.511H2.574a.987.987 0 0 0-.909 1.511Z"></path>
                            </svg></a>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <a wire:click.prevent="sortBy('nama_ujian')" role="button" href="#">Ujian <svg class="w-3 h-3 inline-block text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.335 6.514 6.91 1.464a1.122 1.122 0 0 0-1.818 0l-3.426 5.05a.988.988 0 0 0 .91 1.511h6.851a.988.988 0 0 0 .91-1.511Zm-8.67 6.972 3.426 5.05a1.121 1.121 0 0 0 1.818 0l3.426-5.05a.988.988 0 0 0-.909-1.511H2.574a.987.987 0 0 0-.909 1.511Z"></path>
                            </svg></a>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <a wire:click.prevent="sortBy('mapel.nama_mapel')" role="button" href="#">Mapel <svg class="w-3 h-3 inline-block text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.335 6.514 6.91 1.464a1.122 1.122 0 0 0-1.818 0l-3.426 5.05a.988.988 0 0 0 .91 1.511h6.851a.988.988 0 0 0 .91-1.511Zm-8.67 6.972 3.426 5.05a1.121 1.121 0 0 0 1.818 0l3.426-5.05a.988.988 0 0 0-.909-1.511H2.574a.987.987 0 0 0-.909 1.511Z"></path>
                            </svg></a>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <a wire:click.prevent="sortBy('status')" role="button" href="#">Status <svg class="w-3 h-3 inline-block text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.335 6.514 6.91 1.464a1.122 1.122 0 0 0-1.818 0l-3.426 5.05a.988.988 0 0 0 .91 1.511h6.851a.988.988 0 0 0 .91-1.511Zm-8.67 6.972 3.426 5.05a1.121 1.121 0 0 0 1.818 0l3.426-5.05a.988.988 0 0 0-.909-1.511H2.574a.987.987 0 0 0-.909 1.511Z"></path>
                            </svg></a>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <a wire:click.prevent="sortBy('jumlah_soal')" role="button" href="#">Jumlah Soal <svg class="w-3 h-3 inline-block text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.335 6.514 6.91 1.464a1.122 1.122 0 0 0-1.818 0l-3.426 5.05a.988.988 0 0 0 .91 1.511h6.851a.988.988 0 0 0 .91-1.511Zm-8.67 6.972 3.426 5.05a1.121 1.121 0 0 0 1.818 0l3.426-5.05a.988.988 0 0 0-.909-1.511H2.574a.987.987 0 0 0-.909 1.511Z"></path>
                            </svg></a>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <span class="sr-only"></span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $k)
                        <tr
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $loop->iteration }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $k->nama_ujian }}
                            </td>
                            <td class="px-6 py-4">
                                {{$k->mapel->nama_mapel}}
                            </td>
                            <td class="px-6 py-4">
                                {{$k->status}}
                            </td>
                            <td class="px-6 py-4">
                                {{$k->jumlah_soal}}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('ujian.edit', $k->id) }}" wire:navigate
                                    class="font-medium text-primary-600 dark:text-primary-500 hover:underline mr-2">Edit</a>
                                <button wire:click="destroy({{ $k->id }})"
                                    class="font-medium text-red-600 dark:text-red-500 hover:underline">Hapus</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $data->links() }}
    </div>
</div>
