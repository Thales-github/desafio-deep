@extends('layouts.app')

@section('title', isset($disciplina) ? 'Editar Disciplina' : 'Nova Disciplina')

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

    .carga-horaria-option {
        cursor: pointer;
        transition: all 0.3s;
    }

    .carga-horaria-option:hover {
        transform: translateY(-2px);
    }

    .carga-horaria-option.selected {
        border-color: #0d6efd;
        background-color: #e7f1ff;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">
                        @if(isset($disciplina))
                        <i class="bi bi-pencil-square text-warning me-2"></i>
                        Editar Disciplina
                        @else
                        <i class="bi bi-plus-circle-fill text-success me-2"></i>
                        Nova Disciplina
                        @endif
                    </h5>
                </div>

                <div class="card-body">
                    <form method="POST"
                        action="{{ isset($disciplina) ? route('disciplinas.update', $disciplina['id']) : route('disciplinas.store') }}"
                        class="needs-validation"
                        novalidate
                        enctype="multipart/form-data">
                        @csrf
                        @if(isset($disciplina))
                        @method('PUT')
                        @endif

                        <!-- Informações Básicas -->
                        <div class="form-section">
                            <h6 class="form-section-title">
                                <i class="bi bi-info-circle me-2"></i>
                                Informações Básicas
                            </h6>

                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="codigo" class="form-label">
                                        Código da Disciplina <span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                        class="form-control @error('codigo') is-invalid @enderror"
                                        id="codigo"
                                        name="codigo"
                                        value="{{ old('codigo', $disciplina['codigo'] ?? '') }}"
                                        placeholder="Ex: DISC001"
                                        required>
                                    <div class="form-text">Código único para identificação</div>
                                    @error('codigo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-8">
                                    <label for="nome" class="form-label">
                                        Nome da Disciplina <span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                        class="form-control @error('nome') is-invalid @enderror"
                                        id="nome"
                                        name="nome"
                                        value="{{ old('nome', $disciplina['nome'] ?? '') }}"
                                        placeholder="Ex: Matemática I"
                                        required>
                                    @error('nome')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label for="descricao" class="form-label">Descrição / Ementa</label>
                                    <textarea class="form-control @error('descricao') is-invalid @enderror"
                                        id="descricao"
                                        name="descricao"
                                        rows="4"
                                        placeholder="Descreva o conteúdo programático da disciplina">{{ old('descricao', $disciplina['descricao'] ?? '') }}</textarea>
                                    @error('descricao')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Configurações -->
                        <div class="form-section">
                            <h6 class="form-section-title">
                                <i class="bi bi-gear me-2"></i>
                                Configurações
                            </h6>

                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="carga_horaria" class="form-label">
                                        Carga Horária <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <input type="number"
                                            class="form-control @error('carga_horaria') is-invalid @enderror"
                                            id="carga_horaria"
                                            name="carga_horaria"
                                            value="{{ old('carga_horaria', $disciplina['carga_horaria'] ?? '') }}"
                                            min="20"
                                            max="200"
                                            step="20"
                                            required>
                                        <span class="input-group-text">horas</span>
                                        @error('carga_horaria')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-3">
                                            <div class="card carga-horaria-option p-2 text-center" data-carga="40">
                                                <small>40h</small>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="card carga-horaria-option p-2 text-center" data-carga="60">
                                                <small>60h</small>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="card carga-horaria-option p-2 text-center" data-carga="80">
                                                <small>80h</small>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="card carga-horaria-option p-2 text-center" data-carga="120">
                                                <small>120h</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label for="periodo" class="form-label">Período</label>
                                    <select class="form-select @error('periodo') is-invalid @enderror"
                                        id="periodo"
                                        name="periodo">
                                        <option value="">Selecione...</option>
                                        @for($i = 1; $i <= 10; $i++)
                                            <option value="{{ $i }}" {{ (old('periodo', $disciplina['periodo'] ?? '') == $i) ? 'selected' : '' }}>
                                            {{ $i }}º Período
                                            </option>
                                            @endfor
                                    </select>
                                    @error('periodo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                    <div class="d-flex gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input"
                                                type="radio"
                                                name="status"
                                                id="statusAtivo"
                                                value="ativo"
                                                {{ (old('status', $disciplina['status'] ?? 'ativo') == 'ativo') ? 'checked' : '' }}
                                                required>
                                            <label class="form-check-label text-success" for="statusAtivo">
                                                <i class="bi bi-check-circle"></i> Ativa
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input"
                                                type="radio"
                                                name="status"
                                                id="statusInativo"
                                                value="inativo"
                                                {{ (old('status', $disciplina['status'] ?? '') == 'inativo') ? 'checked' : '' }}>
                                            <label class="form-check-label text-danger" for="statusInativo">
                                                <i class="bi bi-x-circle"></i> Inativa
                                            </label>
                                        </div>
                                    </div>
                                    @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Atribuição de Professor -->
                        <div class="form-section">
                            <h6 class="form-section-title">
                                <i class="bi bi-person-badge me-2"></i>
                                Atribuição de Professor
                            </h6>

                            <div class="row">
                                <div class="col-md-8">
                                    <label for="professor_id" class="form-label">Professor Responsável</label>
                                    <select class="form-select @error('professor_id') is-invalid @enderror"
                                        id="professor_id"
                                        name="professor_id">
                                        <option value="">Selecione um professor...</option>
                                        @foreach($professores ?? [] as $professor)
                                        <option value="{{ $professor['id'] }}"
                                            {{ (old('professor_id', $disciplina['professor_id'] ?? $disciplina['professor']['id'] ?? '') == $professor['id']) ? 'selected' : '' }}>
                                            {{ $professor['nome'] }} - {{ $professor['especializacao'] ?? 'Sem especialização' }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <div class="form-text">Opcional - Pode ser atribuído depois</div>
                                    @error('professor_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Pré-requisitos -->
                        <div class="form-section">
                            <h6 class="form-section-title">
                                <i class="bi bi-diagram-3 me-2"></i>
                                Pré-requisitos
                            </h6>

                            <div class="row">
                                <div class="col-md-8">
                                    <label for="requisitos" class="form-label">Disciplinas Pré-requisito</label>
                                    <select class="form-select"
                                        id="requisitos"
                                        name="requisitos[]"
                                        multiple
                                        size="5">
                                        @foreach($disciplinas_list ?? [] as $disc)
                                        @if(!isset($disciplina) || $disc['id'] != $disciplina['id'])
                                        <option value="{{ $disc['id'] }}"
                                            {{ in_array($disc['id'], old('requisitos', $disciplina['requisitos'] ?? [])) ? 'selected' : '' }}>
                                            {{ $disc['codigo'] }} - {{ $disc['nome'] }} ({{ $disc['carga_horaria'] }}h)
                                        </option>
                                        @endif
                                        @endforeach
                                    </select>
                                    <div class="form-text">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Segure CTRL para selecionar múltiplas disciplinas
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botões -->
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('disciplinas.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-1"></i>
                                Cancelar
                            </a>
                            <div>
                                <button type="reset" class="btn btn-outline-warning me-2">
                                    <i class="bi bi-eraser me-1"></i>
                                    Limpar
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-lg me-1"></i>
                                    {{ isset($disciplina) ? 'Atualizar Disciplina' : 'Salvar Disciplina' }}
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
        // Seleção rápida de carga horária
        $('.carga-horaria-option').on('click', function() {
            $('.carga-horaria-option').removeClass('selected border-primary');
            $(this).addClass('selected border-primary');
            $('#carga_horaria').val($(this).data('carga'));
        });

        // Destacar a opção selecionada se já houver valor
        var cargaAtual = $('#carga_horaria').val();
        if (cargaAtual) {
            $(`.carga-horaria-option[data-carga="${cargaAtual}"]`).addClass('selected border-primary');
        }

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

        // Gerar código automático baseado no nome
        $('#nome').on('blur', function() {
            if ($('#codigo').val() === '') {
                var nome = $(this).val();
                if (nome) {
                    var palavras = nome.split(' ');
                    var codigo = '';
                    palavras.forEach(function(palavra) {
                        if (palavra.length > 0) {
                            codigo += palavra.substring(0, 3).toUpperCase();
                        }
                    });
                    codigo = codigo.substring(0, 8);
                    $('#codigo').val(codigo + Math.floor(Math.random() * 100));
                }
            }
        });
    });
</script>
@endpush