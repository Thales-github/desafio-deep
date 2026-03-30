@extends('layouts.app')

@section('title', 'Detalhes do Professor')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bi bi-person-vcard text-info"></i> Detalhes do Professor
                </h5>
                <div>
                    <a href="{{ route('professores.edit', $professor['id']) }}" class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil"></i> Editar
                    </a>
                    <a href="{{ route('professores.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left"></i> Voltar
                    </a>
                </div>
            </div>

            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="bg-light p-4 rounded">
                            <h3 class="mb-2">{{ $professor['nome'] ?? '-' }}</h3>
                            <p class="mb-1"><i class="bi bi-envelope me-2"></i>{{ $professor['email'] ?? '-' }}</p>
                            <p class="mb-1"><i class="bi bi-telephone me-2"></i>{{ $professor['telefone'] ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-header bg-white border-0">
                                <h6 class="text-primary mb-0">Dados Pessoais</h6>
                            </div>
                            <div class="card-body pt-0">
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <td width="40%" class="text-muted">CPF:</td>
                                        <td><strong>{{ $professor['documento_unico'] ?? '-' }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Data Nascimento:</td>
                                        <td>
                                            <strong>
                                                @if(!empty($professor['data_nascimento']))
                                                {{ \Carbon\Carbon::parse($professor['data_nascimento'])->format('d/m/Y') }}
                                                @else
                                                -
                                                @endif
                                            </strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Status:</td>
                                        <td>
                                            @if(($professor['ativo'] ?? 0) == 1)
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

                    <div class="col-md-6 mb-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-header bg-white border-0">
                                <h6 class="text-primary mb-0">Formação</h6>
                            </div>
                            <div class="card-body pt-0">
                                @php
                                $formacao = [
                                0 => 'Graduação',
                                1 => 'Pós-graduação',
                                2 => 'Mestrado',
                                3 => 'Doutorado'
                                ];
                                @endphp
                                <p class="mb-0">
                                    <strong>{{ $formacao[$professor['nivel_formacao'] ?? 0] ?? 'Graduação' }}</strong>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
