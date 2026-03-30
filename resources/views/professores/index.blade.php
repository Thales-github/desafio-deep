@extends('layouts.app')

@section('title', 'Lista de Professores')

@section('content')
<div class="container-fluid">
    <div class="card shadow-lg border-0">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="bi bi-person-workspace me-2"></i> Lista de Professores
            </h5>
            <a href="{{ route('professores.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle me-1"></i> Novo Professor
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped" id="professoresTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Telefone</th>
                            <th>Formação</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($professores as $professor)
                        <tr>
                            <td>{{ $professor['id'] ?? '-' }}</td>
                            <td>{{ $professor['nome'] ?? '-' }}</td>
                            <td>{{ $professor['email'] ?? '-' }}</td>
                            <td>{{ $professor['telefone'] ?? '-' }}</td>
                            <td>
                                @php
                                $formacao = [
                                0 => 'Graduação',
                                1 => 'Pós-graduação',
                                2 => 'Mestrado',
                                3 => 'Doutorado'
                                ];
                                @endphp
                                {{ $formacao[$professor['nivel_formacao'] ?? 0] ?? 'Graduação' }}
                            </td>
                            <td>
                                @if(($professor['ativo'] ?? 0) == 1)
                                <span class="badge bg-success">Ativo</span>
                                @else
                                <span class="badge bg-danger">Inativo</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('professores.show', $professor['id'] ?? 0) }}" class="btn btn-sm btn-info text-white" title="Detalhar">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('professores.edit', $professor['id'] ?? 0) }}" class="btn btn-sm btn-warning" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger btn-delete"
                                        data-id="{{ $professor['id'] ?? 0 }}"
                                        data-name="{{ $professor['nome'] ?? '' }}"
                                        title="Excluir">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Nenhum professor cadastrado</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar Exclusão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir o professor?</p>
                <strong id="deleteName"></strong>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="deleteForm" method="POST">
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
        $('#professoresTable').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json'
            },
            order: [
                [1, 'asc']
            ],
            pageLength: 10,
            columnDefs: [{
                orderable: false,
                targets: 6
            }]
        });

        $('.btn-delete').on('click', function() {
            const id = $(this).data('id');
            const name = $(this).data('name');

            $('#deleteName').text(name);
            $('#deleteForm').attr('action', `/professores/${id}`);

            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            modal.show();
        });
    });
</script>
@endpush
