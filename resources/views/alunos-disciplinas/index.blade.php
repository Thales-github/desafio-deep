@extends('layouts.app')

@section('title', 'Lista de Matriculas')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Lista de Matriculas</h5>
        <a href="{{ route('alunos-disciplinas.create') }}" class="btn btn-primary btn-sm">Nova Matricula</a>
    </div>
    <div class="card-body">
        <table class="table table-striped" id="matriculasTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Aluno</th>
                    <th>Disciplina</th>
                    <th>Status</th>
                    <th>Nota Final</th>
                    <th>Faltas</th>
                    <th>Acoes</th>
                </tr>
            </thead>
            <tbody>
                @foreach($matriculas as $matricula)
                <tr>
                    <td>{{ $matricula['id'] ?? '-' }}</td>
                    <td>{{ $matricula['aluno']['nome'] ?? ($matricula['aluno_id'] ?? '-') }}</td>
                    <td>{{ $matricula['disciplina']['nome'] ?? ($matricula['disciplina_id'] ?? '-') }}</td>
                    <td>{{ $matricula['status'] ?? '-' }}</td>
                    <td>{{ $matricula['nota_final'] ?? '-' }}</td>
                    <td>{{ $matricula['faltas'] ?? '-' }}</td>
                    <td>
                        <a href="{{ route('alunos-disciplinas.show', $matricula['id']) }}" class="btn btn-info btn-sm text-white">Ver</a>
                        <a href="{{ route('alunos-disciplinas.edit', $matricula['id']) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('alunos-disciplinas.destroy', $matricula['id']) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(function() {
        $('#matriculasTable').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json'
            }
        });
    });
</script>
@endpush
