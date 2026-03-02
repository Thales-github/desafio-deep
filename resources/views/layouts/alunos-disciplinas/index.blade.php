@extends('layouts.app')

@section('title', 'Lista de Matrículas')

@push('styles')
<style>
    .table-actions {
        white-space: nowrap;
        width: 1%;
    }

    .status-badge {
        padding: 0.35rem 0.65rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
    }

    .nota-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 1rem;
    }

    .nota-alta {
        background-color: #d1e7dd;
        color: #0f5132;
    }

    .nota-media {
        background-color: #fff3cd;
        color: #856404;
    }

    .nota-baixa {
        background-color: #f8d7da;
        color: #842029;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="bi bi-journal-bookmark-fill text-primary me-2"></i>
                Lista de Matrículas
            </h5>
            <a href="{{ route('aluno-disciplina.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i>
                Nova Matrícula
            </a>
        </div>

        <div class="card-body">
            <!-- Filtros Avançados -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card bg-light border-0">
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label">Filtrar por Aluno</label>
                                    <select class="form-select" id="filtroAluno">
                                        <option value="">Todos os Alunos</option>
                                        @foreach($alunos ?? [] as $aluno)
                                        <option value="{{ $aluno['id'] }}">{{ $aluno['nome'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Filtrar por Disciplina</label>
                                    <select class="form-select" id="filtroDisciplina">
                                        <option value="">Todas as Disciplinas</option>
                                        @foreach($disciplinas ?? [] as $disciplina)
                                        <option value="{{ $disciplina['id'] }}">{{ $disciplina['nome'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Status</label>
                                    <select class="form-select" id="filtroStatus">
                                        <option value="">Todos</option>
                                        <option value="cursando">Cursando</option>
                                        <option value="aprovado">Aprovado</option>
                                        <option value="reprovado">Reprovado</option>
                                        <option value="trancado">Trancado</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Período</label>
                                    <select class="form-select" id="filtroPeriodo">
                                        <option value="">Todos</option>
                                        <option value="2024.1">2024.1</option>
                                        <option value="2024.2">2024.2</option>
                                        <option value="2025.1">2025.1</option>
                                    </select>
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="button" class="btn btn-outline-secondary w-100" id="limparFiltros">
                                        <i class="bi bi-eraser me-1"></i>
                                        Limpar Filtros
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle" id="matriculasTable">
                    <thead class="table-light">
                        <tr>
                            <th width="50">ID</th>
                            <th>Aluno</th>
                            <th>Disciplina</th>
                            <th>Professor</th>
                            <th>Período</th>
                            <th>Notas</th>
                            <th>Média</th>
                            <th>Frequência</th>
                            <th>Status</th>
                            <th width="120">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($matriculas as $matricula)
                        <tr>
                            <td><span class="badge bg-light text-dark">{{ $matricula['id'] }}</span></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-person-circle text-secondary me-2 fs-5"></i>
                                    <div>
                                        <strong>{{ $matricula['aluno']['nome'] }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $matricula['aluno']['cpf'] }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <strong>{{ $matricula['disciplina']['nome'] }}</strong>
                                    <br>
                                    <small class="text-muted">Cód: {{ $matricula['disciplina']['codigo'] ?? 'N/A' }}</small>
                                </div>
                            </td>
                            <td>
                                @if(!empty($matricula['disciplina']['professor']))
                                <div>
                                    <i class="bi bi-person-badge text-secondary me-1"></i>
                                    {{ $matricula['disciplina']['professor']['nome'] }}
                                </div>
                                @else
                                <span class="text-muted">Não atribuído</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-secondary">
                                    {{ $matricula['periodo'] ?? 'N/A' }}
                                </span>
                            </td>
                            <td>
                                @php
                                $notas = $matricula['notas'] ?? [];
                                $media = $matricula['media'] ?? 0;
                                @endphp
                                <div class="d-flex gap-1">
                                    @foreach($notas as $index => $nota)
                                    <span class="badge bg-light text-dark border" title="Nota {{ $index + 1 }}">
                                        N{{ $index + 1 }}: {{ number_format($nota['valor'] ?? $nota, 1) }}
                                    </span>
                                    @endforeach
                                    @if(count($notas) == 0)
                                    <span class="text-muted">-</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @if($media > 0)
                                <div class="d-flex align-items-center">
                                    <div class="nota-circle 
                                            @if($media >= 7) nota-alta
                                            @elseif($media >= 5) nota-media
                                            @else nota-baixa
                                            @endif me-2">
                                        {{ number_format($media, 1) }}
                                    </div>
                                </div>
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @php
                                $frequencia = $matricula['frequencia'] ?? 0;
                                @endphp
                                <div class="d-flex align-items-center">
                                    <span class="me-2">{{ $frequencia }}%</span>
                                    <div class="progress flex-grow-1" style="height: 5px;">
                                        <div class="progress-bar bg-{{ $frequencia >= 75 ? 'success' : ($frequencia >= 50 ? 'warning' : 'danger') }}"
                                            style="width: {{ $frequencia }}%"></div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @switch($matricula['status'] ?? 'cursando')
                                @case('aprovado')
                                <span class="badge bg-success status-badge">
                                    <i class="bi bi-check-circle me-1"></i>Aprovado
                                </span>
                                @break
                                @case('reprovado')
                                <span class="badge bg-danger status-badge">
                                    <i class="bi bi-x-circle me-1"></i>Reprovado
                                </span>
                                @break
                                @case('cursando')
                                <span class="badge bg-warning status-badge">
                                    <i class="bi bi-hourglass-split me-1"></i>Cursando
                                </span>
                                @break
                                @case('trancado')
                                <span class="badge bg-secondary status-badge">
                                    <i class="bi bi-pause-circle me-1"></i>Trancado
                                </span>
                                @break
                                @default
                                <span class="badge bg-warning status-badge">Cursando</span>
                                @endswitch
                            </td>
                            <td class="table-actions">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('aluno-disciplina.show', $matricula['id']) }}"
                                        class="btn btn-sm btn-outline-info"
                                        title="Visualizar"
                                        data-bs-toggle="tooltip">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('aluno-disciplina.edit', $matricula['id']) }}"
                                        class="btn btn-sm btn-outline-warning"
                                        title="Editar"
                                        data-bs-toggle="tooltip">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button"
                                        class="btn btn-sm btn-outline-danger btn-delete"
                                        data-id="{{ $matricula['id'] }}"
                                        data-aluno="{{ $matricula['aluno']['nome'] }}"
                                        data-disciplina="{{ $matricula['disciplina']['nome'] }}"
                                        title="Excluir"
                                        data-bs-toggle="tooltip">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center py-5">
                                <i class="bi bi-journal-x display-1 text-muted"></i>
                                <p class="text-muted fs-5 mt-3">Nenhuma matrícula encontrada</p>
                                <a href="{{ route('aluno-disciplina.create') }}" class="btn btn-primary">
                                    <i class="bi bi-plus-circle me-1"></i>
                                    Realizar Primeira Matrícula
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Resumo Estatístico -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="bg-light p-3 rounded">
                        <div class="row text-center">
                            <div class="col-md-2">
                                <span class="d-block fs-4 fw-bold text-primary">{{ count($matriculas) }}</span>
                                <small class="text-muted">Total Matrículas</small>
                            </div>
                            <div class="col-md-2">
                                <span class="d-block fs-4 fw-bold text-success">
                                    {{ collect($matriculas)->where('status', 'aprovado')->count() }}
                                </span>
                                <small class="text-muted">Aprovados</small>
                            </div>
                            <div class="col-md-2">
                                <span class="d-block fs-4 fw-bold text-danger">
                                    {{ collect($matriculas)->where('status', 'reprovado')->count() }}
                                </span>
                                <small class="text-muted">Reprovados</small>
                            </div>
                            <div class="col-md-2">
                                <span class="d-block fs-4 fw-bold text-warning">
                                    {{ collect($matriculas)->where('status', 'cursando')->count() }}
                                </span>
                                <small class="text-muted">Cursando</small>
                            </div>
                            <div class="col-md-2">
                                <span class="d-block fs-4 fw-bold text-info">
                                    {{ collect($matriculas)->where('status', 'trancado')->count() }}
                                </span>
                                <small class="text-muted">Trancados</small>
                            </div>
                            <div class="col-md-2">
                                <span class="d-block fs-4 fw-bold text-secondary">
                                    {{ number_format(collect($matriculas)->avg('media'), 1) }}
                                </span>
                                <small class="text-muted">Média Geral</small>
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
                <p>Tem certeza que deseja excluir esta matrícula?</p>
                <div class="bg-light p-3 rounded">
                    <strong id="deleteAluno"></strong>
                    <br>
                    <small class="text-muted" id="deleteDisciplina"></small>
                </div>
                <p class="text-danger mt-3 mb-0">
                    <i class="bi bi-info-circle me-1"></i>
                    Esta ação não pode ser desfeita e removerá todas as notas e registros de frequência.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i>
                        Excluir Matrícula
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
        var table = $('#matriculasTable').DataTable({
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
                targets: 9
            }]
        });

        // Filtros customizados
        $('#filtroAluno').on('change', function() {
            table.column(1).search(this.value).draw();
        });

        $('#filtroDisciplina').on('change', function() {
            table.column(2).search(this.value).draw();
        });

        $('#filtroStatus').on('change', function() {
            table.column(8).search(this.value).draw();
        });

        $('#filtroPeriodo').on('change', function() {
            table.column(4).search(this.value).draw();
        });

        $('#limparFiltros').on('click', function() {
            $('#filtroAluno, #filtroDisciplina, #filtroStatus, #filtroPeriodo').val('');
            table.search('').columns().search('').draw();
        });

        // Modal de exclusão
        $('.btn-delete').on('click', function() {
            const id = $(this).data('id');
            const aluno = $(this).data('aluno');
            const disciplina = $(this).data('disciplina');

            $('#deleteAluno').text('Aluno: ' + aluno);
            $('#deleteDisciplina').text('Disciplina: ' + disciplina);
            $('#deleteForm').attr('action', `/aluno-disciplina/${id}`);

            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        });
    });
</script>
@endpush