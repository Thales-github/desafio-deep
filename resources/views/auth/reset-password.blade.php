@extends('layouts.guest')

@section('title', 'Nova senha')

@section('content')
<div class="card auth-card">
    <div class="card-header-custom">
        <h1><i class="bi bi-shield-lock me-2"></i>Nova senha</h1>
        <p>Defina uma nova senha para sua conta.</p>
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

        <form method="POST" action="{{ route('password.update') }}" class="d-flex flex-column gap-3">
            @csrf
            <input type="hidden" name="token" value="{{ request()->route('token') }}">

            <div>
                <label for="email" class="form-label">E-mail</label>
                <input type="email" name="email" id="email" value="{{ old('email', request('email')) }}"
                    class="form-control form-control-lg @error('email') is-invalid @enderror"
                    required autocomplete="username">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="password" class="form-label">Nova senha</label>
                <input type="password" name="password" id="password"
                    class="form-control form-control-lg @error('password') is-invalid @enderror"
                    required autocomplete="new-password">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="form-label">Confirmar senha</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                    class="form-control form-control-lg" required autocomplete="new-password">
            </div>

            <button type="submit" class="btn btn-primary btn-auth-primary btn-lg w-100 text-white">
                Redefinir senha
            </button>
        </form>
    </div>
</div>
@endsection
