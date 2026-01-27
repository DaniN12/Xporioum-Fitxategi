<x-app-layout>
    <div class="max-w-xl mx-auto">
        <h1 class="text-2xl font-bold mb-4">Fichaje diario</h1>

        @if(session('success'))
            <div class="alert alert-success mb-3">
                {{ session('success') }}
            </div>
        @endif

        @if($todayAttendance && $todayAttendance->exit_time)
            <p class="text-green-600 font-semibold">
                Ya has completado el fichaje de hoy
            </p>
        @else
            <form method="POST" action="{{ route('student.punch') }}">
                @csrf
                <button class="btn btn-primary w-full">
                    {{ $todayAttendance ? 'Fichar salida' : 'Fichar entrada' }}
                </button>
            </form>
        @endif
    </div>
</x-app-layout>
