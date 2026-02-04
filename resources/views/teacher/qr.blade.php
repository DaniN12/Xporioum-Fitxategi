@extends('layouts.teacher', ['title' => __('message.t_qr_title')])

@section('content')
<div class="max-w-4xl mx-auto text-center">

    <h1 class="text-3xl font-extrabold text-slate-800 mb-8">
        {{ __('message.t_qr_heading') }}
    </h1>

    <div class="bg-white shadow-xl rounded-3xl p-10 border border-gray-100">

        {{-- Contenedor animable: pequeño en pausa, grande en activo --}}
        <div id="qrWrapper"
             class="mx-auto overflow-hidden transition-all duration-500 ease-in-out"
             style="max-height: 0px; opacity: 0;">

            <div id="qrContainer" class="flex flex-col items-center mb-6 pt-2">

                <div class="w-full max-w-md mx-auto mb-4">
                    <div class="h-3 bg-slate-200 rounded-full overflow-hidden">
                        <div id="timerBar" class="h-3 bg-emerald-500 w-full"></div>
                    </div>
                </div>

                <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200">
                    <div id="qrcode" style="width:260px;height:260px;"></div>
                </div>
            </div>
        </div>

        <p id="status" class="text-lg font-semibold mb-6">
            <span id="statusDot" class="text-gray-500">● {{ __('message.t_qr_status_paused') }}</span>
        </p>

        <div class="flex justify-center gap-4">
            <button id="startBtn"
                class="px-6 py-3 rounded-full font-bold text-white
                       bg-indigo-600 hover:bg-indigo-700 transition shadow-lg">
                {{ __('message.t_qr_start') }}
            </button>

            <button id="stopBtn"
                class="px-6 py-3 rounded-full font-bold bg-slate-100 text-slate-700 hover:bg-slate-200 transition hidden">
                {{ __('message.t_qr_pause') }}
            </button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>

<script>
let intervalQR = null;
let redTimeout = null;

const qrWrapper = document.getElementById('qrWrapper');
const statusDot = document.getElementById('statusDot');
const startBtn = document.getElementById('startBtn');
const stopBtn = document.getElementById('stopBtn');
const timerBar = document.getElementById('timerBar');

function expandir() {
    qrWrapper.style.maxHeight = "420px";
    qrWrapper.style.opacity = "1";
}

function colapsar() {
    qrWrapper.style.maxHeight = "0px";
    qrWrapper.style.opacity = "0";
}

async function generarQR() {
    const res = await fetch("{{ route('teacher.qr.api') }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Content-Type": "application/json"
        }
    });

    const data = await res.json();

    document.getElementById("qrcode").innerHTML = "";

    new QRCode(document.getElementById("qrcode"), {
        text: data.url,
        width: 260,
        height: 260
    });

    animarBarra();
}

function animarBarra() {
    if (redTimeout) clearTimeout(redTimeout);

    timerBar.style.transition = "none";
    timerBar.style.width = "100%";
    timerBar.classList.remove("bg-red-500");
    timerBar.classList.add("bg-emerald-500");

    statusDot.textContent = "● " + @js(__('message.t_qr_status_active'));
    statusDot.classList.remove("text-red-600", "text-gray-500");
    statusDot.classList.add("text-emerald-600");

    void timerBar.offsetWidth;

    timerBar.style.transition = "width 20s linear";
    timerBar.style.width = "0%";

    redTimeout = setTimeout(() => {
        timerBar.classList.remove("bg-emerald-500");
        timerBar.classList.add("bg-red-500");
        statusDot.classList.remove("text-emerald-600");
        statusDot.classList.add("text-red-600");
        statusDot.textContent = "● " + @js(__('message.t_qr_status_changing'));
    }, 15000);
}

startBtn.addEventListener('click', () => {
    expandir();

    startBtn.classList.add('hidden');
    stopBtn.classList.remove('hidden');

    generarQR();
    intervalQR = setInterval(generarQR, 20000);
});

stopBtn.addEventListener('click', () => {
    clearInterval(intervalQR);
    if (redTimeout) clearTimeout(redTimeout);

    colapsar();

    timerBar.style.transition = "none";
    timerBar.style.width = "100%";
    timerBar.classList.remove("bg-red-500");
    timerBar.classList.add("bg-emerald-500");

    startBtn.classList.remove('hidden');
    stopBtn.classList.add('hidden');

    statusDot.textContent = "● " + @js(__('message.t_qr_status_paused'));
    statusDot.classList.remove("text-emerald-600", "text-red-600");
    statusDot.classList.add("text-gray-500");
});
</script>
@endsection
