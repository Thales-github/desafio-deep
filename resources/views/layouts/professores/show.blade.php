 @extends('layouts.app')

 @section('title', 'Detalhes do Professor')

 @section('content')
 <div class="container-fluid">
     <div class="row justify-content-center">
         <div class="col-md-11">
             <!-- Cabeçalho com ações -->
             <div class="d-flex justify-content-between align-items-center mb-4">
                 <h4 class="mb-0">
                     <i class="bi bi-person-badge-fill text-primary me-2"></i>
                     Detalhes do Professor
                 </h4>
                 <div>
                     <a href="{{ route('professores.edit', $professor['id']) }}" class="btn btn-warning">
                         <i class="bi bi-pencil me-1"></i>
                         Editar
                     </a>
                     <a href="{{ route('professores.index') }}" class="btn btn-outline-secondary">
                         <i class="bi bi-arrow-left me-1"></i>
                         Voltar
                     </a>
                 </div>
             </div>

             <!-- Card Principal -->
             <div class="card shadow-sm border-0 mb-4">
                 <div class="card-body">
                     <!-- Header do Professor -->
                     <div class="row mb-4">
                         <div class="col-md-8">
                             <div class="d-flex align-items-center">
                                 <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                                     @if(!empty($professor['foto']))
                                     <img src="{{ $professor['foto'] }}" alt="Foto" class="rounded-circle" width="80" height="80">
                                     @else
                                     <i class="bi bi-person-circle text-primary fs-1"></i>
                                     @endif
                                 </div>
                                 <div>
                                     <h2 class="mb-1">{{ $professor['nome'] }}</h2>
                                     <div class="d-flex gap-3 flex-wrap">
                                         <span class="badge bg-secondary">
                                             <i class="bi bi-upc-scan me-1"></i>
                                             Registro: {{ $professor['registro'] ?? 'N/A' }}
                                         </span>
                                         @if(($professor['status'] ?? 'ativo') == 'ativo')
                                         <span class="badge bg-success">
                                             <i class="bi bi-check-circle me-1"></i>Ativo
                                         </span>
                                         @else
                                         <span class="badge bg-danger">
                                             <i class="bi bi-x-circle me-1"></i>Inativo
                                         </span>
                                         @endif
                                         @if(!empty($professor['nivel']))
                                         <span class="badge bg-info">
                                             <i class="bi bi-mortarboard me-1"></i>
                                             {{ strtoupper($professor['nivel']) }}
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
                                         <div class="fs-3 fw-bold text-primary">{{ count($professor['disciplinas'] ?? []) }}</div>
                                         <small class="text-muted">Disciplinas</small>
                                     </div>
                                 </div>
                                 <div class="col-6">
                                     <div class="bg-light rounded p-3 text-center">
                                         <div class="fs-3 fw-bold text-success">{{ $total_alunos ?? 0 }}</div>
                                         <small class="text-muted">Total Alunos</small>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>

                     <!-- Grid de Informações -->
                     <div class="row">
                         <!-- Coluna Esquerda -->
                         <div class="col-md-6">
                             <!-- Dados Pessoais -->
                             <div class="card border-0 bg-light mb-3">
                                 <div class="card-body">
                                     <h6 class="text-primary mb-3">
                                         <i class="bi bi-person-badge me-2"></i>
                                         Dados Pessoais
                                     </h6>
                                     <table class="table table-sm table-borderless">
                                         <tr>
                                             <td width="40%" class="text-muted">Nome Completo:</td>
                                             <td><strong>{{ $professor['nome'] }}</strong></td>
                                         </tr>
                                         <tr>
                                             <td class="text-muted">Data Nascimento:</td>
                                             <td>
                                                 <strong>{{ \Carbon\Carbon::parse($professor['data_nascimento'])->format('d/m/Y') }}</strong>
                                                 ({{ \Carbon\Carbon::parse($professor['data_nascimento'])->age }} anos)
                                             </td>
                                         </tr>
                                         <tr>
                                             <td class="text-muted">CPF:</td>
                                             <td><strong>{{ $professor['cpf'] }}</strong></td>
                                         </tr>
                                         <tr>
                                             <td class="text-muted">RG:</td>
                                             <td><strong>{{ $professor['rg'] ?? 'Não informado' }}</strong></td>
                                         </tr>
                                         <tr>
                                             <td class="text-muted">Registro Profissional:</td>
                                             <td><strong>{{ $professor['registro'] ?? 'Não informado' }}</strong></td>
                                         </tr>
                                     </table>
                                 </div>
                             </div>

                             <!-- Contato -->
                             <div class="card border-0 bg-light mb-3">
                                 <div class="card-body">
                                     <h6 class="text-primary mb-3">
                                         <i class="bi bi-telephone me-2"></i>
                                         Contato
                                     </h6>
                                     <table class="table table-sm table-borderless">
                                         <tr>
                                             <td width="40%" class="text-muted">E-mail:</td>
                                             <td>
                                                 <strong>{{ $professor['email'] }}</strong>
                                                 <a href="mailto:{{ $professor['email'] }}" class="ms-2 text-primary">
                                                     <i class="bi bi-envelope-fill"></i>
                                                 </a>
                                             </td>
                                         </tr>
                                         <tr>
                                             <td class="text-muted">Telefone:</td>
                                             <td>
                                                 <strong>{{ $professor['telefone'] }}</strong>
                                                 <a href="tel:{{ $professor['telefone'] }}" class="ms-2 text-primary">
                                                     <i class="bi bi-telephone-fill"></i>
                                                 </a>
                                             </td>
                                         </tr>
                                         @if(!empty($professor['celular']))
                                         <tr>
                                             <td class="text-muted">Celular:</td>
                                             <td>
                                                 <strong>{{ $professor['celular'] }}</strong>
                                                 <a href="tel:{{ $professor['celular'] }}" class="ms-2 text-primary">
                                                     <i class="bi bi-phone-fill"></i>
                                                 </a>
                                             </td>
                                         </tr>
                                         @endif
                                     </table>
                                 </div>
                             </div>

                             <!-- Endereço -->
                             @if(!empty($professor['logradouro']) || !empty($professor['cidade']))
                             <div class="card border-0 bg-light mb-3">
                                 <div class="card-body">
                                     <h6 class="text-primary mb-3">
                                         <i class="bi bi-geo-alt me-2"></i>
                                         Endereço
                                     </h6>
                                     <table class="table table-sm table-borderless">
                                         @if(!empty($professor['logradouro']))
                                         <tr>
                                             <td width="40%" class="text-muted">Logradouro:</td>
                                             <td><strong>{{ $professor['logradouro'] }}, {{ $professor['numero'] }}</strong></td>
                                         </tr>
                                         @endif
                                         @if(!empty($professor['complemento']))
                                         <tr>
                                             <td class="text-muted">Complemento:</td>
                                             <td><strong>{{ $professor['complemento'] }}</strong></td>
                                         </tr>
                                         @endif
                                         @if(!empty($professor['bairro']))
                                         <tr>
                                             <td class="text-muted">Bairro:</td>
                                             <td><strong>{{ $professor['bairro'] }}</strong></td>
                                         </tr>
                                         @endif
                                         @if(!empty($professor['cidade']))
                                         <tr>
                                             <td class="text-muted">Cidade/UF:</td>
                                             <td><strong>{{ $professor['cidade'] }}/{{ $professor['uf'] ?? '' }}</strong></td>
                                         </tr>
                                         @endif
                                         @if(!empty($professor['cep']))
                                         <tr>
                                             <td class="text-muted">CEP:</td>
                                             <td><strong>{{ $professor['cep'] }}</strong></td>
                                         </tr>
                                         @endif
                                     </table>
                                 </div>
                             </div>
                             @endif
                         </div>

                         <!-- Coluna Direita -->
                         <div class="col-md-6">
                             <!-- Dados Profissionais -->
                             <div class="card border-0 bg-light mb-3">
                                 <div class="card-body">
                                     <h6 class="text-primary mb-3">
                                         <i class="bi bi-briefcase me-2"></i>
                                         Dados Profissionais
                                     </h6>
                                     <table class="table table-sm table-borderless">
                                         @if(!empty($professor['especializacao']))
                                         <tr>
                                             <td width="40%" class="text-muted">Especialização:</td>
                                             <td><strong>{{ $professor['especializacao'] }}</strong></td>
                                         </tr>
                                         @endif
                                         @if(!empty($professor['formacao']))
                                         <tr>
                                             <td class="text-muted">Formação:</td>
                                             <td><strong>{{ $professor['formacao'] }}</strong></td>
                                         </tr>
                                         @endif
                                         @if(!empty($professor['nivel']))
                                         <tr>
                                             <td class="text-muted">Nível:</td>
                                             <td>
                                                 @switch($professor['nivel'])
                                                 @case('graduacao')
                                                 <span class="badge bg-primary">Graduação</span>
                                                 @break
                                                 @case('especialista')
                                                 <span class="badge bg-info">Especialista</span>
                                                 @break
                                                 @case('mestre')
                                                 <span class="badge bg-success">Mestre</span>
                                                 @break
                                                 @case('doutor')
                                                 <span class="badge bg-warning">Doutor</span>
                                                 @break
                                                 @case('phd')
                                                 <span class="badge bg-danger">PhD</span>
                                                 @break
                                                 @default
                                                 {{ $professor['nivel'] }}
                                                 @endswitch
                                             </td>
                                         </tr>
                                         @endif
                                         @if(!empty($professor['data_admissao']))
                                         <tr>
                                             <td class="text-muted">Data Admissão:</td>
                                             <td>
                                                 <strong>{{ \Carbon\Carbon::parse($professor['data_admissao'])->format('d/m/Y') }}</strong>
                                                 @php
                                                 $dataAdmissao = \Carbon\Carbon::parse($professor['data_admissao']);
                                                 $tempoCasa = $dataAdmissao->diffInMonths(now());
                                                 $anos = floor($tempoCasa / 12);
                                                 $meses = $tempoCasa % 12;
                                                 @endphp
                                                 @if($anos > 0 || $meses > 0)
                                                 <br>
                                                 <small class="text-muted">
                                                     ({{ $anos > 0 ? $anos . ' ano(s)' : '' }} {{ $meses > 0 ? $meses . ' mês(es)' : '' }} de casa)
                                                 </small>
                                                 @endif
                                             </td>
                                         </tr>
                                         @endif
                                         @if(!empty($professor['carga_horaria']))
                                         <tr>
                                             <td class="text-muted">Carga Horária:</td>
                                             <td><strong>{{ $professor['carga_horaria'] }} horas/semana</strong></td>
                                         </tr>
                                         @endif
                                     </table>
                                 </div>
                             </div>

                             <!-- Estatísticas -->
                             <div class="card border-0 bg-light mb-3">
                                 <div class="card-body">
                                     <h6 class="text-primary mb-3">
                                         <i class="bi bi-graph-up me-2"></i>
                                         Estatísticas de Aulas
                                     </h6>
                                     <div class="row text-center">
                                         <div class="col-6">
                                             <div class="p-2">
                                                 <span class="d-block fs-4 fw-bold text-success">{{ $estatisticas['total_turmas'] ?? 0 }}</span>
                                                 <small class="text-muted">Turmas</small>
                                             </div>
                                         </div>
                                         <div class="col-6">
                                             <div class="p-2">
                                                 <span class="d-block fs-4 fw-bold text-info">{{ $estatisticas['carga_total'] ?? 0 }}h</span>
                                                 <small class="text-muted">Carga Total</small>
                                             </div>
                                         </div>
                                         <div class="col-6">
                                             <div class="p-2">
                                                 <span class="d-block fs-4 fw-bold text-warning">{{ $estatisticas['media_alunos'] ?? 0 }}</span>
                                                 <small class="text-muted">Média Alunos/Turma</small>
                                             </div>
                                         </div>
                                         <div class="col-6">
                                             <div class="p-2">
                                                 <span class="d-block fs-4 fw-bold text-primary">{{ $estatisticas['aprovacao'] ?? 0 }}%</span>
                                                 <small class="text-muted">Taxa Aprovação</small>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>

                             <!-- Observações -->
                             @if(!empty($professor['observacoes']))
                             <div class="card border-0 bg-light mb-3">
                                 <div class="card-body">
                                     <h6 class="text-primary mb-3">
                                         <i class="bi bi-chat-text me-2"></i>
                                         Observações
                                     </h6>
                                     <p class="mb-0" style="white-space: pre-line;">{{ $professor['observacoes'] }}</p>
                                 </div>
                             </div>
                             @endif
                         </div>
                     </div>

                     <!-- Disciplinas Ministradas -->
                     <div class="mt-4">
                         <div class="d-flex justify-content-between align-items-center mb-3">
                             <h5 class="mb-0">
                                 <i class="bi bi-book-fill text-primary me-2"></i>
                                 Disciplinas Ministradas ({{ count($professor['disciplinas'] ?? []) }})
                             </h5>
                         </div>

                         @if(!empty($professor['disciplinas']) && count($professor['disciplinas']) > 0)
                         <div class="table-responsive">
                             <table class="table table-hover align-middle">
                                 <thead class="table-light">
                                     <tr>
                                         <th>Código</th>
                                         <th>Disciplina</th>
                                         <th>Período</th>
                                         <th>Carga Horária</th>
                                         <th>Alunos</th>
                                         <th>Status</th>
                                         <th>Ações</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     @foreach($professor['disciplinas'] as $disciplina)
                                     <tr>
                                         <td>
                                             <span class="badge bg-light text-dark">
                                                 {{ $disciplina['codigo'] ?? 'N/A' }}
                                             </span>
                                         </td>
                                         <td>
                                             <strong>{{ $disciplina['nome'] }}</strong>
                                             @if(!empty($disciplina['descricao']))
                                             <br>
                                             <small class="text-muted">{{ Str::limit($disciplina['descricao'], 50) }}</small>
                                             @endif
                                         </td>
                                         <td>{{ $disciplina['periodo'] ?? 'N/A' }}º Período</td>
                                         <td>{{ $disciplina['carga_horaria'] }}h</td>
                                         <td>
                                             <span class="badge bg-info">
                                                 <i class="bi bi-people me-1"></i>
                                                 {{ count($disciplina['alunos'] ?? []) }}
                                             </span>
                                         </td>
                                         <td>
                                             @if(($disciplina['status'] ?? 'ativo') == 'ativo')
                                             <span class="badge bg-success">Ativa</span>
                                             @else
                                             <span class="badge bg-danger">Inativa</span>
                                             @endif
                                         </td>
                                         <td>
                                             <div class="btn-group" role="group">
                                                 <a href="{{ route('disciplinas.show', $disciplina['id']) }}"
                                                     class="btn btn-sm btn-outline-info"
                                                     title="Ver disciplina">
                                                     <i class="bi bi-eye"></i>
                                                 </a>
                                                 <a href="{{ route('disciplinas.edit', $disciplina['id']) }}"
                                                     class="btn btn-sm btn-outline-warning"
                                                     title="Editar disciplina">
                                                     <i class="bi bi-pencil"></i>
                                                 </a>
                                             </div>
                                         </td>
                                     </tr>
                                     @endforeach
                                 </tbody>
                             </table>
                         </div>

                         <!-- Resumo das disciplinas -->
                         <div class="row mt-3">
                             <div class="col-md-12">
                                 <div class="bg-light p-3 rounded">
                                     <div class="row">
                                         <div class="col-md-4">
                                             <small class="text-muted d-block">Carga horária total:</small>
                                             <strong>{{ collect($professor['disciplinas'])->sum('carga_horaria') }} horas</strong>
                                         </div>
                                         <div class="col-md-4">
                                             <small class="text-muted d-block">Total de alunos:</small>
                                             <strong>{{ collect($professor['disciplinas'])->sum(function($d) { return count($d['alunos'] ?? []); }) }} alunos</strong>
                                         </div>
                                         <div class="col-md-4">
                                             <small class="text-muted d-block">Disciplinas ativas:</small>
                                             <strong>{{ collect($professor['disciplinas'])->where('status', 'ativo')->count() }} ativas</strong>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                         @else
                         <div class="text-center py-5 bg-light rounded">
                             <i class="bi bi-book display-1 text-muted"></i>
                             <p class="text-muted fs-5 mt-3">Professor não ministra nenhuma disciplina no momento</p>
                             <a href="{{ route('disciplinas.create', ['professor_id' => $professor['id']]) }}"
                                 class="btn btn-primary">
                                 <i class="bi bi-plus-circle me-1"></i>
                                 Atribuir Disciplina
                             </a>
                         </div>
                         @endif
                     </div>

                     <!-- Horário de Aulas -->
                     @if(!empty($horario_aulas) && count($horario_aulas) > 0)
                     <div class="mt-4">
                         <h5 class="mb-3">
                             <i class="bi bi-calendar-week text-primary me-2"></i>
                             Horário de Aulas
                         </h5>
                         <div class="table-responsive">
                             <table class="table table-bordered">
                                 <thead class="table-light">
                                     <tr>
                                         <th>Horário</th>
                                         <th>Segunda</th>
                                         <th>Terça</th>
                                         <th>Quarta</th>
                                         <th>Quinta</th>
                                         <th>Sexta</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     @foreach($horario_aulas as $horario)
                                     <tr>
                                         <td class="fw-bold">{{ $horario['hora'] }}</td>
                                         <td>{{ $horario['segunda'] ?? '-' }}</td>
                                         <td>{{ $horario['terca'] ?? '-' }}</td>
                                         <td>{{ $horario['quarta'] ?? '-' }}</td>
                                         <td>{{ $horario['quinta'] ?? '-' }}</td>
                                         <td>{{ $horario['sexta'] ?? '-' }}</td>
                                     </tr>
                                     @endforeach
                                 </tbody>
                             </table>
                         </div>
                     </div>
                     @endif

                     <!-- Últimas Avaliações -->
                     @if(!empty($ultimas_avaliacoes) && count($ultimas_avaliacoes) > 0)
                     <div class="mt-4">
                         <h5 class="mb-3">
                             <i class="bi bi-star text-primary me-2"></i>
                             Últimas Avaliações
                         </h5>
                         <div class="list-group">
                             @foreach($ultimas_avaliacoes as $avaliacao)
                             <div class="list-group-item">
                                 <div class="d-flex justify-content-between align-items-center">
                                     <div>
                                         <strong>{{ $avaliacao['disciplina'] }}</strong>
                                         <br>
                                         <small class="text-muted">
                                             Turma: {{ $avaliacao['turma'] }} |
                                             Data: {{ \Carbon\Carbon::parse($avaliacao['data'])->format('d/m/Y') }}
                                         </small>
                                     </div>
                                     <div class="text-end">
                                         <span class="d-block fs-4 fw-bold text-warning">{{ number_format($avaliacao['nota'], 1) }}</span>
                                         <small class="text-muted">/10</small>
                                     </div>
                                 </div>
                             </div>
                             @endforeach
                         </div>
                     </div>
                     @endif
                 </div>

                 <!-- Rodapé com informações de auditoria -->
                 <div class="card-footer bg-white">
                     <div class="row">
                         <div class="col-md-6">
                             <small class="text-muted">
                                 <i class="bi bi-clock-history me-1"></i>
                                 Cadastrado em: {{ \Carbon\Carbon::parse($professor['created_at'] ?? now())->format('d/m/Y H:i:s') }}
                             </small>
                         </div>
                         <div class="col-md-6 text-end">
                             <small class="text-muted">
                                 <i class="bi bi-arrow-repeat me-1"></i>
                                 Última atualização: {{ \Carbon\Carbon::parse($professor['updated_at'] ?? now())->format('d/m/Y H:i:s') }}
                             </small>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>

 <!-- Modal de confirmação para ações -->
 <div class="modal fade" id="modalAcao" tabindex="-1">
     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="modalAcaoTitulo">Confirmar Ação</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
             </div>
             <div class="modal-body" id="modalAcaoMensagem">
                 <p>Tem certeza que deseja realizar esta ação?</p>
             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                 <button type="button" class="btn btn-primary" id="modalAcaoConfirmar">Confirmar</button>
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

         // Gráfico de desempenho (se quiser adicionar)
         @if(!empty($estatisticas))
         // Código para gráfico se necessário
         @endif

         // Função para confirmar ações
         window.confirmarAcao = function(titulo, mensagem, callback) {
             $('#modalAcaoTitulo').text(titulo);
             $('#modalAcaoMensagem').html(mensagem);
             $('#modalAcaoConfirmar').off('click').on('click', function() {
                 callback();
                 bootstrap.Modal.getInstance(document.getElementById('modalAcao')).hide();
             });
             new bootstrap.Modal(document.getElementById('modalAcao')).show();
         };

         // Exemplo: Inativar professor
         $('#btnInativar').on('click', function() {
             confirmarAcao(
                 'Inativar Professor',
                 '<p>Tem certeza que deseja inativar o professor <strong>{{ $professor['
                 nome '] }}</strong>?</p>' +
                 '<p class="text-warning mb-0"><i class="bi bi-exclamation-triangle me-1"></i>' +
                 'Isso pode afetar as disciplinas que ele ministra.</p>',
                 function() {
                     // Aqui faria a requisição para inativar
                     alert('Professor inativado com sucesso!');
                 }
             );
         });
     });
 </script>
 @endpush