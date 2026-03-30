@extends('layouts.app')

@section('title', isset($professor) ? 'Editar Professor' : 'Novo Professor')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    @if(isset($professor))
                    <i class="bi bi-pencil-square text-warning"></i> Editar Professor
                    @else
                    <i class="bi bi-person-plus text-success"></i> Novo Professor
                    @endif
                </h5>
            </div>
            <div class="card-body">
                @php
                $professorData = [];
                if (isset($professor)) {
                $professorData = is_array($professor) ? $professor : (array) $professor;
                }
                $professorId = $professorData['id'] ?? null;
                @endphp

                <form method="POST"
                    action="{{ $professorId ? route('professores.update', $professorId) : route('professores.store') }}"
                    novalidate>
                    @csrf
                    @if($professorId)
                    @method('PUT')
                    @endif

                    <div class="row g-3">
                        <div class="col-md-8">
                            <label for="nome" class="form-label">Nome Completo *</label>
                            <input type="text" class="form-control @error('nome') is-invalid @enderror"
                                id="nome" name="nome"
                                value="{{ old('nome', $professorData['nome'] ?? '') }}" required>
                        </div>

                        <div class="col-md-4">
                            <label for="documento_unico" class="form-label">CPF *</label>
                            <input type="text" class="form-control documento_unico-mask @error('documento_unico') is-invalid @enderror"
                                id="documento_unico" name="documento_unico"
                                value="{{ old('documento_unico', $professorData['documento_unico'] ?? '') }}"
                                maxlength="14" required>
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label">E-mail *</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                id="email" name="email"
                                value="{{ old('email', $professorData['email'] ?? '') }}" required>
                        </div>

                        <div class="col-md-3">
                            <label for="data_nascimento" class="form-label">Data Nascimento *</label>
                            <input type="date" class="form-control @error('data_nascimento') is-invalid @enderror"
                                id="data_nascimento" name="data_nascimento"
                                value="{{ old('data_nascimento', $professorData['data_nascimento'] ?? '') }}" required>
                        </div>

                        <div class="col-md-3">
                            <label for="telefone" class="form-label">Telefone</label>
                            <input type="text" class="form-control phone-mask @error('telefone') is-invalid @enderror"
                                id="telefone" name="telefone"
                                value="{{ old('telefone', $professorData['telefone'] ?? '') }}" maxlength="15">
                        </div>

                        <div class="col-md-6">
                            <label for="nivel_formacao" class="form-label">Nível de Formação *</label>
                            <select class="form-select @error('nivel_formacao') is-invalid @enderror"
                                id="nivel_formacao" name="nivel_formacao" required>
                                <option value="0" {{ (string) old('nivel_formacao', $professorData['nivel_formacao'] ?? '0') === '0' ? 'selected' : '' }}>Graduação</option>
                                <option value="1" {{ (string) old('nivel_formacao', $professorData['nivel_formacao'] ?? '') === '1' ? 'selected' : '' }}>Pós-graduação</option>
                                <option value="2" {{ (string) old('nivel_formacao', $professorData['nivel_formacao'] ?? '') === '2' ? 'selected' : '' }}>Mestrado</option>
                                <option value="3" {{ (string) old('nivel_formacao', $professorData['nivel_formacao'] ?? '') === '3' ? 'selected' : '' }}>Doutorado</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="ativo" class="form-label">Situação *</label>
                            <select class="form-select @error('ativo') is-invalid @enderror"
                                id="ativo" name="ativo" required>
                                <option value="1" {{ (string) old('ativo', $professorData['ativo'] ?? '') === '1' ? 'selected' : '' }}>Ativo</option>
                                <option value="0" {{ (string) old('ativo', $professorData['ativo'] ?? '0') === '0' ? 'selected' : '' }}>Inativo</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('professores.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg"></i>
                            {{ isset($professor) ? 'Atualizar' : 'Salvar' }}
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
                    let errorMsg = 'Erro ao salvar professor';

                    if (xhr.responseJSON) {
                        if (xhr.responseJSON.errors) {
                            errorMsg = Object.values(xhr.responseJSON.errors).flat().join('\n');
                        } else if (xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                    }

                    alert('Erro de validação:\n' + errorMsg);
                }
            });
        });

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
    });
</script>
@endpush
