<x-app-layout>
    <h1 class="text-2xl font-bold mb-4">Nuevo alumno</h1>

    <form method="POST" action="{{ route('teacher.students.store') }}">
        @csrf
        <input name="name" class="form-control mb-2" placeholder="Nombre" required>
        <input name="email" type="email" class="form-control mb-2" placeholder="Email" required>
        <input name="password" type="password" class="form-control mb-2" placeholder="Contraseña" required>
        <button class="btn btn-primary">Guardar</button>
    </form>
</x-app-layout>
