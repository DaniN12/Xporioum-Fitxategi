@extends('layout.masterpage')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endsection

@section('content')

<div class="login-wrapper">
    <div class="container">
        <div class="row justify-content-center align-items-center">

            {{-- COLUMNA IZQUIERDA: LOGO --}}
            <div class="col-md-6 d-flex justify-content-center">
                <div class="logo-left">
                    <img src="{{ asset('img/logo-fitxategi.png') }}" alt="Logo Fitxategi">
                </div>
            </div>

            {{-- COLUMNA DERECHA: FORMULARIO --}}
            <div class="col-md-6">
                <div class="card login-card">

                    <div class="card-header-custom text-center">
                        <h4>Bienvenido a Fitxategi</h4>
                    </div>

                    <div class="card-body">

                        {{-- ERRORES DE LOGIN --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            {{-- EMAIL --}}
                            <div class="mb-3 input-icon-wrapper">
                                <label class="col-form-label">Email</label>
                                <input type="email"
                                       name="email"
                                       class="form-control"
                                         value="{{ old('email') }}"
                                       required>

                                <img src="{{ asset('img/correo.png') }}"
                                     class="input-icon"
                                     alt="Icono correo">
                            </div>

                            {{-- PASSWORD --}}
                            <div class="mb-3 input-icon-wrapper">
                                <label class="col-form-label">Contraseña</label>

                                <input type="password"
                                       id="password"
                                       name="contrasena"
                                       class="form-control"
                                       required>

                                <img src="{{ asset('img/ojo.png') }}"
                                     alt="Mostrar contraseña"
                                     id="togglePassword"
                                     class="input-icon"
                                     data-ojo="{{ asset('img/ojo.png') }}"
                                     data-ojo-cerrado="{{ asset('img/ojo-cerrado.png') }}">
                            </div>

                            <div class="d-grid">
                                <button class="btn btn-primary-custom">Entrar</button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="{{ asset('js/login.js') }}"></script>
@endsection
