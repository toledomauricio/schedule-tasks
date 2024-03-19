<?php

namespace App\Services;

use App\Models\Schedule;
use Carbon\Carbon;

/**
 * Class ScheduleService
 * @package App\Services
 */
class ScheduleService
{
    /**
     * Cria um novo agendamento.
     *
     * @param array $data
     * @return Schedule
     */
    public function createSchedule(array $data)
    {
        $this->validateData($data['user_id'], $data['start_date'], $data['due_date']);

        return Schedule::create($data);
    }

    /**
     * Atualiza um agendamento existente.
     *
     * @param Schedule $schedule
     * @param array $data
     * @return Schedule
     */
    public function updateSchedule(Schedule $schedule, array $data)
    {
        $this->validateData($data['user_id'], $data['start_date'], $data['due_date']);

        $schedule->update($data);

        return $schedule;
    }

    /**
     * Exclui um agendamento.
     *
     * @param Schedule $schedule
     * @return void
     */
    public function deleteSchedule(Schedule $schedule)
    {
        $schedule->delete();
    }

    /**
     * Obtém todos os agendamentos.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAllSchedules()
    {
        return Schedule::all();
    }

    /**
     * Filtra os agendamentos por intervalo de datas.
     *
     * @param $startDate
     * @param $endDate
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function filterSchedulesByDateRange($startDate, $endDate)
    {
        return Schedule::filterByDateRange($startDate, $endDate)->get();
    }

    /**
     * Valida os dados do agendamento.
     *
     * @param $userId
     * @param $startDate
     * @param $dueDate
     */
    protected function validateData($userId, $startDate, $dueDate)
    {
        $this->validateDate($startDate, $dueDate);
        $this->validateOverlap($userId, $startDate, $dueDate);
    }

    /**
     * Valida as datas do agendamento.
     *
     * @param $startDate
     * @param $dueDate
     */
    protected function validateDate($startDate, $dueDate)
    {
        $startDate = Carbon::parse($startDate);
        $dueDate = Carbon::parse($dueDate);

        if ($startDate->isWeekend() || $dueDate->isWeekend()) {
            throw new \InvalidArgumentException('As datas não podem ocorrer nos finais de semana.');
        }
    }

    /**
     * Valida sobreposições de datas do agendamento.
     *
     * @param $userId
     * @param $startDate
     * @param $dueDate
     */
    protected function validateOverlap($userId, $startDate, $dueDate)
    {
        $overlap = Schedule::hasOverlap($userId, $startDate, $dueDate)->exists();

        if ($overlap) {
            throw new \InvalidArgumentException('Não é permitido cadastros que se sobreponham a outras datas de atividades para o mesmo usuário.');
        }
    }
}
