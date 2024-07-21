<!doctype html>
<html lang="en">

<head>
    <title>FERROMARKET</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="auth/css/style.css">

</head>

<body>
    @php($login_url = View::getSection('login_url') ?? config('adminlte.login_url', 'login'))
    @php($register_url = View::getSection('register_url') ?? config('adminlte.register_url', 'register'))

    @if (config('adminlte.use_route_url', false))
        @php($login_url = $login_url ? route($login_url) : '')
        @php($register_url = $register_url ? route($register_url) : '')
    @else
        @php($login_url = $login_url ? url($login_url) : '')
        @php($register_url = $register_url ? url($register_url) : '')
    @endif
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 text-center mb-5">
                    <h2 class="heading-section">FERROMARKET SYSTEM</h2>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-7 col-lg-5">
                    <div class="login-wrap p-4 p-md-5">
                        <div class="icon d-flex align-items-center justify-content-center">
                            <span class="fa fa-user-o"></span>
                        </div>
                        <h3 class="text-center mb-4">Registrarse</h3>
                        <form action="{{ $register_url }}" method="post" class="login-form">
                            @csrf
                            {{-- name --}}
                            <div class="form-group">
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                    placeholder="{{ __('adminlte::adminlte.full_name') }}" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            {{-- email --}}
                            <div class="form-group">
                                <input type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}" placeholder="{{ __('adminlte::adminlte.email') }}">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            {{-- Contraseña --}}
                            <div class="form-group d-flex">
                                <input type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="{{ __('adminlte::adminlte.password') }}">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            {{-- Repetir Contraseña --}}
                            <div class="form-group d-flex">
                                <input type="password" name="password_confirmation"
                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                    placeholder="{{ __('adminlte::adminlte.retype_password') }}">

                                @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            {{-- boton --}}
                            <div class="form-group">
                                <button type="submit"
                                    class="form-control btn btn-primary rounded submit px-3 {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}">{{ __('adminlte::adminlte.register') }}</button>
                            </div>
                                {{-- ya estoy registrado --}}
                                <div class="w-60 text-md-center">
                                    <p class="my-0">
                                        <a href="{{ $login_url }}">
                                            {{ __('adminlte::adminlte.i_already_have_a_membership') }}
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="auth/js/jquery.min.js"></script>
    <script src="auth/js/popper.js"></script>
    <script src="auth/js/bootstrap.min.js"></script>
    <script src="auth/js/main.js"></script>

</body>

</html>
