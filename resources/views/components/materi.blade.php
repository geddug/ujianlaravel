<p class="mb-5"><a href="{{ route('materi.index') }}"
        class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
        wire:navigate>Kembali</a></p>
<form wire:submit="store" enctype="multipart/form-data">
    @if (session()->has('message'))
        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
            {{ session('message') }}
        </div>
    @endif
    <div class="mb-5">
        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Materi</label>
        <input type="text"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
            placeholder="SKD" wire:model="nama_materi" required />
    </div>
    <div class="mb-5">
        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mapel</label>
        <select
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            wire:model="mapel_id" required>
            <option value="">Pilih</option>
            @foreach ($mapel as $k)
                <option value="{{ $k->id }}">{{ $k->nama_mapel }}</option>
            @endforeach
        </select>
    </div>
    <button type="submit"
        class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Simpan</button>
</form>
