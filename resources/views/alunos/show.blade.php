@extends('layouts.app')

@section('title', 'Detalhes do Aluno')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bi bi-person-lines-fill text-info"></i> Detalhes do Aluno
                </h5>
                <div>
                    <a href="{{ route('alunos.edit', $aluno['id']) }}" class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil"></i> Editar
                    </a>
                    <a href="{{ route('alunos.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left"></i> Voltar
                    </a>
                </div>
            </div>

            <div class="card-body">
                <!-- Cabeçalho com informações básicas -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="bg-light p-4 rounded">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h3 class="mb-2">{{ $aluno['nome'] }}</h3>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p class="mb-1">
                                                <i class="bi bi-envelope-fill text-primary me-2"></i>
                                                {{ $aluno['email'] }}
                                            </p>
                                            <p class="mb-1">
                                                <i class="bi bi-telephone-fill text-primary me-2"></i>
                                                {{ $aluno['telefone'] }}
                                                @if(!empty($aluno['celular']))
                                                / {{ $aluno['celular'] }}
                                                @endif
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="mb-1">
                                                <i bi bi-calendar-fill text-primary me-2"></i>
                                                Nascimento: {{ \Carbon\Carbon::parse($aluno['data_nascimento'])->format('d/m/Y') }}
                                            </p>
                                            <p class="mb-1">
                                                <i class="bi bi-card-text text-primary me-2"></i>
                                                CPF: {{ $aluno['documento_unico'] }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 text-end">
                                    @if($aluno['ativo'] == 'ativo')
                                    <span class="badge bg-success p-3">
                                        <i class="bi bi-check-circle"></i> ATIVO
                                    </span>
                                    @else
                                    <span class="badge bg-danger p-3">
                                        <i class="bi bi-x-circle"></i> INATIVO
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Grid de informações -->
                <div class="row">
                    <!-- Dados Pessoais -->
                    <div class="col-md-6 mb-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-header bg-white border-0">
                                <h6 class="text-primary mb-0">
                                    <i class="bi bi-person-badge me-2"></i>Dados Pessoais
                                </h6>
                            </div>
                            <div class="card-body pt-0">
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <td width="40%" class="text-muted">Nome Completo:</td>
                                        <td><strong>{{ $aluno['nome'] }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Data Nascimento:</td>
                                        <td><strong>{{ \Carbon\Carbon::parse($aluno['data_nascimento'])->format('d/m/Y') }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Idade:</td>
                                        <td><strong>{{ \Carbon\Carbon::parse($aluno['data_nascimento'])->age }} anos</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">CPF:</td>
                                        <td><strong>{{ $aluno['documento_unico'] }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">RG:</td>
                                        <td><strong>{{ $aluno['rg'] ?? 'Não informado' }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Status:</td>
                                        <td>
                                            @if($aluno['ativo'] == 'ativo')
                                            <span class="badge bg-success">Ativo</span>
                                            @else
                                            <span class="badge bg-danger">Inativo</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Contato -->
                    <div class="col-md-6 mb-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-header bg-white border-0">
                                <h6 class="text-primary mb-0">
                                    <i class="bi bi-telephone me-2"></i>Contato
                                </h6>
                            </div>
                            <div class="card-body pt-0">
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <td width="40%" class="text-muted">E-mail:</td>
                                        <td><strong>{{ $aluno['email'] }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Telefone:</td>
                                        <td><strong>{{ $aluno['telefone'] }}</strong></td>
                                    </tr>

                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Endereço -->
                    @if(!empty($aluno['logradouro']) || !empty($aluno['cidade']))
                    <div class="col-md-6 mb-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white border-0">
                                <h6 class="text-primary mb-0">
                                    <i class="bi bi-geo-alt me-2"></i>Endereço
                                </h6>
                            </div>
                            <div class="card-body pt-0">
                                <table class="table table-sm table-borderless">
                                    @if(!empty($aluno['logradouro']))
                                    <tr>
                                        <td width="40%" class="text-muted">Logradouro:</td>
                                        <td><strong>{{ $aluno['logradouro'] }}</strong></td>
                                    </tr>
                                    @endif
                                    @if(!empty($aluno['complemento']))
                                    <tr>
                                        <td class="text-muted">Complemento:</td>
                                        <td><strong>{{ $aluno['complemento'] }}</strong></td>
                                    </tr>
                                    @endif
                                    @if(!empty($aluno['bairro']))
                                    <tr>
                                        <td class="text-muted">Bairro:</td>
                                        <td><strong>{{ $aluno['bairro'] }}</strong></td>
                                    </tr>
                                    @endif
                                    @if(!empty($aluno['cidade']))
                                    <tr>
                                        <td class="text-muted">Cidade/UF:</td>
                                        <td><strong>{{ $aluno['cidade'] }}/{{ $aluno['uf'] ?? '' }}</strong></td>
                                    </tr>
                                    @endif
                                    @if(!empty($aluno['cep']))
                                    <tr>
                                        <td class="text-muted">CEP:</td>
                                        <td><strong>{{ $aluno['cep'] }}</strong></td>
                                    </tr>
                                    @endif
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Informações Familiares -->
                    <div class="col-md-6 mb-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white border-0">
                                <h6 class="text-primary mb-0">
                                    <i class="bi bi-people me-2"></i>Filiação
                                </h6>
                            </div>
                            <div class="card-body pt-0">
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <td width="40%" class="text-muted">Mãe:</td>
                                        <td><strong>{{ $aluno['nome_mae'] ?? 'Não informado' }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Pai:</td>
                                        <td><strong>{{ $aluno['nome_pai'] ?? 'Não informado' }}</strong></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Observações -->
                    @if(!empty($aluno['observacoes']))
                    <div class="col-12 mb-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white border-0">
                                <h6 class="text-primary mb-0">
                                    <i class="bi bi-chat-text me-2"></i>Observações
                                </h6>
                            </div>
                            <div class="card-body">
                                <p class="mb-0">{{ $aluno['observacoes'] }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Disciplinas Matriculadas -->
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                <h6 class="text-primary mb-0">
                                    <i class="bi bi-book me-2"></i>Disciplinas Matriculadas
                                </h6>
                                <a href="{{ route('alunos-disciplinas.create', ['aluno_id' => $aluno['id']]) }}"
                                    class="btn btn-primary btn-sm">
                                    <i class="bi bi-plus-circle"></i> Nova Matrícula
                                </a>
                            </div>
                            <div class="card-body">
                                @if(!empty($aluno['disciplinas']) && count($aluno['disciplinas']) > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Disciplina</th>
                                                <th>Professor</th>
                                                <th>Carga Horária</th>
                                                <th>Período</th>
                                                <th>Status</th>
                                                <th>Nota</th>
                                                <th>Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($aluno['disciplinas'] as $disciplina)
                                            <tr>
                                                <td>
                                                    <strong>{{ $disciplina['nome'] }}</strong>
                                                    <br>
                                                    <small class="text-muted">Cód: {{ $disciplina['codigo'] ?? '' }}</small>
                                                </td>
                                                <td>
                                                    @if(!empty($disciplina['professor']))
                                                    {{ $disciplina['professor']['nome'] ?? 'N/A' }}
                                                    @else
                                                    <span class="text-muted">Não atribuído</span>
                                                    @endif
                                                </td>
                                                <td>{{ $disciplina['carga_horaria'] ?? 0 }}h</td>
                                                <td>{{ $disciplina['pivot']['periodo'] ?? 'N/A' }}</td>
                                                <td>
                                                    @switch($disciplina['pivot']['status'] ?? 'cursando')
                                                    @case('cursando')
                                                    <span class="badge bg-warning">Cursando</span>
                                                    @break
                                                    @case('aprovado')
                                                    <span class="badge bg-success">Aprovado</span>
                                                    @break
                                                    @case('reprovado')
                                                    <span class="badge bg-danger">Reprovado</span>
                                                    @break
                                                    @case('trancado')
                                                    <span class="badge bg-secondary">Trancado</span>
                                                    @break
                                                    @default
                                                    <span class="badge bg-warning">Cursando</span>
                                                    @endswitch
                                                </td>
                                                <td>
                                                    @if(!empty($disciplina['pivot']['nota']))
                                                    <strong>{{ number_format($disciplina['pivot']['nota'], 1) }}</strong>
                                                    @else
                                                    -
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('alunos-disciplinas.edit', $disciplina['pivot']['id'] ?? 0) }}"
                                                        class="btn btn-sm btn-outline-warning"
                                                        title="Editar matrícula">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-danger"
                                                        onclick="confirmarRemocaoDisciplina({{ $disciplina['pivot']['id'] ?? 0 }}, '{{ $disciplina['nome'] }}')"
                                                        title="Remover matrícula">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @else
                                <div class="text-center py-4">
                                    <i class="bi bi-journal-x display-4 text-muted"></i>
                                    <p class="text-muted mt-2 mb-0">Aluno não possui disciplinas matriculadas</p>
                                    <a href="{{ route('alunos-disciplinas.create', ['aluno_id' => $aluno['id']]) }}"
                                        class="btn btn-primary btn-sm mt-3">
                                        <i class="bi bi-plus-circle"></i> Matricular em Disciplina
                                    </a>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer bg-white">
                <div class="row">
                    <div class="col-md-6">
                        <small class="text-muted">
                            <i class="bi bi-clock"></i> Cadastrado em: {{ \Carbon\Carbon::parse($aluno['created_at'] ?? now())->format('d/m/Y H:i') }}
                        </small>
                    </div>
                    <div class="col-md-6 text-end">
                        <small class="text-muted">
                            <i class="bi bi-arrow-repeat"></i> Última atualização: {{ \Carbon\Carbon::parse($aluno['updated_at'] ?? now())->format('d/m/Y H:i') }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmação para remover disciplina -->
<div class="modal fade" id="modalRemoverDisciplina" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar Remoção</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja remover a matrícula da disciplina <strong id="disciplinaNome"></strong>?</p>
                <p class="text-danger mb-0"><small>Esta ação não pode ser desfeita.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="formRemoverDisciplina" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Remover Matrícula</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function confirmarRemocaoDisciplina(id, nome) {
        document.getElementById('disciplinaNome').textContent = nome;
        document.getElementById('formRemoverDisciplina').action = `/alunos-disciplinas/${id}`;
        new bootstrap.Modal(document.getElementById('modalRemoverDisciplina')).show();
    }
</script>
@endpush