@extends('layouts.guest')

@section('title', 'Recuperar senha')

@section('content')
<div class="card auth-card">
    <div class="card-header-custom">
        <h1><i class="bi bi-key me-2"></i>Esqueci a senha</h1>
        <p>Informe seu e-mail para receber o link de redefinição.</p>
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

        <form method="POST" action="{{ route('password.email') }}" class="d-flex flex-column gap-3">
            @csrf
            <div>
                <label for="email" class="form-label">E-mail</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}"
                    class="form-control form-control-lg @error('email') is-invalid @enderror"
                    required autofocus placeholder="nome@exemplo.com">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary btn-auth-primary btn-lg w-100 text-white">
                Enviar link
            </button>
        </form>

        <p class="text-center text-muted auth-footer-link mb-0 mt-4">
            <a href="{{ route('login') }}" class="fw-semibold text-decoration-none">Voltar ao login</a>
        </p>
    </div>
</div>
@endsection
