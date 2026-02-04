@extends('layouts.alumno', ['title' => __('message.rules_title')])

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="max-w-5xl mx-auto">
  <div class="bg-white rounded-2xl shadow p-6 md:p-8">

    <div class="flex items-start justify-between gap-4">
      <div>
        <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight text-gray-900">
          Documento de normas
        </h1>
        <p class="text-gray-500 mt-2">
          Este documento recoge las condiciones de uso y el procedimiento de fichaje.
        </p>
      </div>

      <span id="estadoFirma"
        class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-sm font-semibold border
        {{ !empty($firmado) && $firmado ? 'bg-green-50 text-green-700 border-green-200' : 'bg-amber-50 text-amber-700 border-amber-200' }}">
        <span class="w-2 h-2 rounded-full {{ !empty($firmado) && $firmado ? 'bg-green-500' : 'bg-amber-500' }}"></span>
        {{ !empty($firmado) && $firmado ? 'Completado' : 'Pendiente' }}
      </span>
    </div>

    <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-6">

      <div class="lg:col-span-2">
        <div class="bg-gray-50 border rounded-2xl p-5 md:p-6">
          <h2 class="text-lg font-extrabold text-gray-900">Documento</h2>

          <iframe src="{{ asset('norma/Contrato.pdf') }}"
                  class="w-full h-[600px] mt-4 border rounded-xl">
          </iframe>
        </div>
      </div>

      <div>
        <div class="bg-white border rounded-2xl p-5 md:p-6 shadow-sm">
          <h2 class="text-lg font-extrabold text-gray-900">Acciones</h2>
          <p class="text-gray-500 mt-2">Elige una opción:</p>

          <div class="mt-5 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-3">
            <button type="button"
              class="w-full py-3 rounded-xl font-extrabold text-white bg-indigo-600 hover:bg-indigo-700 transition"
              onclick="openSignature()">
              Firmar
            </button>

            <button type="button"
              class="w-full py-3 rounded-xl font-extrabold bg-gray-100 hover:bg-gray-200 transition"
              onclick="window.print()">
              Descargar
            </button>
          </div>

          <div class="mt-4 bg-gray-50 border rounded-xl p-4 text-sm text-gray-600">
            <span class="font-bold">Nota:</span>
            Al firmar guardaremos el PDF firmado en Mis documentos.
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<div id="signatureModal"
     class="fixed inset-0 bg-black bg-opacity-40 hidden items-center justify-center z-50">
  <div class="bg-white rounded-2xl p-6 w-full max-w-lg shadow-xl">
    <h2 class="text-xl font-bold mb-4">Firmar documento</h2>

    <canvas id="signaturePad" class="border rounded-xl w-full h-64 bg-gray-50"></canvas>

    <div class="flex justify-between mt-4 gap-3">
      <button onclick="clearSignature()"
              class="px-4 py-2 bg-gray-200 rounded-lg font-bold w-1/2">
        Limpiar
      </button>

      <button onclick="saveSignature()"
              class="px-4 py-2 bg-indigo-600 text-white rounded-lg font-bold w-1/2">
        Guardar firma
      </button>
    </div>
  </div>
</div>

<script>
let canvas, ctx;
let drawing = false;

function openSignature() {
  document.getElementById('signatureModal').classList.remove('hidden');
  setTimeout(resizeCanvas, 0);
}

function clearSignature() {
  if (!ctx) return;
  ctx.clearRect(0, 0, canvas.width, canvas.height);
  const rect = canvas.getBoundingClientRect();
  ctx.fillStyle = "#f9fafb";
  ctx.fillRect(0, 0, rect.width, rect.height);
}

function getPos(e) {
  const rect = canvas.getBoundingClientRect();

  if (e.touches && e.touches.length) {
    return { x: e.touches[0].clientX - rect.left, y: e.touches[0].clientY - rect.top };
  }

  return { x: e.clientX - rect.left, y: e.clientY - rect.top };
}

function startDraw(e) {
  e.preventDefault();
  drawing = true;
  const p = getPos(e);
  ctx.beginPath();
  ctx.moveTo(p.x, p.y);
}

function draw(e) {
  if (!drawing) return;
  e.preventDefault();
  const p = getPos(e);
  ctx.lineWidth = 3;
  ctx.lineCap = "round";
  ctx.strokeStyle = "#000";
  ctx.lineTo(p.x, p.y);
  ctx.stroke();
}

function endDraw(e) {
  if (!drawing) return;
  e.preventDefault();
  drawing = false;
  ctx.closePath();
}

function resizeCanvas() {
  if (!canvas || !ctx) return;

  const rect = canvas.getBoundingClientRect();
  const ratio = window.devicePixelRatio || 1;
  const temp = canvas.toDataURL();

  canvas.width = Math.floor(rect.width * ratio);
  canvas.height = Math.floor(rect.height * ratio);

  ctx.setTransform(ratio, 0, 0, ratio, 0, 0);

  ctx.fillStyle = "#f9fafb";
  ctx.fillRect(0, 0, rect.width, rect.height);

  const img = new Image();
  img.onload = () => ctx.drawImage(img, 0, 0, rect.width, rect.height);
  img.src = temp;
}

async function saveSignature() {
  const pixels = ctx.getImageData(0, 0, canvas.width, canvas.height).data;
  let hasInk = false;
  for (let i = 0; i < pixels.length; i += 4) {
    if (pixels[i+3] !== 0) { hasInk = true; break; }
  }
  if (!hasInk) {
    alert("Firma vacía. Dibuja tu firma primero.");
    return;
  }

  const signatureData = canvas.toDataURL("image/png");

  const res = await fetch("{{ route('normas.firmar') }}", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
      "Accept": "application/json"
    },
    body: JSON.stringify({ signature: signatureData })
  });

  const raw = await res.text();
  let data = {};
  try { data = JSON.parse(raw); } catch (e) {}

  if (!res.ok) {
    console.log("STATUS:", res.status);
    console.log("RAW:", raw);
    alert(data.message || ("Error al firmar (status " + res.status + "). Mira consola F12"));
    return;
  }

  document.getElementById('estadoFirma').innerHTML = `
    <span class="w-2 h-2 rounded-full bg-green-500"></span>
    Completado
  `;
  document.getElementById('estadoFirma').className =
    "inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-sm font-semibold border bg-green-50 text-green-700 border-green-200";

  document.getElementById('signatureModal').classList.add('hidden');

  window.location.href = "{{ route('cuenta.documentos') }}";
}

window.addEventListener("load", () => {
  canvas = document.getElementById("signaturePad");
  ctx = canvas.getContext("2d");

  resizeCanvas();

  canvas.addEventListener("mousedown", startDraw);
  canvas.addEventListener("mousemove", draw);
  window.addEventListener("mouseup", endDraw);

  canvas.addEventListener("touchstart", startDraw, { passive: false });
  canvas.addEventListener("touchmove", draw, { passive: false });
  canvas.addEventListener("touchend", endDraw, { passive: false });

  window.addEventListener("resize", resizeCanvas);
});
</script>

<style>
  @media print {
    aside, nav, header, .no-print { display: none !important; }
    body { background: white !important; }
    main { padding: 0 !important; }
  }
</style>

@endsection
