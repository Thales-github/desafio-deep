@extends('layouts.app')

@section('title', 'Detalhes da Disciplina')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between">
        <h5 class="mb-0">Detalhes da Disciplina</h5>
        <a href="{{ route('disciplinas.index') }}" class="btn btn-outline-secondary btn-sm">Voltar</a>
    </div>
    <div class="card-body">
        <p><strong>ID:</strong> {{ $disciplina['id'] ?? '-' }}</p>
        <p><strong>Nome:</strong> {{ $disciplina['nome'] ?? '-' }}</p>
        <p><strong>Descricao:</strong> {{ $disciplina['descricao'] ?? '-' }}</p>
        <p><strong>Professor ID:</strong> {{ $disciplina['professor_id'] ?? '-' }}</p>
    </div>
</div>
@endsection
