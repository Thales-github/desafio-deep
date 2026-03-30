@extends('layouts.app')

@section('title', 'Detalhes da Matricula')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between">
        <h5 class="mb-0">Detalhes da Matricula</h5>
        <a href="{{ route('alunos-disciplinas.index') }}" class="btn btn-outline-secondary btn-sm">Voltar</a>
    </div>
    <div class="card-body">
        <p><strong>ID:</strong> {{ $matricula['id'] ?? '-' }}</p>
        <p><strong>Aluno:</strong> {{ $matricula['aluno']['nome'] ?? ($matricula['aluno_id'] ?? '-') }}</p>
        <p><strong>Disciplina:</strong> {{ $matricula['disciplina']['nome'] ?? ($matricula['disciplina_id'] ?? '-') }}</p>
        <p><strong>Data Matricula:</strong> {{ $matricula['data_matricula'] ?? '-' }}</p>
        <p><strong>Status:</strong> {{ $matricula['status'] ?? '-' }}</p>
        <p><strong>Nota Final:</strong> {{ $matricula['nota_final'] ?? '-' }}</p>
        <p><strong>Faltas:</strong> {{ $matricula['faltas'] ?? '-' }}</p>
    </div>
</div>
@endsection
