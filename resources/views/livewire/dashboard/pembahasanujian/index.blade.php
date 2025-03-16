@section('title')
    Pembahasan - {{ $ujian->nama_ujian }}
@endsection
<div class="bg-gray-50 dark:bg-gray-700" wire:ignore>
    <div class="bg-red-400 hidden">zz</div>
    <div class="bg-green-400 hidden">zz</div>
    <div class="bg-red-700 hidden">zz</div>
    <div class="max-w-5xl mx-auto p-4" style="min-height: 100vh;">
        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab"
                data-tabs-toggle="#default-tab-content" role="tablist">
                <li class="me-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg" id="profile-tab"
                        data-tabs-target="#profile" type="button" role="tab" aria-controls="profile"
                        aria-selected="false">Hasil</button>
                </li>
                <li class="me-2" role="presentation">
                    <button
                        class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                        id="dashboard-tab" data-tabs-target="#dashboard" type="button" role="tab"
                        aria-controls="dashboard" aria-selected="false">Pembahasan</button>
                </li>
            </ul>
        </div>
        <div id="default-tab-content">
            <div class="hidden bg-white p-4 rounded-lg  dark:bg-gray-800" id="profile" role="tabpanel"
                aria-labelledby="profile-tab">
                <p class="text-3xl mb-2">{{ $ujian->nama_ujian }}</p>
                <p>B : {{$hasil['benar']}}</p>
                <p>S : {{$hasil['salah']}}</p>
                <p>K : {{$hasil['kosong']}}</p>
                <p class="text-2xl">Bobot: {{$hasil['bobot']}}</p>
            </div>
            <div class="hidden bg-white p-4 rounded-lg  dark:bg-gray-800" id="dashboard" role="tabpanel"
                aria-labelledby="dashboard-tab">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-5">
                    <div class="md:col-span-2 bg-white rounded-md p-4">
                        @php $x=1 @endphp
                        @foreach ($soal as $k)
                            <div class="soal soal-{{ $x }} @if ($x > 1) hidden @endif">
                                <div class="mb-2 text-sm text-right">{{ $k->materi->nama_materi }}</div>
                                <div class="flex items-start gap-2 w-full">
                                    <div>{{ $x }}.</div>
                                    <div class="flex-1">{!! $k->pertanyaan !!}
                                        <div class="list-lower-alpha grid grid-cols-1 md:grid-cols-2 gap-4 mt-4 mb-8">
                                            @php $arr_alpha = array('a','b','c','d','e'); @endphp
                                            @foreach ($arr_alpha as $ka => $va)
                                                @if (!is_null($k->{'opsi_' . $va}) && $k->{'opsi_' . $va} !== '')
                                                    <div
                                                        class="flex items-start gap-2 @if ($va == $k->jawaban) bg-green-400 p-2 rounded @elseif($jawaban[$k->id] == $va) bg-red-400 p-2 rouded @endif">
                                                        <span>{{ $va }}.</span>
                                                        <input id="radio-{{ $k->id }}-{{ $va }}"
                                                            disabled type="radio" value="{{ $va }}"
                                                            name="opsi_{{ $x }}"
                                                            @if ($va == $jawaban[$k->id]) checked @endif
                                                            class="mt-1 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                        <label
                                                            for="radio-{{ $k->id }}-{{ $va }}">{!! $k->{'opsi_' . $va} !!}</label>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                        <div class="flex justify-between space-x-4 mb-4">
                                            <div class="@if ($x == 1) invisible @endif">
                                                <button
                                                    onclick="document.querySelectorAll('.soal').forEach(el => el.classList.add('hidden'));document.querySelector('.soal-{{ $x - 1 }}')?.classList.remove('hidden');"
                                                    class="flex items-center text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                        stroke-width="2" viewBox="0 0 24 24"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M15 19l-7-7 7-7">
                                                        </path>
                                                    </svg>
                                                    Prev
                                                </button>
                                            </div>

                                            <div class="@if ($x == count($soal)) invisible @endif">
                                                <button
                                                    onclick="document.querySelectorAll('.soal').forEach(el => el.classList.add('hidden'));document.querySelector('.soal-{{ $x + 1 }}')?.classList.remove('hidden');"
                                                    class="flex items-center text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                                                    Next
                                                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor"
                                                        stroke-width="2" viewBox="0 0 24 24"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M9 5l7 7-7 7">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            @php $x++; @endphp
                        @endforeach
                    </div>
                    <div>
                        <div class="bg-white rounded-md p-4">
                            @foreach ($soal as $k)
                                @php
                                    $classbtn = 'text-dark bg-white hover:bg-primary-700 hover:text-white border';
                                    if ($jawaban[$k->id] != '') {
                                        if ($jawaban[$k->id] == $k->jawaban) {
                                            $classbtn = 'text-white bg-primary-700 hover:bg-primary-800';
                                        } else {
                                            $classbtn = 'text-white bg-red-700 hover:bg-red-800';
                                        }
                                    }
                                @endphp
                                <button type="button" id="btnsoal-{{ $k->id }}"
                                    class=" {{ $classbtn }} focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm sm:w-auto px-5 py-2.5 text-center mb-2"
                                    onclick="document.querySelectorAll('.soal').forEach(el => el.classList.add('hidden'));document.querySelector('.soal-{{ $loop->iteration }}')?.classList.remove('hidden');">{{ $loop->iteration }}</button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br><br><br>
    </div>
</div>
