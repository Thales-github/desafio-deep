@extends('layouts.app')

@section('title', isset($professor) ? 'Editar Professor' : 'Novo Professor')

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

    .foto-preview {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background-color: #e9ecef;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        overflow: hidden;
        border: 3px solid #fff;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }

    .foto-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
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
                        @if(isset($professor))
                        <i class="bi bi-pencil-square text-warning me-2"></i>
                        Editar Professor
                        @else
                        <i class="bi bi-person-plus-fill text-success me-2"></i>
                        Novo Professor
                        @endif
                    </h5>
                </div>

                <div class="card-body">
                    <form method="POST"
                        action="{{ isset($professor) ? route('professores.update', $professor['id']) : route('professores.store') }}"
                        class="needs-validation"
                        novalidate
                        enctype="multipart/form-data">
                        @csrf
                        @if(isset($professor))
                        @method('PUT')
                        @endif

                        <!-- Foto -->
                        <div class="text-center mb-4">
                            <div class="foto-preview" id="fotoPreview">
                                @if(isset($professor) && !empty($professor['foto']))
                                <img src="{{ $professor['foto'] }}" alt="Foto do professor">
                                @else
                                <i class="bi bi-person-circle display-1 text-secondary"></i>
                                @endif
                            </div>
                            <div class="mt-2">
                                <label for="foto" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-camera me-1"></i>
                                    Escolher Foto
                                </label>
                                <input type="file" class="d-none" id="foto" name="foto" accept="image/*">
                            </div>
                        </div>

                        <!-- Dados Pessoais -->
                        <div class="form-section">
                            <h6 class="form-section-title">
                                <i class="bi bi-person-badge me-2"></i>
                                Dados Pessoais
                            </h6>

                            <div class="row g-3">
                                <div class="col-md-8">
                                    <label for="nome" class="form-label">
                                        Nome Completo <span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                        class="form-control @error('nome') is-invalid @enderror"
                                        id="nome"
                                        name="nome"
                                        value="{{ old('nome', $professor['nome'] ?? '') }}"
                                        placeholder="Nome completo do professor"
                                        required>
                                    @error('nome')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="data_nascimento" class="form-label">
                                        Data Nascimento <span class="text-danger">*</span>
                                    </label>
                                    <input type="date"
                                        class="form-control @error('data_nascimento') is-invalid @enderror"
                                        id="data_nascimento"
                                        name="data_nascimento"
                                        value="{{ old('data_nascimento', $professor['data_nascimento'] ?? '') }}"
                                        required>
                                    @error('data_nascimento')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="cpf" class="form-label">
                                        CPF <span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                        class="form-control cpf-mask @error('cpf') is-invalid @enderror"
                                        id="cpf"
                                        name="cpf"
                                        value="{{ old('cpf', $professor['cpf'] ?? '') }}"
                                        maxlength="14"
                                        required>
                                    @error('cpf')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="rg" class="form-label">RG</label>
                                    <input type="text"
                                        class="form-control"
                                        id="rg"
                                        name="rg"
                                        value="{{ old('rg', $professor['rg'] ?? '') }}">
                                </div>

                                <div class="col-md-4">
                                    <label for="registro" class="form-label">
                                        Registro Profissional
                                    </label>
                                    <input type="text"
                                        class="form-control"
                                        id="registro"
                                        name="registro"
                                        value="{{ old('registro', $professor['registro'] ?? '') }}"
                                        placeholder="Ex: CREA, OAB, etc">
                                </div>

                                <div class="col-md-4">
                                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-select @error('status') is-invalid @enderror"
                                        id="status"
                                        name="status"
                                        required>
                                        <option value="ativo" {{ (old('status', $professor['status'] ?? 'ativo') == 'ativo') ? 'selected' : '' }}>Ativo</option>
                                        <option value="inativo" {{ (old('status', $professor['status'] ?? '') == 'inativo') ? 'selected' : '' }}>Inativo</option>
                                    </select>
                                    @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Contato -->
                        <div class="form-section">
                            <h6 class="form-section-title">
                                <i class="bi bi-telephone me-2"></i>
                                Contato
                            </h6>

                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="email" class="form-label">
                                        E-mail <span class="text-danger">*</span>
                                    </label>
                                    <input type="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        id="email"
                                        name="email"
                                        value="{{ old('email', $professor['email'] ?? '') }}"
                                        placeholder="professor@email.com"
                                        required>
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="telefone" class="form-label">
                                        Telefone <span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                        class="form-control phone-mask @error('telefone') is-invalid @enderror"
                                        id="telefone"
                                        name="telefone"
                                        value="{{ old('telefone', $professor['telefone'] ?? '') }}"
                                        maxlength="15"
                                        required>
                                    @error('telefone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="celular" class="form-label">Celular</label>
                                    <input type="text"
                                        class="form-control phone-mask"
                                        id="celular"
                                        name="celular"
                                        value="{{ old('celular', $professor['celular'] ?? '') }}"
                                        maxlength="15">
                                </div>
                            </div>
                        </div>

                        <!-- Endereço -->
                        <div class="form-section">
                            <h6 class="form-section-title">
                                <i class="bi bi-geo-alt me-2"></i>
                                Endereço
                            </h6>

                            <div class="row g-3">
                                <div class="col-md-2">
                                    <label for="cep" class="form-label">CEP</label>
                                    <input type="text"
                                        class="form-control cep-mask"
                                        id="cep"
                                        name="cep"
                                        value="{{ old('cep', $professor['cep'] ?? '') }}"
                                        maxlength="9">
                                </div>

                                <div class="col-md-8">
                                    <label for="logradouro" class="form-label">Logradouro</label>
                                    <input type="text"
                                        class="form-control"
                                        id="logradouro"
                                        name="logradouro"
                                        value="{{ old('logradouro', $professor['logradouro'] ?? '') }}">
                                </div>

                                <div class="col-md-2">
                                    <label for="numero" class="form-label">Número</label>
                                    <input type="text"
                                        class="form-control"
                                        id="numero"
                                        name="numero"
                                        value="{{ old('numero', $professor['numero'] ?? '') }}">
                                </div>

                                <div class="col-md-5">
                                    <label for="complemento" class="form-label">Complemento</label>
                                    <input type="text"
                                        class="form-control"
                                        id="complemento"
                                        name="complemento"
                                        value="{{ old('complemento', $professor['complemento'] ?? '') }}">
                                </div>

                                <div class="col-md-3">
                                    <label for="bairro" class="form-label">Bairro</label>
                                    <input type="text"
                                        class="form-control"
                                        id="bairro"
                                        name="bairro"
                                        value="{{ old('bairro', $professor['bairro'] ?? '') }}">
                                </div>

                                <div class="col-md-2">
                                    <label for="cidade" class="form-label">Cidade</label>
                                    <input type="text"
                                        class="form-control"
                                        id="cidade"
                                        name="cidade"
                                        value="{{ old('cidade', $professor['cidade'] ?? '') }}">
                                </div>
                            </div>
                        </div>

                        <!-- Dados Profissionais -->
                        <div class="form-section">
                            <h6 class="form-section-title">
                                <i class="bi bi-briefcase me-2"></i>
                                Dados Profissionais
                            </h6>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="especializacao" class="form-label">Especialização</label>
                                    <input type="text"
                                        class="form-control"
                                        id="especializacao"
                                        name="especializacao"
                                        value="{{ old('especializacao', $professor['especializacao'] ?? '') }}"
                                        placeholder="Ex: Matemática, Português, etc">
                                </div>

                                <div class="col-md-6">
                                    <label for="formacao" class="form-label">Formação Acadêmica</label>
                                    <input type="text"
                                        class="form-control"
                                        id="formacao"
                                        name="formacao"
                                        value="{{ old('formacao', $professor['formacao'] ?? '') }}"
                                        placeholder="Ex: Licenciatura em Matemática">
                                </div>

                                <div class="col-md-4">
                                    <label for="data_admissao" class="form-label">Data de Admissão</label>
                                    <input type="date"
                                        class="form-control"
                                        id="data_admissao"
                                        name="data_admissao"
                                        value="{{ old('data_admissao', $professor['data_admissao'] ?? '') }}">
                                </div>

                                <div class="col-md-4">
                                    <label for="carga_horaria" class="form-label">Carga Horária Semanal</label>
                                    <div class="input-group">
                                        <input type="number"
                                            class="form-control"
                                            id="carga_horaria"
                                            name="carga_horaria"
                                            value="{{ old('carga_horaria', $professor['carga_horaria'] ?? '') }}"
                                            min="0"
                                            max="40">
                                        <span class="input-group-text">horas</span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label for="nivel" class="form-label">Nível</label>
                                    <select class="form-select" id="nivel" name="nivel">
                                        <option value="">Selecione...</option>
                                        <option value="graduacao" {{ (old('nivel', $professor['nivel'] ?? '') == 'graduacao') ? 'selected' : '' }}>Graduação</option>
                                        <option value="especialista" {{ (old('nivel', $professor['nivel'] ?? '') == 'especialista') ? 'selected' : '' }}>Especialista</option>
                                        <option value="mestre" {{ (old('nivel', $professor['nivel'] ?? '') == 'mestre') ? 'selected' : '' }}>Mestre</option>
                                        <option value="doutor" {{ (old('nivel', $professor['nivel'] ?? '') == 'doutor') ? 'selected' : '' }}>Doutor</option>
                                        <option value="phd" {{ (old('nivel', $professor['nivel'] ?? '') == 'phd') ? 'selected' : '' }}>PhD</option>
                                    </select>
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
                                        rows="4"
                                        placeholder="Informações adicionais sobre o professor...">{{ old('observacoes', $professor['observacoes'] ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Botões -->
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('professores.index') }}" class="btn btn-outline-secondary">
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
                                    {{ isset($professor) ? 'Atualizar Professor' : 'Salvar Professor' }}
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
        // Preview de foto
        $('#foto').on('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#fotoPreview').html('<img src="' + e.target.result + '" alt="Foto do professor">');
                }
                reader.readAsDataURL(file);
            }
        });

        // Máscaras
        function aplicarMascaras() {
            $('.cpf-mask').on('input', function() {
                let value = $(this).val().replace(/\D/g, '');
                if (value.length <= 11) {
                    value = value.replace(/(\d{3})(\d)/, '$1.$2');
                    value = value.replace(/(\d{3})(\d)/, '$1.$2');
                    value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
                    $(this).val(value);
                }
            });

            $('.phone-mask').on('input', function() {
                let value = $(this).val().replace(/\D/g, '');
                if (value.length <= 11) {
                    if (value.length <= 10) {
                        value = value.replace(/(\d{2})(\d)/, '($1) $2');
                        value = value.replace(/(\d{4})(\d)/, '$1-$2');
                    } else {
                        value = value.replace(/(\d{2})(\d)/, '($1) $2');
                        value = value.replace(/(\d{5})(\d)/, '$1-$2');
                    }
                    $(this).val(value);
                }
            });

            $('.cep-mask').on('input', function() {
                let value = $(this).val().replace(/\D/g, '');
                if (value.length <= 8) {
                    value = value.replace(/(\d{5})(\d)/, '$1-$2');
                    $(this).val(value);
                }
            });
        }

        aplicarMascaras();

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

        // Buscar CEP
        $('#cep').on('blur', function() {
            const cep = $(this).val().replace(/\D/g, '');
            if (cep.length === 8) {
                $.getJSON(`https://viacep.com.br/ws/${cep}/json/`, function(data) {
                    if (!data.erro) {
                        $('#logradouro').val(data.logradouro);
                        $('#bairro').val(data.bairro);
                        $('#cidade').val(data.localidade);
                        $('#uf').val(data.uf);
                    }
                });
            }
        });

        // Calcular idade automaticamente
        $('#data_nascimento').on('change', function() {
            const dataNasc = new Date($(this).val());
            if (dataNasc) {
                const hoje = new Date();
                let idade = hoje.getFullYear() - dataNasc.getFullYear();
                const mes = hoje.getMonth() - dataNasc.getMonth();
                if (mes < 0 || (mes === 0 && hoje.getDate() < dataNasc.getDate())) {
                    idade--;
                }
                if (idade > 0) {
                    $('#idade').val(idade + ' anos');
                }
            }
        });
    });
</script>
@endpush