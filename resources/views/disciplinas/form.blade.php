@extends('layouts.app')

@section('title', isset($disciplina) ? 'Editar Disciplina' : 'Nova Disciplina')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">{{ isset($disciplina) ? 'Editar Disciplina' : 'Nova Disciplina' }}</h5>
            </div>
            <div class="card-body">
                @php $id = $disciplina['id'] ?? null; @endphp
                <form method="POST" action="{{ $id ? route('disciplinas.update', $id) : route('disciplinas.store') }}">
                    @csrf
                    @if($id) @method('PUT') @endif

                    <div class="mb-3">
                        <label class="form-label">Nome *</label>
                        <input type="text" class="form-control" name="nome" value="{{ old('nome', $disciplina['nome'] ?? '') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descricao</label>
                        <textarea class="form-control" name="descricao">{{ old('descricao', $disciplina['descricao'] ?? '') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Professor *</label>
                        <select class="form-select" name="professor_id" required>
                            <option value="">Selecione</option>
                            @foreach($professores as $professor)
                            <option value="{{ $professor['id'] }}"
                                {{ (string) old('professor_id', $disciplina['professor_id'] ?? '') === (string) $professor['id'] ? 'selected' : '' }}>
                                {{ $professor['nome'] }} (ID {{ $professor['id'] }})
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <a href="{{ route('disciplinas.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Salvar</button>
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
                alert(xhr.responseJSON?.message || 'Erro ao salvar disciplina');
            }
        });
    });
</script>
@endpush
