@extends('layouts.app')

@section('title', 'Detalhes da Matrícula')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <!-- Cabeçalho com ações -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">
                    <i class="bi bi-journal-bookmark-fill text-primary me-2"></i>
                    Detalhes da Matrícula
                </h4>
                <div>
                    <a href="{{ route('aluno-disciplina.edit', $matricula['id']) }}" class="btn btn-warning">
                        <i class="bi bi-pencil me-1"></i>
                        Editar
                    </a>
                    <a href="{{ route('aluno-disciplina.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i>
                        Voltar
                    </a>
                </div>
            </div>

            <!-- Card Principal -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <!-- Header com informações principais -->
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                                    <i class="bi bi-person-workspace text-primary fs-1"></i>
                                </div>
                                <div>
                                    <h2 class="mb-1">{{ $matricula['aluno']['nome'] }}</h2>
                                    <div class="d-flex gap-3 flex-wrap">
                                        <span class="badge bg-secondary">
                                            <i class="bi bi-upc-scan me-1"></i>
                                            Matrícula: {{ $matricula['id'] }}
                                        </span>
                                        <span class="badge bg-info">
                                            <i class="bi bi-book me-1"></i>
                                            {{ $matricula['disciplina']['nome'] }}
                                        </span>
                                        <span class="badge bg-primary">
                                            <i class="bi bi-calendar me-1"></i>
                                            Período: {{ $matricula['periodo'] ?? 'N/A' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row g-2">
                                <div class="col-6">
                                    <div class="bg-light rounded p-3 text-center">
                                        <div class="fs-3 fw-bold text-primary">{{ $matricula['disciplina']['carga_horaria'] }}h</div>
                                        <small class="text-muted">Carga Horária</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="bg-light rounded p-3 text-center">
                                        @php
                                        $status = $matricula['status'] ?? 'cursando';
                                        $statusClass = [
                                        'aprovado' => 'success',
                                        'reprovado' => 'danger',
                                        'cursando' => 'warning',
                                        'trancado' => 'secondary'
                                        ][$status] ?? 'warning';
                                        $statusText = [
                                        'aprovado' => 'APROVADO',
                                        'reprovado' => 'REPROVADO',
                                        'cursando' => 'CURSANDO',
                                        'trancado' => 'TRANCADO'
                                        ][$status] ?? 'CURSANDO';
                                        @endphp
                                        <div class="fs-6 fw-bold text-{{ $statusClass }}">{{ $statusText }}</div>
                                        <small class="text-muted">Status</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Grid de Informações -->
                    <div class="row">
                        <!-- Coluna Esquerda - Informações do Aluno -->
                        <div class="col-md-6">
                            <div class="card border-0 bg-light mb-3">
                                <div class="card-body">
                                    <h6 class="text-primary mb-3">
                                        <i class="bi bi-person-circle me-2"></i>
                                        Dados do Aluno
                                    </h6>
                                    <table class="table table-sm table-borderless">
                                        <tr>
                                            <td width="40%" class="text-muted">Nome Completo:</td>
                                            <td><strong>{{ $matricula['aluno']['nome'] }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">CPF:</td>
                                            <td><strong>{{ $matricula['aluno']['cpf'] }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Data Nascimento:</td>
                                            <td><strong>{{ \Carbon\Carbon::parse($matricula['aluno']['data_nascimento'])->format('d/m/Y') }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">E-mail:</td>
                                            <td>
                                                <strong>{{ $matricula['aluno']['email'] }}</strong>
                                                <a href="mailto:{{ $matricula['aluno']['email'] }}" class="ms-2 text-primary">
                                                    <i class="bi bi-envelope-fill"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Telefone:</td>
                                            <td>
                                                <strong>{{ $matricula['aluno']['telefone'] }}</strong>
                                                <a href="tel:{{ $matricula['aluno']['telefone'] }}" class="ms-2 text-primary">
                                                    <i class="bi bi-telephone-fill"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                    <div class="mt-2">
                                        <a href="{{ route('alunos.show', $matricula['aluno']['id']) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye me-1"></i>
                                            Ver Perfil Completo do Aluno
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Informações da Disciplina -->
                            <div class="card border-0 bg-light mb-3">
                                <div class="card-body">
                                    <h6 class="text-primary mb-3">
                                        <i class="bi bi-book me-2"></i>
                                        Dados da Disciplina
                                    </h6>
                                    <table class="table table-sm table-borderless">
                                        <tr>
                                            <td width="40%" class="text-muted">Disciplina:</td>
                                            <td><strong>{{ $matricula['disciplina']['nome'] }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Código:</td>
                                            <td><strong>{{ $matricula['disciplina']['codigo'] ?? 'N/A' }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Carga Horária:</td>
                                            <td><strong>{{ $matricula['disciplina']['carga_horaria'] }} horas</strong></td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Período:</td>
                                            <td><strong>{{ $matricula['disciplina']['periodo'] ?? 'N/A' }}º Período</strong></td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Professor:</td>
                                            <td>
                                                @if(!empty($matricula['disciplina']['professor']))
                                                <strong>{{ $matricula['disciplina']['professor']['nome'] }}</strong>
                                                @else
                                                <span class="text-muted">Não atribuído</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @if(!empty($matricula['disciplina']['descricao']))
                                        <tr>
                                            <td class="text-muted">Descrição:</td>
                                            <td><small>{{ Str::limit($matricula['disciplina']['descricao'], 100) }}</small></td>
                                        </tr>
                                        @endif
                                    </table>
                                    <div class="mt-2">
                                        <a href="{{ route('disciplinas.show', $matricula['disciplina']['id']) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye me-1"></i>
                                            Ver Detalhes da Disciplina
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Coluna Direita - Notas e Frequência -->
                        <div class="col-md-6">
                            <!-- Card de Notas -->
                            <div class="card border-0 bg-light mb-3">
                                <div class="card-body">
                                    <h6 class="text-primary mb-3">
                                        <i class="bi bi-123 me-2"></i>
                                        Notas
                                    </h6>

                                    @php
                                    $notas = $matricula['notas'] ?? [];
                                    $media = $matricula['media'] ?? 0;
                                    $totalPeso = 0;
                                    $somaNotas = 0;
                                    @endphp

                                    @if(count($notas) > 0)
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Avaliação</th>
                                                    <th>Descrição</th>
                                                    <th>Valor</th>
                                                    <th>Peso</th>
                                                    <th>Data</th>
                                                    <th>Ponderada</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($notas as $index => $nota)
                                                @php
                                                $valor = floatval($nota['valor'] ?? $nota);
                                                $peso = intval($nota['peso'] ?? 1);
                                                $somaNotas += $valor * $peso;
                                                $totalPeso += $peso;
                                                @endphp
                                                <tr>
                                                    <td><span class="badge bg-secondary">N{{ $index + 1 }}</span></td>
                                                    <td>{{ $nota['descricao'] ?? "Avaliação " . ($index + 1) }}</td>
                                                    <td class="fw-bold">{{ number_format($valor, 1) }}</td>
                                                    <td>{{ $peso }}</td>
                                                    <td>{{ isset($nota['data']) ? \Carbon\Carbon::parse($nota['data'])->format('d/m/Y') : '-' }}</td>
                                                    <td class="fw-bold">{{ number_format($valor * $peso, 1) }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot class="table-light">
                                                <tr>
                                                    <td colspan="5" class="text-end"><strong>Total:</strong></td>
                                                    <td><strong>{{ number_format($somaNotas, 1) }}</strong></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5" class="text-end"><strong>Soma dos Pesos:</strong></td>
                                                    <td><strong>{{ $totalPeso }}</strong></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5" class="text-end"><strong>Média Final:</strong></td>
                                                    <td>
                                                        @php
                                                        $mediaCalculada = $totalPeso > 0 ? $somaNotas / $totalPeso : 0;
                                                        @endphp
                                                        <span class="badge bg-{{ $mediaCalculada >= 7 ? 'success' : ($mediaCalculada >= 5 ? 'warning' : 'danger') }} fs-6">
                                                            {{ number_format($mediaCalculada, 1) }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>

                                    <!-- Gráfico de desempenho -->
                                    <div class="mt-3">
                                        <small class="text-muted">Desempenho por avaliação:</small>
                                        <div class="progress-stacked mt-1">
                                            @foreach($notas as $index => $nota)
                                            @php
                                            $valor = floatval($nota['valor'] ?? $nota);
                                            $porcentagem = ($valor / 10) * 100;
                                            @endphp
                                            <div class="progress" role="progressbar" style="width: {{ 100/count($notas) }}%">
                                                <div class="progress-bar bg-{{ $valor >= 7 ? 'success' : ($valor >= 5 ? 'warning' : 'danger') }}"
                                                    style="width: {{ $porcentagem }}%">
                                                    <small>N{{ $index + 1 }}</small>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @else
                                    <div class="text-center py-4">
                                        <i class="bi bi-clipboard-x display-4 text-muted"></i>
                                        <p class="text-muted mt-2">Nenhuma nota lançada</p>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Card de Frequência -->
                            <div class="card border-0 bg-light mb-3">
                                <div class="card-body">
                                    <h6 class="text-primary mb-3">
                                        <i class="bi bi-calendar-check me-2"></i>
                                        Frequência
                                    </h6>

                                    @php
                                    $totalAulas = $matricula['total_aulas'] ?? 60;
                                    $presencas = $matricula['presencas'] ?? 0;
                                    $faltas = $matricula['faltas'] ?? ($totalAulas - $presencas);
                                    $frequencia = $totalAulas > 0 ? round(($presencas / $totalAulas) * 100) : 0;
                                    @endphp

                                    <div class="row text-center mb-3">
                                        <div class="col-4">
                                            <div class="p-2">
                                                <span class="d-block fs-3 fw-bold text-primary">{{ $totalAulas }}</span>
                                                <small class="text-muted">Total Aulas</small>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="p-2">
                                                <span class="d-block fs-3 fw-bold text-success">{{ $presencas }}</span>
                                                <small class="text-muted">Presenças</small>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="p-2">
                                                <span class="d-block fs-3 fw-bold text-danger">{{ $faltas }}</span>
                                                <small class="text-muted">Faltas</small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="progress" style="height: 30px;">
                                        <div class="progress-bar progress-bar-striped bg-{{ $frequencia >= 75 ? 'success' : ($frequencia >= 50 ? 'warning' : 'danger') }}"
                                            role="progressbar"
                                            style="width: {{ $frequencia }}%;"
                                            aria-valuenow="{{ $frequencia }}"
                                            aria-valuemin="0"
                                            aria-valuemax="100">
                                            <strong>{{ $frequencia }}% de Frequência</strong>
                                        </div>
                                    </div>

                                    @if($frequencia < 75)
                                        <div class="alert alert-danger mt-3 mb-0 py-2">
                                        <i class="bi bi-exclamation-triangle me-1"></i>
                                        <small>Frequência abaixo do mínimo necessário (75%)</small>
                                </div>
                                @elseif($frequencia >= 75 && $frequencia < 90)
                                    <div class="alert alert-warning mt-3 mb-0 py-2">
                                    <i class="bi bi-info-circle me-1"></i>
                                    <small>Frequência regular</small>
                            </div>
                            @else
                            <div class="alert alert-success mt-3 mb-0 py-2">
                                <i class="bi bi-check-circle me-1"></i>
                                <small>Frequência excelente</small>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Observações -->
                    @if(!empty($matricula['observacoes']))
                    <div class="card border-0 bg-light mb-3">
                        <div class="card-body">
                            <h6 class="text-primary mb-3">
                                <i class="bi bi-chat-text me-2"></i>
                                Observações
                            </h6>
                            <p class="mb-0" style="white-space: pre-line;">{{ $matricula['observacoes'] }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Histórico de Atividades -->
            <div class="mt-4">
                <h5 class="mb-3">
                    <i class="bi bi-clock-history text-primary me-2"></i>
                    Histórico da Matrícula
                </h5>

                <div class="timeline">
                    @php
                    $atividades = $matricula['historico'] ?? [
                    ['data' => $matricula['created_at'] ?? now(), 'acao' => 'Matrícula realizada', 'usuario' => 'Sistema'],
                    ['data' => $matricula['updated_at'] ?? now(), 'acao' => 'Última atualização', 'usuario' => 'Sistema']
                    ];
                    @endphp

                    @foreach($atividades as $atividade)
                    <div class="d-flex mb-3">
                        <div class="me-3">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-2">
                                <i class="bi bi-circle-fill text-primary"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between">
                                <strong>{{ $atividade['acao'] }}</strong>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($atividade['data'])->format('d/m/Y H:i') }}</small>
                            </div>
                            <small class="text-muted">Por: {{ $atividade['usuario'] }}</small>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Rodapé com informações de auditoria -->
        <div class="card-footer bg-white">
            <div class="row">
                <div class="col-md-6">
                    <small class="text-muted">
                        <i class="bi bi-clock-history me-1"></i>
                        Cadastrado em: {{ \Carbon\Carbon::parse($matricula['created_at'] ?? now())->format('d/m/Y H:i:s') }}
                    </small>
                </div>
                <div class="col-md-6 text-end">
                    <small class="text-muted">
                        <i class="bi bi-arrow-repeat me-1"></i>
                        Última atualização: {{ \Carbon\Carbon::parse($matricula['updated_at'] ?? now())->format('d/m/Y H:i:s') }}
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>

<!-- Modal de Ações Rápidas -->
<div class="modal fade" id="modalAcoesRapidas" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-lightning-charge text-warning me-2"></i>
                    Ações Rápidas
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="list-group">
                    <button type="button" class="list-group-item list-group-item-action" onclick="lancarNota()">
                        <i class="bi bi-plus-circle text-success me-2"></i>
                        Lançar Nova Nota
                    </button>
                    <button type="button" class="list-group-item list-group-item-action" onclick="registrarFrequencia()">
                        <i class="bi bi-calendar-check text-primary me-2"></i>
                        Registrar Frequência
                    </button>
                    <button type="button" class="list-group-item list-group-item-action" onclick="alterarStatus()">
                        <i class="bi bi-arrow-repeat text-info me-2"></i>
                        Alterar Status
                    </button>
                    <button type="button" class="list-group-item list-group-item-action text-danger" onclick="gerarRelatorio()">
                        <i class="bi bi-file-pdf text-danger me-2"></i>
                        Gerar Relatório PDF
                    </button>
                </div>
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

        // Botão de ações rápidas (pode ser adicionado no cabeçalho)
        $('.card-header .btn-group').append(`
        <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalAcoesRapidas">
            <i class="bi bi-lightning-charge me-1"></i>
            Ações Rápidas
        </button>
    `);
    });

    // Funções para ações rápidas
    function lancarNota() {
        window.location.href = "{{ route('aluno-disciplina.edit', $matricula['id']) }}#notas";
    }

    function registrarFrequencia() {
        window.location.href = "{{ route('aluno-disciplina.edit', $matricula['id']) }}#frequencia";
    }

    function alterarStatus() {
        $('#modalAcoesRapidas').modal('hide');
        // Aqui pode abrir um modal específico para alterar status
        alert('Funcionalidade de alterar status será implementada');
    }

    function gerarRelatorio() {
        window.open('/aluno-disciplina/{{ $matricula['
            id '] }}/relatorio', '_blank');
    }

    // Calcular e exibir média em tempo real (se houver dados)
    function calcularMedia() {
        let somaPesos = 0;
        let somaNotas = 0;

        @if(count($notas ?? []) > 0)
        @foreach($notas as $nota)
        @php
        $valor = floatval($nota['valor'] ?? $nota);
        $peso = intval($nota['peso'] ?? 1);
        @endphp
        somaPesos += {
            {
                $peso
            }
        };
        somaNotas += {
            {
                $valor * $peso
            }
        };
        @endforeach

        if (somaPesos > 0) {
            const media = somaNotas / somaPesos;
            console.log('Média calculada:', media.toFixed(1));
        }
        @endif
    }
</script>
@endpush

@push('styles')
<style>
    .timeline {
        position: relative;
        padding-left: 1.5rem;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 0.65rem;
        top: 0;
        bottom: 0;
        width: 2px;
        background: linear-gradient(to bottom, #0d6efd, #6c757d);
        opacity: 0.3;
    }

    .progress-stacked {
        display: flex;
        height: 20px;
        overflow: hidden;
        background-color: #e9ecef;
        border-radius: 10px;
    }

    .progress-stacked .progress {
        margin: 0;
        border-radius: 0;
    }

    .progress-stacked .progress:first-child {
        border-radius: 10px 0 0 10px;
    }

    .progress-stacked .progress:last-child {
        border-radius: 0 10px 10px 0;
    }
</style>
@endpush