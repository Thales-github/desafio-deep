@extends('layouts.guest')

@section('title', 'Entrar')

@section('content')
<div class="card auth-card">
    <div class="card-header-custom">
        <h1><i class="bi bi-box-arrow-in-right me-2"></i>Entrar</h1>
        <p>Use seu e-mail e senha para acessar o sistema.</p>
    </div>
    <div class="card-body">
        @if (session('status'))
            <div class="alert alert-success small mb-3">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger small mb-3">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login.store') }}" class="d-flex flex-column gap-3">
            @csrf

            <div>
                <label for="email" class="form-label">E-mail</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}"
                    class="form-control form-control-lg @error('email') is-invalid @enderror"
                    required autofocus autocomplete="username" placeholder="nome@exemplo.com">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <label for="password" class="form-label mb-0">Senha</label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="small text-decoration-none">Esqueci a senha</a>
                    @endif
                </div>
                <input type="password" name="password" id="password"
                    class="form-control form-control-lg @error('password') is-invalid @enderror"
                    required autocomplete="current-password" placeholder="••••••••">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" value="1"
                    {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">Manter conectado</label>
            </div>

            <button type="submit" class="btn btn-primary btn-auth-primary btn-lg w-100 text-white">
                Entrar
            </button>
        </form>

        @if (Route::has('register'))
            <p class="text-center text-muted auth-footer-link mb-0 mt-4">
                Não tem uma conta?
                <a href="{{ route('register') }}" class="fw-semibold text-decoration-none">Cadastre-se</a>
            </p>
        @endif
    </div>
</div>
@endsection
