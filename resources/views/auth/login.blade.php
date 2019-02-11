@extends('layouts.frontend', ['title' => 'Login | Tablero de control público de seguimiento del PA15.'])

<!-- FORMULARIO DE ACCESO -->
@section('content')
@include('frontend_nav')
<main role="main" class="main">
    <section id="alianza">
        <div class="container">
            <div class="row">
                <header class="main-header">
                    <h1 class="first-word-bold">
                        <strong>Ingresa</strong> al Tablero de Compromisos
                    </h1>
                </header>
                <section class="section-page">
                    <div class="row">
                        <div class="col-md-4 col-md-offset-4">
                            <article>                            
                                <div class="post-entry">
                                        @if ($errors->has('email'))
                                            <div class="alert alert-danger" align="center" role="alert">
                                                <span class="invalid-feedback">
                                                    <h4><strong>{{ $errors->first('email') }}</strong></h4>
                                                </span>
                                            </div>                                        
                                        @endif
                                    <form class="form-signin" method="POST" action="{{ route('login') }}">
                                        {{ csrf_field() }}
                                        <p>
                                            <label for="username">Correo:</label><br/>
                                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus> 
                                        </p>
                                        <p>
                                            @if ($errors->has('password'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                            @endif
                                            <label for="password">Contraseña:</label><br/>
                                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                                        </p>
                                        <p>
                                            <input type="submit" class="btn btn-lg btn-primary btn-block" value="Acceder">
                                        </p>
                                    </form>
                                </div>
                            </article>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
</main>
@stop
