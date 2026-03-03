@extends('layouts.app')

@section('title', isset($aluno) ? 'Editar Aluno' : 'Novo Aluno')

@push('styles')
<style>
    .form-section {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .form-section-title {
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 2px solid #dee2e6;
        color: #495057;
    }
</style>
@endpush

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    @if(isset($aluno))
                    <i class="bi bi-pencil-square text-warning"></i> Editar Aluno
                    @else
                    <i class="bi bi-person-plus text-success"></i> Novo Aluno
                    @endif
                </h5>
            </div>
            <div class="card-body">
                @php
                // Garantir que $aluno seja tratado corretamente
                $alunoData = [];
                if (isset($aluno)) {
                $alunoData = is_array($aluno) ? $aluno : (array) $aluno;
                }
                $alunoId = $alunoData['id'] ?? $alunoData['ID'] ?? null;
                @endphp

                <form method="POST"
                    action="{{ $alunoId ? route('alunos.update', $alunoId) : route('alunos.store') }}"
                    class="needs-validation"
                    novalidate>
                    @csrf
                    @if($alunoId)
                    @method('PUT')
                    @endif

                    <!-- Dados Pessoais -->
                    <div class="form-section">
                        <h6 class="form-section-title">
                            <i class="bi bi-person-badge"></i> Dados Pessoais
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nome" class="form-label">Nome Completo *</label>
                                <input type="text"
                                    class="form-control @error('nome') is-invalid @enderror"
                                    id="nome"
                                    name="nome"
                                    value="{{ old('nome', $aluno['nome'] ?? '') }}"
                                    required>
                                @error('nome')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2">
                                <label for="documento_unico" class="form-label">CPF *</label>
                                <input type="text"
                                    class="form-control documento_unico-mask @error('documento_unico') is-invalid @enderror"
                                    id="documento_unico"
                                    name="documento_unico"
                                    value="{{ old('documento_unico', $aluno['documento_unico'] ?? '') }}"
                                    maxlength="14"
                                    required>
                                @error('documento_unico')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2">
                                <label for="data_nascimento" class="form-label">Data Nascimento *</label>
                                <input type="date"
                                    class="form-control @error('data_nascimento') is-invalid @enderror"
                                    id="data_nascimento"
                                    name="data_nascimento"
                                    value="{{ old('data_nascimento', $aluno['data_nascimento'] ?? '') }}"
                                    required>
                                @error('data_nascimento')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2">
                                <label for="status" class="form-label">Situação *</label>
                                <select class="form-select @error('status') is-invalid @enderror"
                                    id="status"
                                    name="status"
                                    required>
                                    <option value="ativo" {{ (old('status', $aluno['status'] ?? '') == 'ativo') ? 'selected' : '' }}>Ativo</option>
                                    <option value="inativo" {{ (old('status', $aluno['status'] ?? '') == 'inativo') ? 'selected' : '' }}>Inativo</option>
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
                            <i class="bi bi-telephone"></i> Contato
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="email" class="form-label">E-mail *</label>
                                <input type="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    id="email"
                                    name="email"
                                    value="{{ old('email', $aluno['email'] ?? '') }}"
                                    required>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="telefone" class="form-label">Telefone *</label>
                                <input type="text"
                                    class="form-control phone-mask @error('telefone') is-invalid @enderror"
                                    id="telefone"
                                    name="telefone"
                                    value="{{ old('telefone', $aluno['telefone'] ?? '') }}"
                                    maxlength="15"
                                    required>
                                @error('telefone')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>

                    <!-- Endereço -->
                    <div class="form-section">
                        <h6 class="form-section-title">
                            <i class="bi bi-geo-alt"></i> Endereço
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-2">
                                <label for="cep" class="form-label">CEP</label>
                                <input type="text"
                                    class="form-control cep-mask"
                                    id="cep"
                                    name="cep"
                                    value="{{ old('cep', $aluno['cep'] ?? '') }}"
                                    maxlength="9">
                            </div>

                            <div class="col-md-5">
                                <label for="logradouro" class="form-label">Endereço</label>
                                <input type="text"
                                    class="form-control"
                                    id="logradouro"
                                    name="logradouro"
                                    value="{{ old('logradouro', $aluno['logradouro'] ?? '') }}">
                            </div>

                            <div class="col-md-3">
                                <label for="bairro" class="form-label">Bairro</label>
                                <input type="text"
                                    class="form-control"
                                    id="bairro"
                                    name="bairro"
                                    value="{{ old('bairro', $aluno['bairro'] ?? '') }}">
                            </div>


                            <div class="col-md-2">
                                <label for="uf" class="form-label">UF</label>
                                <select class="form-select" id="uf" name="uf">
                                    <option value="">Selecione</option>
                                    <option value="AC" {{ (old('uf', $aluno['uf'] ?? '') == 'AC') ? 'selected' : '' }}>AC</option>
                                    <option value="AL" {{ (old('uf', $aluno['uf'] ?? '') == 'AL') ? 'selected' : '' }}>AL</option>
                                    <option value="AP" {{ (old('uf', $aluno['uf'] ?? '') == 'AP') ? 'selected' : '' }}>AP</option>
                                    <option value="AM" {{ (old('uf', $aluno['uf'] ?? '') == 'AM') ? 'selected' : '' }}>AM</option>
                                    <option value="BA" {{ (old('uf', $aluno['uf'] ?? '') == 'BA') ? 'selected' : '' }}>BA</option>
                                    <option value="CE" {{ (old('uf', $aluno['uf'] ?? '') == 'CE') ? 'selected' : '' }}>CE</option>
                                    <option value="DF" {{ (old('uf', $aluno['uf'] ?? '') == 'DF') ? 'selected' : '' }}>DF</option>
                                    <option value="ES" {{ (old('uf', $aluno['uf'] ?? '') == 'ES') ? 'selected' : '' }}>ES</option>
                                    <option value="GO" {{ (old('uf', $aluno['uf'] ?? '') == 'GO') ? 'selected' : '' }}>GO</option>
                                    <option value="MA" {{ (old('uf', $aluno['uf'] ?? '') == 'MA') ? 'selected' : '' }}>MA</option>
                                    <option value="MT" {{ (old('uf', $aluno['uf'] ?? '') == 'MT') ? 'selected' : '' }}>MT</option>
                                    <option value="MS" {{ (old('uf', $aluno['uf'] ?? '') == 'MS') ? 'selected' : '' }}>MS</option>
                                    <option value="MG" {{ (old('uf', $aluno['uf'] ?? '') == 'MG') ? 'selected' : '' }}>MG</option>
                                    <option value="PA" {{ (old('uf', $aluno['uf'] ?? '') == 'PA') ? 'selected' : '' }}>PA</option>
                                    <option value="PB" {{ (old('uf', $aluno['uf'] ?? '') == 'PB') ? 'selected' : '' }}>PB</option>
                                    <option value="PR" {{ (old('uf', $aluno['uf'] ?? '') == 'PR') ? 'selected' : '' }}>PR</option>
                                    <option value="PE" {{ (old('uf', $aluno['uf'] ?? '') == 'PE') ? 'selected' : '' }}>PE</option>
                                    <option value="PI" {{ (old('uf', $aluno['uf'] ?? '') == 'PI') ? 'selected' : '' }}>PI</option>
                                    <option value="RJ" {{ (old('uf', $aluno['uf'] ?? '') == 'RJ') ? 'selected' : '' }}>RJ</option>
                                    <option value="RN" {{ (old('uf', $aluno['uf'] ?? '') == 'RN') ? 'selected' : '' }}>RN</option>
                                    <option value="RS" {{ (old('uf', $aluno['uf'] ?? '') == 'RS') ? 'selected' : '' }}>RS</option>
                                    <option value="RO" {{ (old('uf', $aluno['uf'] ?? '') == 'RO') ? 'selected' : '' }}>RO</option>
                                    <option value="RR" {{ (old('uf', $aluno['uf'] ?? '') == 'RR') ? 'selected' : '' }}>RR</option>
                                    <option value="SC" {{ (old('uf', $aluno['uf'] ?? '') == 'SC') ? 'selected' : '' }}>SC</option>
                                    <option value="SP" {{ (old('uf', $aluno['uf'] ?? '') == 'SP') ? 'selected' : '' }}>SP</option>
                                    <option value="SE" {{ (old('uf', $aluno['uf'] ?? '') == 'SE') ? 'selected' : '' }}>SE</option>
                                    <option value="TO" {{ (old('uf', $aluno['uf'] ?? '') == 'TO') ? 'selected' : '' }}>TO</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('alunos.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg"></i>
                            {{ isset($aluno) ? 'Atualizar' : 'Salvar' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {

        $('form').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                success: function(response) {
                    if (response.success) {
                        window.location.href = response.redirect;
                    }
                },
                error: function(xhr) {

                    console.log(xhr.responseJSON);

                    // Tenta extrair a mensagem de erro
                    let errorMsg = 'Erro ao atualizar aluno';

                    if (xhr.responseJSON) {
                        // Se a API retornar JSON com erros de validação
                        if (xhr.responseJSON.dados && xhr.responseJSON.dados.erros) {
                            // Concatena todos os erros
                            const erros = xhr.responseJSON.dados.erros;
                            errorMsg = Object.values(erros).flat().join('\n');
                        } else if (xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                    } else if (xhr.responseText) {
                        // Tenta parsear o responseText
                        try {
                            const data = JSON.parse(xhr.responseText);
                            if (data.dados && data.dados.erros) {
                                errorMsg = Object.values(data.dados.erros).flat().join('\n');
                            }
                        } catch (e) {
                            errorMsg = xhr.responseText;
                        }
                    }

                    alert('Erro de validação:\n' + errorMsg);
                }
            });
        });

        // Máscaras
        function aplicarMascaras() {
            $('.documento_unico-mask').on('input', function() {
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
    });
</script>
@endpush