<p class="mb-5"><a href="{{ route('soal.index') }}"
        class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
        wire:navigate>Kembali</a></p>
<form wire:submit.prevent="store" enctype="multipart/form-data">
    @if (session()->has('message'))
        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
            {{ session('message') }}
        </div>
    @endif

    <div class="mb-5">
        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mapel</label>
        <select
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 searchselect"
            wire:model="mapel_id" wire:change="find" onchange="setTimeout(function() { searchselect() }, 1000);" required>
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
        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Materi</label>
        <select
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 searchselect"
            wire:model="materi_id" required>
            <option value="">Pilih</option>
            @foreach ($materi as $k)
                <option value="{{ $k->id }}">{{ $k->nama_materi }}</option>
            @endforeach
        </select>
        @error('materi_id')
            <p id="outlined_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">
                {{ $message }}</p>
        @enderror
    </div>
    <div class="mb-5">
        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pembobotan </label>
        <select
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            wire:model="pembobotan" required>
            <option value="">Pilih</option>
            <option value="mudah">mudah</option>
            <option value="sedang">sedang</option>
            <option value="sulit">sulit</option>
        </select>
        @error('pembobotan')
            <p id="outlined_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">
                {{ $message }}</p>
        @enderror
    </div>
    <div class="mb-5" wire:ignore>
        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pertanyaan</label>
        <textarea wire:model="pertanyaan" class="min-h-fit h-48 mce " name="pertanyaan" id="pertanyaan"></textarea>
        @error('pertanyaan')
            <p id="outlined_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">
                {{ $message }}</p>
        @enderror
    </div>

    <div class="mb-5">
        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Bobot</label>
        <input type="text"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
            placeholder="10" wire:model="bobot" required />
        @error('bobot')
            <p id="outlined_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">
                {{ $message }}</p>
        @enderror
    </div>

    @php $arr = array('a','b','c','d','e') @endphp

    <div class="mb-5" id="accordion-color" data-accordion="collapse"
        data-active-classes="bg-blue-100 dark:bg-gray-800 text-blue-600 dark:text-white" wire:ignore>
        @foreach ($arr as $k => $v)
            <h2 id="accordion-color-heading-{{ $loop->iteration }}">
                <button type="button"
                    class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-gray-500 border border-b-0 border-gray-200 focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800 dark:border-gray-700 dark:text-gray-400 hover:bg-blue-100 dark:hover:bg-gray-800 gap-3"
                    data-accordion-target="#accordion-color-body-{{ $loop->iteration }}" aria-expanded="false"
                    aria-controls="accordion-color-body-{{ $loop->iteration }}">
                    <span>Jawaban {{ $v }}</span>
                    <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5 5 1 1 5" />
                    </svg>
                </button>
            </h2>
            <div id="accordion-color-body-{{ $loop->iteration }}" class="hidden"
                aria-labelledby="accordion-color-heading-{{ $loop->iteration }}">
                <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700">
                    <div class="mb-5" wire:ignore>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jawaban</label>
                        <textarea class="mce" placeholder="isi jawaban" wire:model="opsi_{{ $v }}"></textarea>
                    </div>
                    <div class="mb-5">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Bobot</label>
                        <input type="text"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="10" wire:model="bobot_{{ $v }}" />
                    </div>
                </div>
            </div>
        @endforeach

        <h2 id="accordion-color-heading-999">
            <button type="button"
                class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-gray-500 border border-gray-200 focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800 dark:border-gray-700 dark:text-gray-400 hover:bg-blue-100 dark:hover:bg-gray-800 gap-3"
                data-accordion-target="#accordion-color-body-999" aria-expanded="false"
                aria-controls="accordion-color-body-3">
                <span>Pembahasan</span>
                <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5 5 1 1 5" />
                </svg>
            </button>
        </h2>
        <div id="accordion-color-body-999" class="hidden" aria-labelledby="accordion-color-heading-999">
            <div class="p-5 border border-t-0 border-gray-200 dark:border-gray-700">
                <div class="mb-5" wire:ignore>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">P{embahasan</label>
                    <textarea class="mce" placeholder="isi pembahasan" wire:model="pembahasan" required></textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-5">
        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jawaban Benar </label>
        <select
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            wire:model="jawaban" required>
            <option value="">Pilih</option>
            @foreach ($arr as $K => $v)
                <option value="{{ $v }}">{{ $v }}</option>
            @endforeach
        </select>
    </div>


    <button type="submit"
        class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Simpan</button>
</form>

@push('scripts')
    <script src="{{ asset('plugins/tinymce/tinymce.min.js') }}"></script>
    <script>
        setTimeout(function() {
            searchselect();
            tinymce.init({
                selector: '.mce',
                plugins: 'image code powerpaste wordcount table media insertdatetime searchreplace visualblocks fullscreen autolink link charmap preview anchor lists math', // Include the image plugin
                toolbar: [
                    'undo redo | formatselect | bold italic underline strikethrough | forecolor backcolor | fontselect fontsizeselect | alignleft aligncenter alignright alignjustify',
                    'numlist bullist outdent indent blockquote hr superscript subscript | removeformat | link unlink image media | preview code table math'
                ],
                image_advtab: true,
                image_class_list: [{
                        title: 'None',
                        value: ''
                    },
                    {
                        title: 'Border 1',
                        value: 'border-1'
                    },
                ],
                rel_list: [{
                        title: 'Blank',
                        value: ''
                    },
                    {
                        title: 'No Follow',
                        value: 'nofollow'
                    }
                ],
                height: 450,
                menubar: false,
                // Enable automatic image upload on paste
                paste_data_images: true,
                automatic_uploads: true,
                setup: function(editor) {
                    editor.on('init change', function() {
                        editor.save();
                    });
                    editor.on('change', function(e) {
                        let editorId = editor.id;
                        let element = document.getElementById(editorId).getAttribute(
                            'wire:model');
                        @this.set(element, editor.getContent());
                    });
                },
                remove_script_host: true,
                convert_urls: false,
                extended_valid_elements: 'iframe[src|frameborder=0|scrolling|class|width|height|name|align|allowfullscreen|style=display: block; margin-left: auto; margin-right: auto;],button[*],blockquote[class=sf-cnt-blockquote],script[type|src],span[*],video[*|src]',
                video_template_callback: function(data) {
                    //console.log(data);
                    return '<video src="' + data.source1 + '" width="' + data.width + '" height="' +
                        data.height +
                        '"' + (data.poster ? ' poster="' + data.poster + '"' : '') +
                        ' controls="controls">\n' +
                        '<source src="' + data.source1 + '"' + (data.source1mime ? ' type="' + data
                            .source1mime +
                            '"' : '') + ' />\n' + (data.source2 ? '<source src="' + data.source2 + '"' +
                            (data
                                .source2mime ? ' type="' + data.source2mime + '"' : '') + ' />\n' : ''
                        ) + '</video>';
                },
                images_upload_url: '{{ route('upload') }}',
            });
        }, 2000);
    </script>
@endpush
