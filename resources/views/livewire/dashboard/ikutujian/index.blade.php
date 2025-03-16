@section('title')
    Ikut Ujian - {{ $ujian->nama_ujian }}
@endsection
<div class="bg-gray-50 dark:bg-gray-700" wire:ignore>
    <div class="max-w-5xl mx-auto p-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-5">
            <div class="bg-white rounded-md md:col-span-3 p-4">
                <span class="text-2xl mr-2">{{ $ujian->nama_ujian }}</span>
                <span id="countdown" class=""></span>
                <button wire:click="selesai({{$ikutujianid}})" id="btnselesai" class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm sm:w-auto px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Selesai</button>
            </div>
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
                                            <div class="flex items-start gap-2">
                                                <span>{{ $va }}.</span>
                                                <input id="radio-{{ $k->id }}-{{ $va }}"
                                                    wire:click="jawab({{ $ikutujianid . ',' . $k->id . ",'" . $va . "'" }})"
                                                    type="radio" value="{{ $va }}"
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
                                                stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
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
                                                stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7">
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
                                $classbtn = 'text-white bg-primary-700 hover:bg-primary-800';
                        } @endphp
                        <button type="button"
                            id="btnsoal-{{$k->id}}"
                            class=" {{ $classbtn }} focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm sm:w-auto px-5 py-2.5 text-center mb-2"
                            onclick="document.querySelectorAll('.soal').forEach(el => el.classList.add('hidden'));document.querySelector('.soal-{{ $loop->iteration }}')?.classList.remove('hidden');">{{ $loop->iteration }}</button>
                    @endforeach
                </div>
            </div>
        </div>
        <br><br><br>
    </div>

    @push('scripts')
        <script>
            let endTime = new Date("{{ $expired }}");

            function updateCountdown() {
                let now = new Date();
                let diff = Math.floor((endTime - now) / 1000);

                if (diff <= 0) {
                    document.getElementById("countdown").innerText = "Time's up!";
                    alert("Waktu habis");
                    document.getElementById('btnselesai').click();
                    return;
                }

                let hours = Math.floor(diff / 3600);
                let minutes = Math.floor((diff % 3600) / 60);
                let seconds = diff % 60;

                let textcount = "";
                if (hours > 0) {
                    textcount = textcount + hours + "jam "
                }
                textcount = textcount + minutes + "menit " + seconds + "detik"

                document.getElementById("countdown").innerHTML = textcount;
            }

            setInterval(updateCountdown, 1000);
            updateCountdown();

            document.querySelectorAll("input[type='radio']").forEach(radio => {
                if (radio.checked) {
                    radio.setAttribute("previousValue", "checked");
                } else {
                    radio.setAttribute("previousValue", "false");
                }
                radio.addEventListener("click", function() {
                    let lastcl = this.id;
                    let previousValue = this.getAttribute("previousValue");

                    if (previousValue === "checked") {
                        this.checked = false;
                        this.setAttribute("previousValue", "false");
                    } else {
                        document.querySelectorAll("input[id^='" + lastcl.split('-')[0] + "']").forEach(el => {
                            el.setAttribute("previousValue", "false");
                        });

                        this.setAttribute("previousValue", "checked");
                    }
                });
            });
        </script>
    @endpush
</div>
