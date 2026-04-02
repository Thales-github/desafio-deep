@extends('layouts.guest')

@section('title', 'Cadastro')

@section('content')
<div class="card auth-card">
    <div class="card-header-custom">
        <h1><i class="bi bi-person-plus me-2"></i>Criar conta</h1>
        <p>Preencha os dados abaixo para se cadastrar.</p>
    </div>
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger small mb-3">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register.store') }}" class="d-flex flex-column gap-3">
            @csrf

            <div>
                <label for="name" class="form-label">Nome completo</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}"
                    class="form-control form-control-lg @error('name') is-invalid @enderror"
                    required autocomplete="name" placeholder="Seu nome">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="email" class="form-label">E-mail</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}"
                    class="form-control form-control-lg @error('email') is-invalid @enderror"
                    required autocomplete="email" placeholder="nome@exemplo.com">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="password" class="form-label">Senha</label>
                <input type="password" name="password" id="password"
                    class="form-control form-control-lg @error('password') is-invalid @enderror"
                    required autocomplete="new-password" placeholder="Mínimo conforme regras do sistema">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">Use letras, números e símbolos (requisitos padrão do Laravel).</div>
            </div>

            <div>
                <label for="password_confirmation" class="form-label">Confirmar senha</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                    class="form-control form-control-lg" required autocomplete="new-password"
                    placeholder="Repita a senha">
            </div>

            <button type="submit" class="btn btn-primary btn-auth-primary btn-lg w-100 text-white">
                Cadastrar
            </button>
        </form>

        <p class="text-center text-muted auth-footer-link mb-0 mt-4">
            Já tem uma conta?
            <a href="{{ route('login') }}" class="fw-semibold text-decoration-none">Entrar</a>
        </p>
    </div>
</div>
@endsection
