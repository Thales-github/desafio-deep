@extends('layouts.app')

@section('title', isset($matricula) ? 'Editar Matrícula' : 'Nova Matrícula')

@push('styles')
<style>
    .form-section {
        background-color: #f8f9fa;
        border-radius: 10px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        border-left: 4px solid #0d6efd;
    }

    .form-section-title {
        color: #0d6efd;
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 1.2rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px dashed #dee2e6;
    }

    .nota-input-group {
        background-color: white;
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 0.5rem;
        border: 1px solid #dee2e6;
        transition: all 0.3s;
    }

    .nota-input-group:hover {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .info-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 10px;
        padding: 1.2rem;
        color: white;
        margin-bottom: 1rem;
    }

    .info-card small {
        color: rgba(255, 255, 255, 0.8);
    }

    .progress {
        border-radius: 15px;
        overflow: hidden;
    }

    .progress-bar {
        transition: width 0.5s ease;
    }

    .media-circle {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        font-weight: bold;
        margin: 0 auto;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        @if(isset($matricula))
                        <i class="bi bi-pencil-square text-warning me-2"></i>
                        Editar Matrícula
                        @else
                        <i class="bi bi-plus-circle-fill text-success me-2"></i>
                        Nova Matrícula
                        @endif
                    </h5>
                    <a href="{{ route('aluno-disciplina.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left me-1"></i>
                        Voltar
                    </a>
                </div>

                <div class="card-body">
                    <form method="POST"
                        action="{{ isset($matricula) ? route('aluno-disciplina.update', $matricula['id']) : route('aluno-disciplina.store') }}"
                        class="needs-validation"
                        novalidate>
                        @csrf
                        @if(isset($matricula))
                        @method('PUT')
                        @endif

                        <!-- Informações Básicas da Matrícula -->
                        <div class="form-section">
                            <h6 class="form-section-title">
                                <i class="bi bi-info-circle me-2"></i>
                                Informações da Matrícula
                            </h6>

                            <div class="row g-3">
                                <div class="col-md-5">
                                    <label for="aluno_id" class="form-label">
                                        <i class="bi bi-person-circle me-1"></i>
                                        Aluno <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('aluno_id') is-invalid @enderror select2"
                                        id="aluno_id"
                                        name="aluno_id"
                                        {{ isset($matricula) ? 'disabled' : '' }}
                                        required>
                                        <option value="">Selecione um aluno...</option>
                                        @foreach($alunos ?? [] as $aluno)
                                        <option value="{{ $aluno['id'] }}"
                                            data-cpf="{{ $aluno['cpf'] }}"
                                            data-email="{{ $aluno['email'] }}"
                                            {{ (old('aluno_id', $matricula['aluno_id'] ?? $matricula['aluno']['id'] ?? '') == $aluno['id']) ? 'selected' : '' }}>
                                            {{ $aluno['nome'] }} - {{ $aluno['cpf'] }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @if(isset($matricula))
                                    <input type="hidden" name="aluno_id" value="{{ $matricula['aluno_id'] ?? $matricula['aluno']['id'] }}">
                                    @endif
                                    @error('aluno_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                    <!-- Informações do aluno selecionado -->
                                    <div id="infoAluno" class="mt-2 p-2 bg-light rounded" style="display: none;">
                                        <small class="text-muted d-block">
                                            <i class="bi bi-envelope me-1"></i>
                                            <span id="infoAlunoEmail"></span>
                                        </small>
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <label for="disciplina_id" class="form-label">
                                        <i class="bi bi-book me-1"></i>
                                        Disciplina <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('disciplina_id') is-invalid @enderror select2"
                                        id="disciplina_id"
                                        name="disciplina_id"
                                        {{ isset($matricula) ? 'disabled' : '' }}
                                        required>
                                        <option value="">Selecione uma disciplina...</option>
                                        @foreach($disciplinas ?? [] as $disciplina)
                                        <option value="{{ $disciplina['id'] }}"
                                            data-carga="{{ $disciplina['carga_horaria'] }}"
                                            data-professor="{{ $disciplina['professor']['nome'] ?? 'Não atribuído' }}"
                                            data-periodo="{{ $disciplina['periodo'] ?? '' }}"
                                            {{ (old('disciplina_id', $matricula['disciplina_id'] ?? $matricula['disciplina']['id'] ?? '') == $disciplina['id']) ? 'selected' : '' }}>
                                            {{ $disciplina['codigo'] ?? '' }} - {{ $disciplina['nome'] }} ({{ $disciplina['carga_horaria'] }}h)
                                        </option>
                                        @endforeach
                                    </select>
                                    @if(isset($matricula))
                                    <input type="hidden" name="disciplina_id" value="{{ $matricula['disciplina_id'] ?? $matricula['disciplina']['id'] }}">
                                    @endif
                                    @error('disciplina_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-2">
                                    <label for="periodo" class="form-label">
                                        <i class="bi bi-calendar me-1"></i>
                                        Período <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('periodo') is-invalid @enderror"
                                        id="periodo"
                                        name="periodo"
                                        required>
                                        <option value="">Selecione...</option>
                                        @php
                                        $anoAtual = date('Y');
                                        $semestreAtual = date('m') <= 6 ? 1 : 2;
                                            @endphp
                                            @for($ano=$anoAtual - 1; $ano <=$anoAtual + 1; $ano++)
                                            @for($semestre=1; $semestre <=2; $semestre++)
                                            <option value="{{ $ano }}.{{ $semestre }}"
                                            {{ (old('periodo', $matricula['periodo'] ?? "$anoAtual.$semestreAtual") == "$ano.$semestre") ? 'selected' : '' }}>
                                            {{ $ano }}.{{ $semestre }}
                                            </option>
                                            @endfor
                                            @endfor
                                    </select>
                                    @error('periodo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Card de informações da disciplina selecionada -->
                            <div id="infoDisciplinaCard" class="info-card mt-3" style="display: none;">
                                <div class="row">
                                    <div class="col-md-4">
                                        <small>Professor Responsável</small>
                                        <h6 id="infoProfessor" class="mb-0">-</h6>
                                    </div>
                                    <div class="col-md-3">
                                        <small>Carga Horária</small>
                                        <h6 id="infoCargaHoraria" class="mb-0">-</h6>
                                    </div>
                                    <div class="col-md-3">
                                        <small>Período</small>
                                        <h6 id="infoPeriodo" class="mb-0">-</h6>
                                    </div>
                                    <div class="col-md-2">
                                        <small>Vagas</small>
                                        <h6 id="infoVagas" class="mb-0">30</h6>
                                    </div>
                                </div>
                            </div>

                            <!-- Data e Status -->
                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <label for="data_matricula" class="form-label">
                                        <i class="bi bi-calendar-date me-1"></i>
                                        Data da Matrícula
                                    </label>
                                    <input type="date"
                                        class="form-control"
                                        id="data_matricula"
                                        name="data_matricula"
                                        value="{{ old('data_matricula', $matricula['data_matricula'] ?? date('Y-m-d')) }}">
                                </div>

                                <div class="col-md-4">
                                    <label for="status" class="form-label">
                                        <i class="bi bi-flag me-1"></i>
                                        Status <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('status') is-invalid @enderror"
                                        id="status"
                                        name="status"
                                        required>
                                        <option value="cursando" {{ (old('status', $matricula['status'] ?? 'cursando') == 'cursando') ? 'selected' : '' }}>Cursando</option>
                                        <option value="aprovado" {{ (old('status', $matricula['status'] ?? '') == 'aprovado') ? 'selected' : '' }}>Aprovado</option>
                                        <option value="reprovado" {{ (old('status', $matricula['status'] ?? '') == 'reprovado') ? 'selected' : '' }}>Reprovado</option>
                                        <option value="trancado" {{ (old('status', $matricula['status'] ?? '') == 'trancado') ? 'selected' : '' }}>Trancado</option>
                                    </select>
                                    @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Notas -->
                        <div class="form-section">
                            <h6 class="form-section-title">
                                <i class="bi bi-123 me-2"></i>
                                Notas
                            </h6>

                            <div id="notas-container">
                                @php
                                $notas = old('notas', $matricula['notas'] ?? []);
                                $quantidadeNotas = count($notas) > 0 ? count($notas) : 4;
                                @endphp

                                @for($i = 1; $i <= $quantidadeNotas; $i++)
                                    <div class="nota-input-group" id="nota-{{ $i }}">
                                    <div class="row align-items-end">
                                        <div class="col-md-1">
                                            <span class="badge bg-primary">N{{ $i }}</span>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label form-label-sm">Descrição</label>
                                            <input type="text"
                                                class="form-control form-control-sm"
                                                name="notas[{{ $i }}][descricao]"
                                                value="{{ old('notas.' . $i . '.descricao', $notas[$i-1]['descricao'] ?? "Avaliação $i") }}"
                                                placeholder="Ex: Prova 1">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label form-label-sm">Valor (0-10)</label>
                                            <input type="number"
                                                class="form-control form-control-sm nota-valor"
                                                name="notas[{{ $i }}][valor]"
                                                value="{{ old('notas.' . $i . '.valor', $notas[$i-1]['valor'] ?? '') }}"
                                                step="0.1"
                                                min="0"
                                                max="10"
                                                placeholder="0-10">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label form-label-sm">Peso</label>
                                            <input type="number"
                                                class="form-control form-control-sm nota-peso"
                                                name="notas[{{ $i }}][peso]"
                                                value="{{ old('notas.' . $i . '.peso', $notas[$i-1]['peso'] ?? 1) }}"
                                                min="1"
                                                max="10"
                                                placeholder="Peso">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label form-label-sm">Data</label>
                                            <input type="date"
                                                class="form-control form-control-sm"
                                                name="notas[{{ $i }}][data]"
                                                value="{{ old('notas.' . $i . '.data', $notas[$i-1]['data'] ?? '') }}">
                                        </div>
                                        <div class="col-md-2">
                                            @if($i > 1)
                                            <button type="button" class="btn btn-sm btn-outline-danger w-100 btn-remover-nota" data-nota="{{ $i }}">
                                                <i class="bi bi-trash me-1"></i>
                                                Remover
                                            </button>
                                            @endif
                                        </div>
                                    </div>
                            </div>
                            @endfor
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <button type="button" class="btn btn-outline-primary btn-sm" id="btnAdicionarNota">
                                <i class="bi bi-plus-circle me-1"></i>
                                Adicionar Nota
                            </button>

                            <!-- Média calculada -->
                            <div class="bg-light p-2 rounded" id="media-calculada" style="display: none;">
                                <strong>Média Ponderada:</strong>
                                <span id="valor-media" class="badge bg-info fs-6">0.0</span>
                            </div>
                        </div>
                </div>

                <!-- Frequência -->
                <div class="form-section">
                    <h6 class="form-section-title">
                        <i class="bi bi-calendar-check me-2"></i>
                        Frequência
                    </h6>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="total_aulas" class="form-label">Total de Aulas no Período</label>
                            <input type="number"
                                class="form-control"
                                id="total_aulas"
                                name="total_aulas"
                                value="{{ old('total_aulas', $matricula['total_aulas'] ?? 60) }}"
                                min="1"
                                step="1">
                        </div>

                        <div class="col-md-4">
                            <label for="presencas" class="form-label">Presenças</label>
                            <input type="number"
                                class="form-control"
                                id="presencas"
                                name="presencas"
                                value="{{ old('presencas', $matricula['presencas'] ?? 0) }}"
                                min="0"
                                step="1">
                        </div>

                        <div class="col-md-4">
                            <label for="faltas" class="form-label">Faltas</label>
                            <input type="number"
                                class="form-control"
                                id="faltas"
                                name="faltas"
                                value="{{ old('faltas', $matricula['faltas'] ?? 0) }}"
                                min="0"
                                step="1"
                                readonly>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Frequência:</label>
                            @php
                            $totalAulas = old('total_aulas', $matricula['total_aulas'] ?? 60);
                            $presencas = old('presencas', $matricula['presencas'] ?? 0);
                            $frequenciaCalc = $totalAulas > 0 ? round(($presencas / $totalAulas) * 100) : 0;
                            @endphp
                            <div class="progress" style="height: 30px;">
                                <div class="progress-bar progress-bar-striped progress-bar-animated 
                                            bg-{{ $frequenciaCalc >= 75 ? 'success' : ($frequenciaCalc >= 50 ? 'warning' : 'danger') }}"
                                    role="progressbar"
                                    style="width: {{ $frequenciaCalc }}%;"
                                    aria-valuenow="{{ $frequenciaCalc }}"
                                    aria-valuemin="0"
                                    aria-valuemax="100">
                                    <strong>{{ $frequenciaCalc }}% de Frequência</strong>
                                </div>
                            </div>
                            <small class="text-muted mt-1">
                                <i class="bi bi-info-circle me-1"></i>
                                Mínimo de 75% para aprovação
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Observações -->
                <div class="form-section">
                    <h6 class="form-section-title">
                        <i class="bi bi-chat-text me-2"></i>
                        Observações
                    </h6>

                    <div class="row">
                        <div class="col-12">
                            <textarea class="form-control"
                                id="observacoes"
                                name="observacoes"
                                rows="3"
                                placeholder="Observações sobre o desempenho do aluno, faltas justificadas, dificuldades, etc.">{{ old('observacoes', $matricula['observacoes'] ?? '') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Botões -->
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('aluno-disciplina.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i>
                        Cancelar
                    </a>
                    <div>
                        <button type="button" class="btn btn-outline-info me-2" id="btnCalcularMedia">
                            <i class="bi bi-calculator me-1"></i>
                            Calcular Média
                        </button>
                        <button type="reset" class="btn btn-outline-warning me-2">
                            <i class="bi bi-eraser me-1"></i>
                            Limpar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i>
                            {{ isset($matricula) ? 'Atualizar Matrícula' : 'Salvar Matrícula' }}
                        </button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        let contadorNotas = {
            {
                $quantidadeNotas ?? 4
            }
        };

        // Inicializar Select2
        $('.select2').select2({
            theme: 'bootstrap-5',
            width: '100%'
        });

        // Informações do aluno selecionado
        $('#aluno_id').on('change', function() {
            const option = $(this).find('option:selected');
            const email = option.data('email');

            if (option.val()) {
                $('#infoAlunoEmail').text(email);
                $('#infoAluno').show();
            } else {
                $('#infoAluno').hide();
            }
        }).trigger('change');

        // Informações da disciplina selecionada
        $('#disciplina_id').on('change', function() {
            const option = $(this).find('option:selected');
            const professor = option.data('professor');
            const carga = option.data('carga');
            const periodo = option.data('periodo');

            if (option.val()) {
                $('#infoProfessor').text(professor);
                $('#infoCargaHoraria').text(carga + ' horas');
                $('#infoPeriodo').text(periodo ? periodo + 'º Período' : 'Não definido');
                $('#infoDisciplinaCard').fadeIn();
            } else {
                $('#infoDisciplinaCard').fadeOut();
            }
        }).trigger('change');

        // Adicionar nova nota
        $('#btnAdicionarNota').on('click', function() {
            contadorNotas++;
            const novaNota = `
            <div class="nota-input-group" id="nota-${contadorNotas}">
                <div class="row align-items-end">
                    <div class="col-md-1">
                        <span class="badge bg-primary">N${contadorNotas}</span>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label form-label-sm">Descrição</label>
                        <input type="text" class="form-control form-control-sm" name="notas[${contadorNotas}][descricao]" placeholder="Ex: Prova ${contadorNotas}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label form-label-sm">Valor (0-10)</label>
                        <input type="number" class="form-control form-control-sm nota-valor" name="notas[${contadorNotas}][valor]" step="0.1" min="0" max="10" placeholder="0-10">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label form-label-sm">Peso</label>
                        <input type="number" class="form-control form-control-sm nota-peso" name="notas[${contadorNotas}][peso]" value="1" min="1" max="10" placeholder="Peso">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label form-label-sm">Data</label>
                        <input type="date" class="form-control form-control-sm" name="notas[${contadorNotas}][data]">
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-sm btn-outline-danger w-100 btn-remover-nota" data-nota="${contadorNotas}">
                            <i class="bi bi-trash me-1"></i>Remover
                        </button>
                    </div>
                </div>
            </div>
        `;
            $('#notas-container').append(novaNota);
        });

        // Remover nota
        $(document).on('click', '.btn-remover-nota', function() {
            const notaId = $(this).data('nota');
            $(`#nota-${notaId}`).fadeOut(300, function() {
                $(this).remove();
            });
        });

        // Calcular média ponderada
        function calcularMedia() {
            let somaPesos = 0;
            let somaNotas = 0;

            $('.nota-input-group').each(function() {
                const valor = parseFloat($(this).find('.nota-valor').val()) || 0;
                const peso = parseFloat($(this).find('.nota-peso').val()) || 1;

                somaNotas += valor * peso;
                somaPesos += peso;
            });

            if (somaPesos > 0) {
                const media = (somaNotas / somaPesos).toFixed(1);
                $('#valor-media').text(media);
                $('#media-calculada').show();

                // Colorir a média
                const mediaNum = parseFloat(media);
                if (mediaNum >= 7) {
                    $('#valor-media').removeClass('bg-warning bg-danger').addClass('bg-success');
                } else if (mediaNum >= 5) {
                    $('#valor-media').removeClass('bg-success bg-danger').addClass('bg-warning');
                } else {
                    $('#valor-media').removeClass('bg-success bg-warning').addClass('bg-danger');
                }
            } else {
                $('#media-calculada').hide();
            }
        }

        $('#btnCalcularMedia').on('click', calcularMedia);

        // Calcular faltas automaticamente
        $('#total_aulas, #presencas').on('input', function() {
            const totalAulas = parseInt($('#total_aulas').val()) || 0;
            const presencas = parseInt($('#presencas').val()) || 0;
            const faltas = totalAulas - presencas;

            $('#faltas').val(faltas >= 0 ? faltas : 0);

            // Atualizar barra de progresso
            if (totalAulas > 0) {
                const frequencia = (presencas / totalAulas) * 100;
                const progressBar = $('.progress-bar');
                progressBar.css('width', frequencia + '%');
                progressBar.text(frequencia.toFixed(1) + '% de Frequência');

                if (frequencia >= 75) {
                    progressBar.removeClass('bg-warning bg-danger').addClass('bg-success');
                } else if (frequencia >= 50) {
                    progressBar.removeClass('bg-success bg-danger').addClass('bg-warning');
                } else {
                    progressBar.removeClass('bg-success bg-warning').addClass('bg-danger');
                }
            }
        });

        // Validação do formulário
        (function() {
            'use strict';
            const forms = document.querySelectorAll('.needs-validation');
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();

        // Verificar disponibilidade de vagas
        $('#disciplina_id').on('change', function() {
            const disciplinaId = $(this).val();
            if (disciplinaId && !$(this).prop('disabled')) {
                // Simular verificação de vagas
                $.get(`/api/verificar-vagas/${disciplinaId}`, function(data) {
                    $('#infoVagas').text(data.vagas_disponiveis);
                    if (data.vagas_disponiveis <= 0) {
                        alert('Esta disciplina não possui vagas disponíveis!');
                    }
                }).fail(function() {
                    $('#infoVagas').text('30');
                });
            }
        });
    });
</script>
@endpush