@extends('layouts.app')

@section('title', 'Lista de Disciplinas')

@push('styles')
<style>
    .table-actions {
        white-space: nowrap;
        width: 1%;
    }

    .carga-horaria-badge {
        background-color: #e3f2fd;
        color: #0d6efd;
        padding: 0.35rem 0.65rem;
        border-radius: 20px;
        font-weight: 500;
        font-size: 0.875rem;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="bi bi-book-fill text-primary me-2"></i>
                Lista de Disciplinas
            </h5>
            <a href="{{ route('disciplinas.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i>
                Nova Disciplina
            </a>
        </div>

        <div class="card-body">
            <!-- Filtros rápidos -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-primary active" data-filter="all">
                            <i class="bi bi-grid-3x3-gap-fill me-1"></i>Todos
                        </button>
                        <button type="button" class="btn btn-outline-primary" data-filter="40h">
                            <i class="bi bi-clock me-1"></i>40h
                        </button>
                        <button type="button" class="btn btn-outline-primary" data-filter="60h">
                            <i class="bi bi-clock me-1"></i>60h
                        </button>
                        <button type="button" class="btn btn-outline-primary" data-filter="80h">
                            <i class="bi bi-clock me-1"></i>80h
                        </button>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle" id="disciplinasTable">
                    <thead class="table-light">
                        <tr>
                            <th width="50">ID</th>
                            <th>Código</th>
                            <th>Disciplina</th>
                            <th>Professor</th>
                            <th>Carga Horária</th>
                            <th>Período</th>
                            <th>Alunos</th>
                            <th>Status</th>
                            <th width="120">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($disciplinas as $disciplina)
                        <tr>
                            <td><span class="badge bg-light text-dark">{{ $disciplina['id'] }}</span></td>
                            <td>
                                <strong>{{ $disciplina['codigo'] ?? 'N/A' }}</strong>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 p-2 rounded me-2">
                                        <i class="bi bi-journal-bookmark-fill text-primary"></i>
                                    </div>
                                    <div>
                                        <strong>{{ $disciplina['nome'] }}</strong>
                                        @if(!empty($disciplina['descricao']))
                                        <br>
                                        <small class="text-muted">{{ Str::limit($disciplina['descricao'], 50) }}</small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if(!empty($disciplina['professor']))
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-person-badge text-secondary me-1"></i>
                                    {{ $disciplina['professor']['nome'] }}
                                </div>
                                @else
                                <span class="text-muted">
                                    <i class="bi bi-person-slash me-1"></i>
                                    Não atribuído
                                </span>
                                @endif
                            </td>
                            <td>
                                <span class="carga-horaria-badge">
                                    <i class="bi bi-clock me-1"></i>
                                    {{ $disciplina['carga_horaria'] }}h
                                </span>
                            </td>
                            <td>
                                @if(!empty($disciplina['periodo']))
                                {{ $disciplina['periodo'] }}º Período
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-info">
                                    <i class="bi bi-people me-1"></i>
                                    {{ $disciplina['total_alunos'] ?? 0 }}
                                </span>
                            </td>
                            <td>
                                @if(($disciplina['status'] ?? 'ativo') == 'ativo')
                                <span class="badge bg-success">
                                    <i class="bi bi-check-circle me-1"></i>Ativa
                                </span>
                                @else
                                <span class="badge bg-danger">
                                    <i class="bi bi-x-circle me-1"></i>Inativa
                                </span>
                                @endif
                            </td>
                            <td class="table-actions">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('disciplinas.show', $disciplina['id']) }}"
                                        class="btn btn-sm btn-outline-info"
                                        title="Visualizar"
                                        data-bs-toggle="tooltip">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('disciplinas.edit', $disciplina['id']) }}"
                                        class="btn btn-sm btn-outline-warning"
                                        title="Editar"
                                        data-bs-toggle="tooltip">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button"
                                        class="btn btn-sm btn-outline-danger btn-delete"
                                        data-id="{{ $disciplina['id'] }}"
                                        data-name="{{ $disciplina['nome'] }}"
                                        data-codigo="{{ $disciplina['codigo'] ?? '' }}"
                                        title="Excluir"
                                        data-bs-toggle="tooltip">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-5">
                                <i class="bi bi-journal-x display-1 text-muted"></i>
                                <p class="text-muted fs-5 mt-3">Nenhuma disciplina cadastrada</p>
                                <a href="{{ route('disciplinas.create') }}" class="btn btn-primary">
                                    <i class="bi bi-plus-circle me-1"></i>
                                    Cadastrar Primeira Disciplina
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Resumo -->
            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="bg-light p-3 rounded">
                        <div class="row text-center">
                            <div class="col-md-3">
                                <span class="d-block fs-4 fw-bold text-primary">{{ count($disciplinas) }}</span>
                                <small class="text-muted">Total de Disciplinas</small>
                            </div>
                            <div class="col-md-3">
                                <span class="d-block fs-4 fw-bold text-success">
                                    {{ collect($disciplinas)->where('status', 'ativo')->count() }}
                                </span>
                                <small class="text-muted">Disciplinas Ativas</small>
                            </div>
                            <div class="col-md-3">
                                <span class="d-block fs-4 fw-bold text-info">
                                    {{ collect($disciplinas)->sum('total_alunos') ?? 0 }}
                                </span>
                                <small class="text-muted">Total de Matrículas</small>
                            </div>
                            <div class="col-md-3">
                                <span class="d-block fs-4 fw-bold text-warning">
                                    {{ collect($disciplinas)->avg('carga_horaria') ? number_format(collect($disciplinas)->avg('carga_horaria'), 0) : 0 }}h
                                </span>
                                <small class="text-muted">Média Carga Horária</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmação de Exclusão -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-exclamation-triangle-fill text-warning me-2"></i>
                    Confirmar Exclusão
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir a disciplina?</p>
                <div class="bg-light p-3 rounded">
                    <strong id="deleteName"></strong>
                    <br>
                    <small class="text-muted" id="deleteCodigo"></small>
                </div>
                <p class="text-danger mt-3 mb-0">
                    <i class="bi bi-info-circle me-1"></i>
                    Esta ação não pode ser desfeita e pode afetar matrículas existentes.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i>
                        Excluir Disciplina
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Inicializar tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Inicializar DataTable
        $('#disciplinasTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json'
            },
            order: [
                [2, 'asc']
            ],
            pageLength: 10,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "Todos"]
            ],
            columnDefs: [{
                orderable: false,
                targets: 8
            }]
        });

        // Filtros rápidos
        $('[data-filter]').on('click', function() {
            $('[data-filter]').removeClass('active');
            $(this).addClass('active');

            var filter = $(this).data('filter');
            var table = $('#disciplinasTable').DataTable();

            if (filter === 'all') {
                table.search('').columns().search('').draw();
            } else {
                var carga = filter.replace('h', '');
                table.column(4).search(carga).draw();
            }
        });

        // Modal de exclusão
        $('.btn-delete').on('click', function() {
            const id = $(this).data('id');
            const name = $(this).data('name');
            const codigo = $(this).data('codigo');

            $('#deleteName').text(name);
            $('#deleteCodigo').text('Código: ' + (codigo || 'N/A'));
            $('#deleteForm').attr('action', `/disciplinas/${id}`);

            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        });
    });
</script>
@endpush