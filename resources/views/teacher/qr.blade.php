<x-app-layout>
    <h1 class="text-2xl font-bold mb-4">QR de fichaje</h1>

    <div class="bg-white p-4 rounded shadow text-center">
        {!! $qr !!}
        <p class="mt-3 text-sm text-gray-500">
            QR válido durante 5 minutos
        </p>
    </div>
</x-app-layout>
