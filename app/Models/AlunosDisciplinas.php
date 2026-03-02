<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AlunosDisciplinas extends Model
{
    use HasFactory;

    protected $table = 'alunos_disciplinas';

    /**
     * Indica se os IDs são auto-incremento
     */
    public $incrementing = true;

    protected $fillable = [
        'aluno_id',
        'disciplina_id',
        'data_matricula',
        'status',
        'nota_final',
        'faltas'
    ];

    /**
     * Casts para tipos corretos
     */
    protected $casts = [
        'data_matricula' => 'date',
        'nota_final' => 'decimal:2',
        'faltas' => 'integer',
        'status' => 'integer'
    ];

    /**
     * Constantes para os status
     */
    const STATUS_CURSANDO = 1;
    const STATUS_APROVADO = 2;
    const STATUS_REPROVADO = 3;
    const STATUS_TRANCADO = 4;

    /**
     * Array com todos os status (para validação)
     */
    const STATUS_VALIDOS = [
        self::STATUS_CURSANDO,
        self::STATUS_APROVADO,
        self::STATUS_REPROVADO,
        self::STATUS_TRANCADO
    ];

    /**
     * ========================================================
     * RELACIONAMENTOS
     * ========================================================
     */

    /**
     * Relacionamento com Alunos
     */
    public function aluno(): BelongsTo
    {
        return $this->belongsTo(Alunos::class, 'aluno_id');
    }

    /**
     * Relacionamento com Disciplinas
     */
    public function disciplina(): BelongsTo
    {
        return $this->belongsTo(Disciplinas::class, 'disciplina_id');
    }

    /**
     * ========================================================
     * MÉTODOS DE CONSULTA
     * ========================================================
     */

    /**
     * Listar todas as matrículas com filtros opcionais
     */
    public function listar(array $filtros = [])
    {
        try {
            $query = $this->with(['aluno', 'disciplina']);


            // Filtro por aluno
            if (!empty($filtros['aluno_id'])) {
                $query->where('aluno_id', $filtros['aluno_id']);
            }

            // Filtro por disciplina
            if (!empty($filtros['disciplina_id'])) {
                $query->where('disciplina_id', $filtros['disciplina_id']);
            }

            // Filtro por status
            if (isset($filtros['status']) && $filtros['status'] !== '') {
                $query->where('status', $filtros['status']);
            }

            // Filtro por período de matrícula
            if (!empty($filtros['data_inicio'])) {
                $query->whereDate('data_matricula', '>=', $filtros['data_inicio']);
            }

            if (!empty($filtros['data_fim'])) {
                $query->whereDate('data_matricula', '<=', $filtros['data_fim']);
            }

            // Ordenação
            $ordenacao = $filtros['ordenacao'] ?? 'created_at';
            $direcao = $filtros['direcao'] ?? 'desc';
            $query->orderBy($ordenacao, $direcao);


            // Paginação (se solicitado)
            if (!empty($filtros['por_pagina'])) {
                return $query->paginate($filtros['por_pagina']);
            }

            $resultados = $query->get();



            return $resultados;
        } catch (\Exception $e) {

            throw $e; // Relança para ser capturado no controller
        }
    }
    /**
     * Detalhar uma matrícula específica
     */
    public function detalhar(int $id): ?self
    {
        return $this->with(['aluno', 'disciplina'])->findOrFail($id);
    }

    /**
     * Cadastrar nova matrícula
     */
    public function cadastrar(array $dados): self
    {
        return $this->create($dados);
    }

    /**
     * Atualizar matrícula existente
     */
    public function atualizar(array $dados): bool
    {
        return $this->update($dados);
    }

    /**
     * Apagar matrícula
     */
    public function apagar(int $id): bool
    {
        $matricula = $this->findOrFail($id);
        return $matricula->delete();
    }

    /**
     * Buscar matrícula por aluno e disciplina
     */
    public function buscarPorAlunoEDisciplina(int $alunoId, int $disciplinaId): ?self
    {
        return $this->where('aluno_id', $alunoId)
            ->where('disciplina_id', $disciplinaId)
            ->first();
    }

    /**
     * ========================================================
     * ACCESSORS E MUTATORS
     * ========================================================
     */

    public function getStatusDescricaoAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_CURSANDO => 'Cursando',
            self::STATUS_APROVADO => 'Aprovado',
            self::STATUS_REPROVADO => 'Reprovado',
            self::STATUS_TRANCADO => 'Trancado',
            default => 'Desconhecido'
        };
    }

    public function setNotaFinalAttribute($value): void
    {
        $this->attributes['nota_final'] = $value ? floatval($value) : null;
    }

    public function setFaltasAttribute($value): void
    {
        $this->attributes['faltas'] = $value ? intval($value) : 0;
    }
}
