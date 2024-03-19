<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Schedule
 * @package App\Models
 */
class Schedule extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title', 'description', 'start_date', 'due_date', 'user_id', 'status', 'completion_date'
    ];

    /**
     * Obtém o usuário associado ao agendamento.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Filtra os agendamentos por intervalo de datas.
     *
     * @param $startDate
     * @param $endDate
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function filterByDateRange($startDate, $endDate)
    {
        return self::whereBetween('start_date', [$startDate, $endDate])
            ->orWhereBetween('due_date', [$startDate, $endDate]);
    }

    /**
     * Verifica se há sobreposição de datas para um determinado usuário.
     *
     * @param $userId
     * @param $startDate
     * @param $dueDate
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function hasOverlap($userId, $startDate, $dueDate)
    {
        return self::where('user_id', $userId)
            ->where(function ($query) use ($startDate, $dueDate) {
                $query->whereBetween('start_date', [$startDate, $dueDate])
                    ->orWhereBetween('due_date', [$startDate, $dueDate]);
            });
    }

    /**
     * Obtém todos os agendamentos.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getAll()
    {
        return self::all();
    }
}
