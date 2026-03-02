@extends('layouts.app')

@section('title', 'Lista de Professores')

@push('styles')
<style>
    .table-actions {
        white-space: nowrap;
        width: 1%;
    }

    .professor-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #e9ecef;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6c757d;
        font-weight: bold;
        font-size: 1.2rem;
    }

    .especializacao-badge {
        background-color: #e7f1ff;
        color: #0d6efd;
        padding: 0.35rem 0.65rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="bi bi-people-fill text-primary me-2"></i>
                Lista de Professores
            </h5>
            <a href="{{ route('professores.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i>
                Novo Professor
            </a>
        </div>

        <div class="card-body">
            <!-- Filtros -->
            <div class="row mb-4">
                <div class="col-md-8">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-primary active" data-filter="all">
                            <i class="bi bi-grid-3x3-gap-fill me-1"></i>Todos
                        </button>
                        <button type="button" class="btn btn-outline-primary" data-filter="ativo">
                            <i class="bi bi-check-circle me-1"></i>Ativos
                        </button>
                        <button type="button" class="btn btn-outline-primary" data-filter="inativo">
                            <i class="bi bi-x-circle me-1"></i>Inativos
                        </button>
                        <button type="button" class="btn btn-outline-primary" data-filter="com_disciplinas">
                            <i class="bi bi-book me-1"></i>Com Disciplinas
                        </button>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" class="form-control" id="searchInput" placeholder="Buscar professor...">
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle" id="professoresTable">
                    <thead class="table-light">
                        <tr>
                            <th width="50">ID</th>
                            <th>Professor</th>
                            <th>Contato</th>
                            <th>Especialização</th>
                            <th>Disciplinas</th>
                            <th>Status</th>
                            <th width="120">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($professores as $professor)
                        <tr>
                            <td><span class="badge bg-light text-dark">{{ $professor['id'] }}</span></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="professor-avatar me-2">
                                        {{ strtoupper(substr($professor['nome'], 0, 2)) }}
                                    </div>
                                    <div>
                                        <strong>{{ $professor['nome'] }}</strong>
                                        <br>
                                        <small class="text-muted">Registro: {{ $professor['registro'] ?? 'N/A' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <i class="bi bi-envelope text-secondary me-1"></i>
                                    <small>{{ $professor['email'] }}</small>
                                </div>
                                <div>
                                    <i class="bi bi-telephone text-secondary me-1"></i>
                                    <small>{{ $professor['telefone'] }}</small>
                                </div>
                            </td>
                            <td>
                                @if(!empty($professor['especializacao']))
                                <span class="especializacao-badge">
                                    <i class="bi bi-mortarboard me-1"></i>
                                    {{ $professor['especializacao'] }}
                                </span>
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-info">
                                    <i class="bi bi-book me-1"></i>
                                    {{ count($professor['disciplinas'] ?? []) }}
                                </span>
                            </td>
                            <td>
                                @if(($professor['status'] ?? 'ativo') == 'ativo')
                                <span class="badge bg-success">
                                    <i class="bi bi-check-circle me-1"></i>Ativo
                                </span>
                                @else
                                <span class="badge bg-danger">
                                    <i class="bi bi-x-circle me-1"></i>Inativo
                                </span>
                                @endif
                            </td>
                            <td class="table-actions">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('professores.show', $professor['id']) }}"
                                        class="btn btn-sm btn-outline-info"
                                        title="Visualizar"
                                        data-bs-toggle="tooltip">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('professores.edit', $professor['id']) }}"
                                        class="btn btn-sm btn-outline-warning"
                                        title="Editar"
                                        data-bs-toggle="tooltip">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button"
                                        class="btn btn-sm btn-outline-danger btn-delete"
                                        data-id="{{ $professor['id'] }}"
                                        data-name="{{ $professor['nome'] }}"
                                        data-registro="{{ $professor['registro'] ?? '' }}"
                                        title="Excluir"
                                        data-bs-toggle="tooltip">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="bi bi-people display-1 text-muted"></i>
                                <p class="text-muted fs-5 mt-3">Nenhum professor cadastrado</p>
                                <a href="{{ route('professores.create') }}" class="btn btn-primary">
                                    <i class="bi bi-plus-circle me-1"></i>
                                    Cadastrar Primeiro Professor
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
                                <span class="d-block fs-4 fw-bold text-primary">{{ count($professores) }}</span>
                                <small class="text-muted">Total de Professores</small>
                            </div>
                            <div class="col-md-3">
                                <span class="d-block fs-4 fw-bold text-success">
                                    {{ collect($professores)->where('status', 'ativo')->count() }}
                                </span>
                                <small class="text-muted">Professores Ativos</small>
                            </div>
                            <div class="col-md-3">
                                <span class="d-block fs-4 fw-bold text-info">
                                    {{ collect($professores)->filter(function($p) { return count($p['disciplinas'] ?? []) > 0; })->count() }}
                                </span>
                                <small class="text-muted">Com Disciplinas</small>
                            </div>
                            <div class="col-md-3">
                                <span class="d-block fs-4 fw-bold text-warning">
                                    {{ collect($professores)->sum(function($p) { return count($p['disciplinas'] ?? []); }) }}
                                </span>
                                <small class="text-muted">Total de Disciplinas</small>
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
                <p>Tem certeza que deseja excluir o professor?</p>
                <div class="bg-light p-3 rounded">
                    <strong id="deleteName"></strong>
                    <br>
                    <small class="text-muted" id="deleteRegistro"></small>
                </div>
                <p class="text-danger mt-3 mb-0">
                    <i class="bi bi-info-circle me-1"></i>
                    Esta ação não pode ser desfeita. Se houver disciplinas vinculadas, elas ficarão sem professor.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i>
                        Excluir Professor
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
        var table = $('#professoresTable').DataTable({
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
            ],
            columnDefs: [{
                orderable: false,
                targets: 6
            }]
        });

        // Filtro customizado
        $('#searchInput').on('keyup', function() {
            table.search(this.value).draw();
        });

        // Filtros rápidos
        $('[data-filter]').on('click', function() {
            $('[data-filter]').removeClass('active');
            $(this).addClass('active');

            var filter = $(this).data('filter');

            if (filter === 'all') {
                table.search('').columns().search('').draw();
            } else if (filter === 'ativo') {
                table.column(5).search('Ativo').draw();
            } else if (filter === 'inativo') {
                table.column(5).search('Inativo').draw();
            } else if (filter === 'com_disciplinas') {
                $.fn.dataTable.ext.search.push(
                    function(settings, data, dataIndex) {
                        return parseInt(data[4]) > 0;
                    }
                );
                table.draw();
                $.fn.dataTable.ext.search.pop();
            }
        });

        // Modal de exclusão
        $('.btn-delete').on('click', function() {
            const id = $(this).data('id');
            const name = $(this).data('name');
            const registro = $(this).data('registro');

            $('#deleteName').text(name);
            $('#deleteRegistro').text('Registro: ' + (registro || 'N/A'));
            $('#deleteForm').attr('action', `/professores/${id}`);

            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        });
    });
</script>
@endpush