@extends('layouts.app')

@section('title', 'Lista de Disciplinas')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Lista de Disciplinas</h5>
        <a href="{{ route('disciplinas.create') }}" class="btn btn-primary btn-sm">Nova Disciplina</a>
    </div>
    <div class="card-body">
        <table class="table table-striped" id="disciplinasTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Descricao</th>
                    <th>Professor ID</th>
                    <th>Acoes</th>
                </tr>
            </thead>
            <tbody>
                @foreach($disciplinas as $disciplina)
                <tr>
                    <td>{{ $disciplina['id'] ?? '-' }}</td>
                    <td>{{ $disciplina['nome'] ?? '-' }}</td>
                    <td>{{ $disciplina['descricao'] ?? '-' }}</td>
                    <td>{{ $disciplina['professor_id'] ?? '-' }}</td>
                    <td>
                        <a href="{{ route('disciplinas.show', $disciplina['id']) }}" class="btn btn-info btn-sm text-white">Ver</a>
                        <a href="{{ route('disciplinas.edit', $disciplina['id']) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('disciplinas.destroy', $disciplina['id']) }}" method="POST" class="d-inline">
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
        $('#disciplinasTable').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json'
            }
        });
    });
</script>
@endpush
