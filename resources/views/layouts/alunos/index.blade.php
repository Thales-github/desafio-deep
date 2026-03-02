@extends('layouts.app')

@section('title', 'Lista de Alunos')

@push('styles')
<style>
    .table-actions {
        white-space: nowrap;
        width: 1%;
    }

    .btn-action {
        padding: 0.25rem 0.5rem;
        margin: 0 0.125rem;
    }
</style>
@endpush

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="bi bi-people-fill text-primary"></i> Lista de Alunos
        </h5>
        <a href="{{ route('alunos.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-circle"></i> Novo Aluno
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="alunosTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>CPF</th>
                        <th>Data Nasc.</th>
                        <th>Telefone</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($alunos as $aluno)
                    <tr>
                        <td>{{ $aluno['id'] }}</td>
                        <td>{{ $aluno['nome'] }}</td>
                        <td>{{ $aluno['email'] }}</td>
                        <td>{{ $aluno['cpf'] }}</td>
                        <td>{{ \Carbon\Carbon::parse($aluno['data_nascimento'])->format('d/m/Y') }}</td>
                        <td>{{ $aluno['telefone'] }}</td>
                        <td>
                            @if($aluno['status'] === 'ativo')
                            <span class="badge bg-success">Ativo</span>
                            @else
                            <span class="badge bg-danger">Inativo</span>
                            @endif
                        </td>
                        <td class="table-actions">
                            <a href="{{ route('alunos.show', $aluno['id']) }}"
                                class="btn btn-info btn-action"
                                title="Visualizar">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('alunos.edit', $aluno['id']) }}"
                                class="btn btn-warning btn-action"
                                title="Editar">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <button type="button"
                                class="btn btn-danger btn-action btn-delete"
                                data-id="{{ $aluno['id'] }}"
                                data-name="{{ $aluno['nome'] }}"
                                title="Excluir">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4">
                            <i class="bi bi-inbox display-4 d-block text-muted"></i>
                            <p class="text-muted mb-0">Nenhum aluno cadastrado</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal de Confirmação de Exclusão -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar Exclusão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir o aluno <strong id="deleteName"></strong>?</p>
                <p class="text-danger mb-0"><small>Esta ação não pode ser desfeita.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Excluir</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Inicializar DataTable
        $('#alunosTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json'
            },
            order: [
                [1, 'asc']
            ],
            pageLength: 10,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "Todos"]
            ]
        });

        // Modal de exclusão
        $('.btn-delete').on('click', function() {
            const id = $(this).data('id');
            const name = $(this).data('name');

            $('#deleteName').text(name);
            $('#deleteForm').attr('action', `/alunos/${id}`);

            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        });
    });
</script>
@endpush