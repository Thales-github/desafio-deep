@extends('layouts.app')

@section('title', 'Detalhes da Disciplina')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <!-- Cabeçalho com ações -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">
                    <i class="bi bi-book-fill text-primary me-2"></i>
                    Detalhes da Disciplina
                </h4>
                <div>
                    <a href="{{ route('disciplinas.edit', $disciplina['id']) }}" class="btn btn-warning">
                        <i class="bi bi-pencil me-1"></i>
                        Editar
                    </a>
                    <a href="{{ route('disciplinas.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i>
                        Voltar
                    </a>
                </div>
            </div>

            <!-- Card Principal -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <!-- Header da Disciplina -->
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 p-3 rounded me-3">
                                    <i class="bi bi-journal-bookmark-fill text-primary fs-1"></i>
                                </div>
                                <div>
                                    <h2 class="mb-1">{{ $disciplina['nome'] }}</h2>
                                    <div class="d-flex gap-3">
                                        <span class="badge bg-secondary">
                                            <i class="bi bi-upc-scan me-1"></i>
                                            Código: {{ $disciplina['codigo'] ?? 'N/A' }}
                                        </span>
                                        @if(($disciplina['status'] ?? 'ativo') == 'ativo')
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle me-1"></i>Ativa
                                        </span>
                                        @else
                                        <span class="badge bg-danger">
                                            <i class="bi bi-x-circle me-1"></i>Inativa
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row g-2">
                                <div class="col-6">
                                    <div class="bg-light rounded p-3 text-center">
                                        <div class="fs-3 fw-bold text-primary">{{ $disciplina['carga_horaria'] }}h</div>
                                        <small class="text-muted">Carga Horária</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="bg-light rounded p-3 text-center">
                                        <div class="fs-3 fw-bold text-success">{{ $total_alunos ?? 0 }}</div>
                                        <small class="text-muted">Alunos Matriculados</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Grid de Informações -->
                    <div class="row">
                        <!-- Coluna Esquerda -->
                        <div class="col-md-6">
                            <!-- Informações Básicas -->
                            <div class="card border-0 bg-light mb-3">
                                <div class="card-body">
                                    <h6 class="text-primary mb-3">
                                        <i class="bi bi-info-circle me-2"></i>
                                        Informações Básicas
                                    </h6>
                                    <table class="table table-sm table-borderless">
                                        <tr>
                                            <td width="40%" class="text-muted">Código:</td>
                                            <td><strong>{{ $disciplina['codigo'] ?? 'Não informado' }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Nome:</td>
                                            <td><strong>{{ $disciplina['nome'] }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Carga Horária:</td>
                                            <td><strong>{{ $disciplina['carga_horaria'] }} horas</strong></td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Período:</td>
                                            <td>
                                                @if(!empty($disciplina['periodo']))
                                                <strong>{{ $disciplina['periodo'] }}º Período</strong>
                                                @else
                                                <span class="text-muted">Não definido</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Status:</td>
                                            <td>
                                                @if(($disciplina['status'] ?? 'ativo') == 'ativo')
                                                <span class="badge bg-success">Ativa</span>
                                                @else
                                                <span class="badge bg-danger">Inativa</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Data de Criação:</td>
                                            <td><small>{{ \Carbon\Carbon::parse($disciplina['created_at'] ?? now())->format('d/m/Y H:i') }}</small></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <!-- Professor Responsável -->
                            <div class="card border-0 bg-light mb-3">
                                <div class="card-body">
                                    <h6 class="text-primary mb-3">
                                        <i class="bi bi-person-badge me-2"></i>
                                        Professor Responsável
                                    </h6>

                                    @if(!empty($disciplina['professor']))
                                    <div class="d-flex align-items-center">
                                        <div class="bg-white rounded-circle p-2 me-3">
                                            <i class="bi bi-person-circle fs-1 text-secondary"></i>
                                        </div>
                                        <div>
                                            <h5 class="mb-1">{{ $disciplina['professor']['nome'] }}</h5>
                                            <p class="mb-0 text-muted">
                                                <i class="bi bi-envelope me-1"></i>
                                                {{ $disciplina['professor']['email'] }}
                                            </p>
                                            @if(!empty($disciplina['professor']['telefone']))
                                            <p class="mb-0 text-muted">
                                                <i class="bi bi-telephone me-1"></i>
                                                {{ $disciplina['professor']['telefone'] }}
                                            </p>
                                            @endif
                                            @if(!empty($disciplina['professor']['especializacao']))
                                            <p class="mb-0 text-muted">
                                                <i class="bi bi-mortarboard me-1"></i>
                                                {{ $disciplina['professor']['especializacao'] }}
                                            </p>
                                            @endif
                                        </div>
                                    </div>
                                    @else
                                    <div class="text-center py-3">
                                        <i class="bi bi-person-slash fs-1 text-muted"></i>
                                        <p class="text-muted mb-2">Nenhum professor atribuído</p>
                                        <a href="{{ route('disciplinas.edit', $disciplina['id']) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-plus-circle me-1"></i>
                                            Atribuir Professor
                                        </a>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Coluna Direita -->
                        <div class="col-md-6">
                            <!-- Descrição/Ementa -->
                            <div class="card border-0 bg-light mb-3">
                                <div class="card-body">
                                    <h6 class="text-primary mb-3">
                                        <i class="bi bi-file-text me-2"></i>
                                        Descrição / Ementa
                                    </h6>
                                    @if(!empty($disciplina['descricao']))
                                    <p class="mb-0" style="white-space: pre-line;">{{ $disciplina['descricao'] }}</p>
                                    @else
                                    <p class="text-muted text-center py-3">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Nenhuma descrição cadastrada
                                    </p>
                                    @endif
                                </div>
                            </div>

                            <!-- Pré-requisitos -->
                            <div class="card border-0 bg-light mb-3">
                                <div class="card-body">
                                    <h6 class="text-primary mb-3">
                                        <i class="bi bi-diagram-3 me-2"></i>
                                        Pré-requisitos
                                    </h6>

                                    @if(!empty($disciplina['requisitos']) && count($disciplina['requisitos']) > 0)
                                    <div class="list-group">
                                        @foreach($disciplina['requisitos'] as $requisito)
                                        <div class="list-group-item bg-white d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>{{ $requisito['codigo'] ?? 'N/A' }}</strong>
                                                <span class="ms-2">{{ $requisito['nome'] }}</span>
                                            </div>
                                            <div>
                                                <span class="badge bg-info me-2">{{ $requisito['carga_horaria'] ?? 0 }}h</span>
                                                <a href="{{ route('disciplinas.show', $requisito['id']) }}"
                                                    class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    @else
                                    <div class="text-center py-3">
                                        <i class="bi bi-check-circle text-success fs-1"></i>
                                        <p class="text-muted mb-0">Não possui pré-requisitos</p>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Disciplinas que dependem desta -->
                            @if(!empty($disciplina['dependentes']) && count($disciplina['dependentes']) > 0)
                            <div class="card border-0 bg-light mb-3">
                                <div class="card-body">
                                    <h6 class="text-warning mb-3">
                                        <i class="bi bi-diagram-2 me-2"></i>
                                        Disciplinas que dependem desta
                                    </h6>
                                    <div class="list-group">
                                        @foreach($disciplina['dependentes'] as $dependente)
                                        <div class="list-group-item bg-white d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>{{ $dependente['codigo'] ?? 'N/A' }}</strong>
                                                <span class="ms-2">{{ $dependente['nome'] }}</span>
                                            </div>
                                            <a href="{{ route('disciplinas.show', $dependente['id']) }}"
                                                class="btn btn-sm btn-outline-warning">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Estatísticas da Disciplina -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card border-0 bg-primary bg-opacity-10">
                                <div class="card-body">
                                    <h6 class="text-primary mb-3">
                                        <i class="bi bi-graph-up me-2"></i>
                                        Estatísticas da Disciplina
                                    </h6>
                                    <div class="row text-center">
                                        <div class="col-md-3">
                                            <div class="p-3">
                                                <span class="d-block fs-2 fw-bold text-success">{{ $estatisticas['aprovados'] ?? 0 }}</span>
                                                <small class="text-muted">Aprovados</small>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="p-3">
                                                <span class="d-block fs-2 fw-bold text-danger">{{ $estatisticas['reprovados'] ?? 0 }}</span>
                                                <small class="text-muted">Reprovados</small>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="p-3">
                                                <span class="d-block fs-2 fw-bold text-warning">{{ $estatisticas['cursando'] ?? 0 }}</span>
                                                <small class="text-muted">Cursando</small>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="p-3">
                                                <span class="d-block fs-2 fw-bold text-info">{{ $estatisticas['media_notas'] ?? 0 }}</span>
                                                <small class="text-muted">Média Geral</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Alunos Matriculados -->
                    <div class="mt-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0">
                                <i class="bi bi-people-fill text-primary me-2"></i>
                                Alunos Matriculados ({{ count($alunos_matriculados ?? []) }})
                            </h5>
                            <a href="{{ route('aluno-disciplina.create', ['disciplina_id' => $disciplina['id']]) }}"
                                class="btn btn-primary btn-sm">
                                <i class="bi bi-plus-circle me-1"></i>
                                Nova Matrícula
                            </a>
                        </div>

                        @if(!empty($alunos_matriculados) && count($alunos_matriculados) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Matrícula</th>
                                        <th>Aluno</th>
                                        <th>Data Matrícula</th>
                                        <th>Frequência</th>
                                        <th>Notas</th>
                                        <th>Média</th>
                                        <th>Status</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($alunos_matriculados as $matricula)
                                    <tr>
                                        <td>
                                            <span class="badge bg-light text-dark">
                                                {{ $matricula['matricula'] ?? $matricula['id'] }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-person-circle text-secondary me-2"></i>
                                                <div>
                                                    <strong>{{ $matricula['aluno']['nome'] }}</strong>
                                                    <br>
                                                    <small class="text-muted">{{ $matricula['aluno']['cpf'] }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($matricula['data_matricula'] ?? $matricula['created_at'])->format('d/m/Y') }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <span class="me-2">{{ $matricula['frequencia'] ?? 0 }}%</span>
                                                <div class="progress flex-grow-1" style="height: 5px;">
                                                    <div class="progress-bar bg-{{ ($matricula['frequencia'] ?? 0) >= 75 ? 'success' : 'warning' }}"
                                                        style="width: {{ $matricula['frequencia'] ?? 0 }}%"></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if(!empty($matricula['notas']))
                                            @foreach($matricula['notas'] as $nota)
                                            <span class="badge bg-secondary">N{{ $loop->iteration }}: {{ number_format($nota['valor'], 1) }}</span>
                                            @endforeach
                                            @else
                                            <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(!empty($matricula['media']))
                                            <strong class="text-{{ $matricula['media'] >= 6 ? 'success' : 'danger' }}">
                                                {{ number_format($matricula['media'], 1) }}
                                            </strong>
                                            @else
                                            <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @switch($matricula['status'] ?? 'cursando')
                                            @case('aprovado')
                                            <span class="badge bg-success">Aprovado</span>
                                            @break
                                            @case('reprovado')
                                            <span class="badge bg-danger">Reprovado</span>
                                            @break
                                            @case('cursando')
                                            <span class="badge bg-warning">Cursando</span>
                                            @break
                                            @case('trancado')
                                            <span class="badge bg-secondary">Trancado</span>
                                            @break
                                            @default
                                            <span class="badge bg-warning">Cursando</span>
                                            @endswitch
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('aluno-disciplina.edit', $matricula['id']) }}"
                                                    class="btn btn-sm btn-outline-warning"
                                                    title="Editar matrícula">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <a href="{{ route('alunos.show', $matricula['aluno']['id']) }}"
                                                    class="btn btn-sm btn-outline-info"
                                                    title="Ver aluno">
                                                    <i class="bi bi-person"></i>
                                                </a>
                                                <button type="button"
                                                    class="btn btn-sm btn-outline-danger btn-remover-matricula"
                                                    data-id="{{ $matricula['id'] }}"
                                                    data-aluno="{{ $matricula['aluno']['nome'] }}"
                                                    title="Remover matrícula">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="text-center py-5 bg-light rounded">
                            <i class="bi bi-people display-1 text-muted"></i>
                            <p class="text-muted fs-5 mt-3">Nenhum aluno matriculado nesta disciplina</p>
                            <a href="{{ route('aluno-disciplina.create', ['disciplina_id' => $disciplina['id']]) }}"
                                class="btn btn-primary">
                                <i class="bi bi-plus-circle me-1"></i>
                                Realizar Matrícula
                            </a>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Rodapé com informações de auditoria -->
                <div class="card-footer bg-white">
                    <div class="row">
                        <div class="col-md-6">
                            <small class="text-muted">
                                <i class="bi bi-clock-history me-1"></i>
                                Cadastrado em: {{ \Carbon\Carbon::parse($disciplina['created_at'] ?? now())->format('d/m/Y H:i:s') }}
                            </small>
                        </div>
                        <div class="col-md-6 text-end">
                            <small class="text-muted">
                                <i class="bi bi-arrow-repeat me-1"></i>
                                Última atualização: {{ \Carbon\Carbon::parse($disciplina['updated_at'] ?? now())->format('d/m/Y H:i:s') }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmação para remover matrícula -->
<div class="modal fade" id="modalRemoverMatricula" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-exclamation-triangle-fill text-warning me-2"></i>
                    Confirmar Remoção
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja remover a matrícula do aluno <strong id="alunoNome"></strong>?</p>
                <p class="text-danger mb-0">
                    <i class="bi bi-info-circle me-1"></i>
                    Esta ação não pode ser desfeita e removerá todas as notas e registros de frequência.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="formRemoverMatricula" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i>
                        Remover Matrícula
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
        // Tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Modal de remoção de matrícula
        $('.btn-remover-matricula').on('click', function() {
            const id = $(this).data('id');
            const alunoNome = $(this).data('aluno');

            $('#alunoNome').text(alunoNome);
            $('#formRemoverMatricula').attr('action', `/aluno-disciplina/${id}`);

            new bootstrap.Modal(document.getElementById('modalRemoverMatricula')).show();
        });

    });
</script>
@endpush