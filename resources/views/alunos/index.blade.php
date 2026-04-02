@extends('layouts.app')

@php
    $alunosLista = is_array($alunos ?? null) ? $alunos : [];
    $temAlunos = count($alunosLista) > 0;
@endphp

@section('title', 'Lista de Alunos')

@push('styles')
<style>
    .table-actions {
        white-space: nowrap;
        width: 1%;
    }

    .btn-action {
        padding: 0.25rem 0.5rem;
        margin: 0 0.125rem;
    }

    .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .card-header h5 {
        margin: 0;
        font-weight: 600;
    }

    .card-header .btn-primary {
        background: white;
        color: #667eea;
        border: none;
        font-weight: 500;
    }

    .card-header .btn-primary:hover {
        background: #f8f9fa;
        color: #764ba2;
    }

    .table thead th {
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
        color: #495057;
        font-weight: 600;
    }

    .badge {
        padding: 0.5em 0.75em;
        font-weight: 500;
    }

    .dataTables_wrapper .dataTables_length select,
    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
        padding: 0.375rem 0.75rem;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0.375rem 0.75rem;
        margin: 0 0.125rem;
        border-radius: 0.375rem;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: #667eea !important;
        color: white !important;
        border: none;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="card shadow-lg border-0">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="bi bi-people-fill me-2"></i> Lista de Alunos
            </h5>
            <a href="{{ route('alunos.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle me-1"></i> Novo Aluno
            </a>
        </div>

        <div class="card-body">
            <!-- Mensagens de sucesso/erro -->
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @unless($temAlunos)
            <!-- Estado vazio: fora da tabela — DataTables não aceita colspan no tbody -->
            <div class="text-center py-5 text-muted border rounded bg-light">
                <i class="bi bi-inbox display-1 d-block mb-3"></i>
                <h5>Nenhum aluno cadastrado</h5>
                <p class="mb-3">Comece cadastrando seu primeiro aluno.</p>
                <a href="{{ route('alunos.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i>
                    Cadastrar Aluno
                </a>
            </div>
            @endunless

            <!-- Tabela de Alunos (tbody só com linhas 1:1 com colunas — evita alerta do DataTables) -->
            <div class="table-responsive {{ $temAlunos ? '' : 'd-none' }}">
                <table class="table table-hover table-striped" id="alunosTable">
                    <thead>
                        <tr>
                            <th width="50">ID</th>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Data Nasc.</th>
                            <th>Telefone</th>
                            <th width="100">Status</th>
                            <th width="150">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($alunosLista as $aluno)
                        <tr>
                            <td><span class="badge bg-light text-dark">{{ $aluno['id'] }}</span></td>

                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 p-2 rounded-circle me-2">
                                        <i class="bi bi-person-circle text-primary"></i>
                                    </div>
                                    <strong>{{ $aluno['nome'] ?? 'N/A' }}</strong>
                                </div>
                            </td>

                            <td>
                                <span class="text-decoration-none">
                                    <i class="bi bi-envelope me-1"></i>
                                    {{ $aluno['email'] ?? 'N/A' }}
                                </span>
                            </td>

                            <td>
                                @if(!empty($aluno['data_nascimento']))
                                <span class="text-muted">
                                    <i class="bi bi-calendar me-1"></i>
                                    {{ \Carbon\Carbon::parse($aluno['data_nascimento'])->format('d/m/Y') }}
                                </span>
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>

                            <td>
                                @if(!empty($aluno['telefone']))
                                <span class="text-decoration-none">
                                    <i class="bi bi-telephone me-1"></i>
                                    {{ $aluno['telefone'] }}
                                </span>
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>

                            <td>
                                @if(($aluno['ativo'] ?? 0) == 1)
                                <span class="badge bg-success">
                                    <i class="bi bi-check-circle me-1"></i>Ativo
                                </span>
                                @else
                                <span class="badge bg-danger">
                                    <i class="bi bi-x-circle me-1"></i>Inativo
                                </span>
                                @endif
                            </td>

                            <td class="table-actions">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('alunos.edit', $aluno['id'] ?? 0) }}"
                                        class="btn btn-sm btn-warning"
                                        title="Editar"
                                        data-bs-toggle="tooltip">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button"
                                        class="btn btn-sm btn-danger btn-delete"
                                        data-id="{{ $aluno['id'] ?? 0 }}"
                                        data-name="{{ $aluno['nome'] ?? '' }}"
                                        title="Excluir"
                                        data-bs-toggle="tooltip">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Rodapé com estatísticas -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="bg-light p-3 rounded">
                        <div class="row text-center">
                            <div class="col-md-4">
                                <span class="d-block fs-4 fw-bold text-primary">{{ count($alunosLista) }}</span>
                                <small class="text-muted">Total de Alunos</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmação de Exclusão -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="bi bi-exclamation-triangle-fill text-warning me-2"></i>
                    Confirmar Exclusão
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir o aluno?</p>
                <div class="bg-light p-3 rounded">
                    <strong id="deleteName"></strong>
                </div>
                <p class="text-danger mt-3 mb-0">
                    <i class="bi bi-info-circle me-1"></i>
                    Esta ação não pode ser desfeita.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg me-1"></i>
                    Cancelar
                </button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i>
                        Excluir
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
        var temAlunos = @json($temAlunos ?? false);

        // Inicializar tooltips (só há botões na tabela quando há alunos)
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // DataTables exige uma célula por coluna — sem linha "colspan" no tbody
        if (temAlunos) {
            if ($.fn.DataTable.isDataTable('#alunosTable')) {
                $('#alunosTable').DataTable().destroy();
            }

            $('#alunosTable').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json'
                },
                order: [[1, 'asc']],
                pageLength: 10,
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'Todos']],
                columnDefs: [{ orderable: false, targets: 6 }],
            });
        }

        // Modal de exclusão
        $(document).on('click', '.btn-delete', function() {
            const id = $(this).data('id');
            const name = $(this).data('name');

            $('#deleteName').text(name);
            $('#deleteForm').attr('action', `/alunos/${id}`);

            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            modal.show();
        });

        // Atualizar contagem após exclusão
        $(document).on('click', '#deleteForm button[type="submit"]', function() {
            // Aguardar resposta e atualizar
            setTimeout(function() {
                location.reload();
            }, 500);
        });
    });
</script>
@endpush