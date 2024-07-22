@extends('adminlte::page')

@section('title', 'Perfil')

@section('content_header')
    <h1>Perfil</h1>
@stop

@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Información de Perfil</h2>
                    </div>
                    <div class="card-body">
                        @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                            @livewire('profile.update-profile-information-form')
                        @endif
                    </div>
                </div>

                @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                    <div class="card mt-4">
                        <div class="card-header">
                            <h2 class="card-title">Cambiar Contraseña</h2>
                        </div>
                        <div class="card-body">
                            @livewire('profile.update-password-form')
                        </div>
                    </div>
                @endif

                @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                    <div class="card mt-4">
                        <div class="card-header">
                            <h2 class="card-title">Autenticación de Dos Factores</h2>
                        </div>
                        <div class="card-body">
                            @livewire('profile.two-factor-authentication-form')
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Cerrar Sesiones en Otros Navegadores</h2>
                    </div>
                    <div class="card-body">
                        @livewire('profile.logout-other-browser-sessions-form')
                    </div>
                </div>

                @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                    <div class="card mt-4">
                        <div class="card-header">
                            <h2 class="card-title">Eliminar Cuenta</h2>
                        </div>
                        <div class="card-body">
                            @livewire('profile.delete-user-form')
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        console.log('Hi!');
    </script>
@stop
