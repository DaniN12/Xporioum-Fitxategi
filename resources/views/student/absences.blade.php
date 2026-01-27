<x-app-layout>
    <h1 class="text-2xl font-bold mb-4">Justificar ausencia</h1>

    <form method="POST" enctype="multipart/form-data" action="{{ route('student.absences.store') }}">
        @csrf
        <input type="date" name="date" class="form-control mb-2" required>
        <textarea name="reason" class="form-control mb-2" placeholder="Motivo" required></textarea>
        <input type="file" name="document" class="form-control mb-2">
        <button class="btn btn-primary">Enviar</button>
    </form>
</x-app-layout>
