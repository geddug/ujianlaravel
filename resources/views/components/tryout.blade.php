<p class="mb-5"><a href="{{ route('tryout.index') }}"
        class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
        wire:navigate>Kembali</a></p>

<form wire:submit.prevent="store" enctype="multipart/form-data">
    @if (session()->has('message'))
        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
            {{ session('message') }}
        </div>
    @endif

    <div class="mb-5">
        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Tryout</label>
        <input type="text"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
            placeholder="TWK Tes" wire:model="nama_tryout" required />
        @error('nama_tryout')
            <p id="outlined_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">
                {{ $message }}</p>
        @enderror
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
        @error('mapel_id')
            <p id="outlined_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">
                {{ $message }}</p>
        @enderror
    </div>
    <div class="mb-5">
        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Re Tryout</label>
        <input type="text"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
            placeholder="2" wire:model="re_tryout" required />
        @error('re_tryout')
            <p id="outlined_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">
                {{ $message }}</p>
        @enderror
    </div>
    <div class="mb-5">
        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jeda Waktu (Menit)</label>
        <input type="text"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
            placeholder="10" wire:model="jeda_waktu" required />
        @error('jeda_waktu')
            <p id="outlined_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">
                {{ $message }}</p>
        @enderror
    </div>
    <div class="mb-5">
        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Merge Ujian</label>
        <select
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            wire:model="merge_ujian" required>
            <option value="">Pilih</option>
            <option value="yes">Yes</option>
            <option value="no">No</option>
        </select>
        @error('merge_ujian')
            <p id="outlined_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">
                {{ $message }}</p>
        @enderror
    </div>
    <div class="mb-5">
        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
        <select
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            wire:model="status" required>
            <option value="">Pilih</option>
            <option value="yes">Aktif</option>
            <option value="no">Non Aktif</option>
        </select>
        @error('status')
            <p id="outlined_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">
                {{ $message }}</p>
        @enderror
    </div>

    <div class="mb-5">
        <button data-modal-target="ujian-modal" data-modal-toggle="ujian-modal"
            class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 pilihujian"
            type="button">
            Pilih Ujian
        </button>

        <button data-modal-target="ujianedit-modal" data-modal-toggle="ujianedit-modal" class="hidden editujian"
            type="button" onclick="setTimeout(function() { document.getElementById('editbox').click(); }, 2000);">
            Edit
        </button>
    </div>

    @foreach ($ujian_sementara as $k => $v)
        <div class="mb-5">
            <div class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $k }}
                <button
                    class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
                    type="button" wire:click="editujian('{{ $k }}')"
                    onclick="document.querySelectorAll('.editujian').forEach(el => el.click())">
                    Edit Ujian
                </button>
                <button
                    class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800"
                    type="button" wire:click="hapusujian('{{ $k }}')">
                    Hapus
                </button>
            </div>
            <input type="text"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                value="{{ implode(',', $v) }}" readonly />
        </div>
    @endforeach
    <hr class="my-5 border-b">
    <button type="submit"
        class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Simpan</button>
</form>


<div wire:ignore.self id="ujian-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
            <!-- Modal header -->
            <div
                class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Pilih Ujian
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="ujian-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4">
                <div class="mb-5">
                    <select
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        wire:model="selectMapel" wire:change="findujian">
                        <option value="">Pilih Mapel</option>
                        @foreach ($mapel as $k)
                            <option value="{{ $k->id }}">{{ $k->nama_mapel }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-5" style="max-height: 300px;overflow:auto;">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">No</th>
                                <th scope="col" class="px-6 py-3">Ujian</th>
                                <th scope="col" class="px-6 py-3">Pilih</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($isi_ujian as $k)
                                <tr
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-6 py-4 align-top">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4 align-top">{!! $k->nama_ujian !!}</td>
                                    <td class="px-6 py-4 align-top"><input type="checkbox"
                                            value="{{ $k->id }}" wire:model="sementara"></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button data-modal-hide="ujian-modal" type="button"
                    class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
                    wire:click="tempujian">Simpan</button>
                <button data-modal-hide="ujian-modal" type="button"
                    class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Tutup</button>
            </div>
        </div>
    </div>
</div>


<div wire:ignore.self id="ujianedit-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
            <!-- Modal header -->
            <div
                class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Edit Ujian
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="ujianedit-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4">
                <div class="hidden">
                    <button id="editbox" onclick="checkCheckboxes()">Check Checkboxes with JS</button>
                    <input id="editsementara" type="text" wire:model="sementara">
                </div>
                <div class="mb-5" style="max-height: 300px;overflow:auto;">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">No</th>
                                <th scope="col" class="px-6 py-3">Ujian</th>
                                <th scope="col" class="px-6 py-3">Pilih</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($isi_ujian as $k)
                                <tr
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-6 py-4 align-top">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4 align-top">{!! $k->nama_ujian !!}</td>
                                    <td class="px-6 py-4 align-top"><input id="checkedit-{{ $loop->iteration }}"
                                            type="checkbox" value="{{ $k->id }}" wire:model="sementara"></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button data-modal-hide="ujianedit-modal" type="button"
                    class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
                    wire:click="tempujian">Simpan</button>
                <button data-modal-hide="ujianedit-modal" type="button"
                    class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Tutup</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        function checkCheckboxes() {
            let checked = document.getElementById("editsementara").value;
            let resultArray = checked.split(',');
            let y = 1;
            resultArray.forEach(function(item) {
                document.querySelector('input[id="checkedit-' + y + '"]').checked = true;
                y++;
            });
            Livewire.dispatch('update-sementara', {
                values: resultArray
            });
        }
    </script>
@endpush
