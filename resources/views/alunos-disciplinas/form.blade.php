@extends('layouts.app')

@section('title', isset($matricula) ? 'Editar Matricula' : 'Nova Matricula')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">{{ isset($matricula) ? 'Editar Matricula' : 'Nova Matricula' }}</h5>
            </div>
            <div class="card-body">
                @php $id = $matricula['id'] ?? null; @endphp
                <form method="POST" action="{{ $id ? route('alunos-disciplinas.update', $id) : route('alunos-disciplinas.store') }}">
                    @csrf
                    @if($id) @method('PUT') @endif

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Aluno *</label>
                            <select class="form-select" name="aluno_id" required>
                                <option value="">Selecione</option>
                                @foreach($alunos as $aluno)
                                <option value="{{ $aluno['id'] }}"
                                    {{ (string) old('aluno_id', $matricula['aluno_id'] ?? '') === (string) $aluno['id'] ? 'selected' : '' }}>
                                    {{ $aluno['nome'] }} (ID {{ $aluno['id'] }})
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Disciplina *</label>
                            <select class="form-select" name="disciplina_id" required>
                                <option value="">Selecione</option>
                                @foreach($disciplinas as $disciplina)
                                <option value="{{ $disciplina['id'] }}"
                                    {{ (string) old('disciplina_id', $matricula['disciplina_id'] ?? '') === (string) $disciplina['id'] ? 'selected' : '' }}>
                                    {{ $disciplina['nome'] }} (ID {{ $disciplina['id'] }})
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Data Matricula</label>
                            <input type="date" class="form-control" name="data_matricula" value="{{ old('data_matricula', isset($matricula['data_matricula']) ? substr((string) $matricula['data_matricula'], 0, 10) : '') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status">
                                <option value="1" {{ (string) old('status', $matricula['status'] ?? '1') === '1' ? 'selected' : '' }}>Cursando</option>
                                <option value="2" {{ (string) old('status', $matricula['status'] ?? '') === '2' ? 'selected' : '' }}>Aprovado</option>
                                <option value="3" {{ (string) old('status', $matricula['status'] ?? '') === '3' ? 'selected' : '' }}>Reprovado</option>
                                <option value="4" {{ (string) old('status', $matricula['status'] ?? '') === '4' ? 'selected' : '' }}>Trancado</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Nota</label>
                            <input type="number" min="0" max="10" step="0.1" class="form-control" name="nota_final" value="{{ old('nota_final', $matricula['nota_final'] ?? '') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Faltas</label>
                            <input type="number" min="0" class="form-control" name="faltas" value="{{ old('faltas', $matricula['faltas'] ?? '') }}">
                        </div>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('alunos-disciplinas.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $('form').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            success: function(response) {
                if (response.success) window.location.href = response.redirect;
            },
            error: function(xhr) {
                alert(xhr.responseJSON?.message || 'Erro ao salvar matricula');
            }
        });
    });
</script>
@endpush
