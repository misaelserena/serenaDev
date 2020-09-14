<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width, height=device-height, target-densitydpi=device-dpi" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ADGLOBAL MANAGEMENT</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/styles-login.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
</head> 
<body class="fondo">
    <div class="container-login">
        <div class="div-log">
            <div class="div-form-group">
                <form method="POST" action="{{ route('password.request') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <center><h3><b>Cambiar Contraseña</b></h3></center>
                    <div id="container-data">
                        <div>
                            <p>
                                <label for="email" class="label-form">Correo Electrónico</label>
                                <input id="email" type="email" class="input-text-large form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email or old('email') }}" required autofocus placeholder="Ingrese su correo electrónico">

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </p>
                            <p>
                                <label for="password" class="label-form">Nueva Contraseña</label>
                                <input id="password" type="password" class="input-text-large form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="Ingrese su nueva contraseña">

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </p>
                            <p>
                                <label for="password-confirm" class="label-form">Confirmar Contraseña</label>
                                 <input id="password-confirm" type="password" class="input-text-large form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" name="password_confirmation" required placeholder="Confirmar contraseña">

                                @if ($errors->has('password_confirmation'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </p>
                        </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-red">
                                Cambiar Contraseña
                            </button>
                        </div>
                    </div>
                </form>
        </div>
    </div>
</div>
</body>
</html>
