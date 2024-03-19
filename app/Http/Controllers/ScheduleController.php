<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScheduleRequest;
use App\Models\Schedule;
use App\Services\ScheduleService;
use Illuminate\Http\Request;

/**
 * Class ScheduleController
 * @package App\Http\Controllers
 */
class ScheduleController extends Controller
{
    protected $scheduleService;

    /**
     * ScheduleController constructor.
     * @param ScheduleService $scheduleService
     */
    public function __construct(ScheduleService $scheduleService)
    {
        $this->scheduleService = $scheduleService;
    }

    /**
     * Retorna todos os agendamentos.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $schedules = $this->scheduleService->getAllSchedules();
        return response()->json($schedules);
    }

    /**
     * Cria um novo agendamento.
     *
     * @param ScheduleRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ScheduleRequest $request)
    {
        $schedule = $this->scheduleService->createSchedule($request->validated());
        return response()->json($schedule, 201);
    }

    /**
     * Exibe o agendamento especificado.
     *
     * @param Schedule $schedule
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Schedule $schedule)
    {
        return response()->json($schedule);
    }

    /**
     * Atualiza o agendamento especificado.
     *
     * @param ScheduleRequest $request
     * @param Schedule $schedule
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ScheduleRequest $request, Schedule $schedule)
    {
        $schedule = $this->scheduleService->updateSchedule($schedule, $request->validated());
        return response()->json($schedule);
    }

    /**
     * Remove o agendamento especificado.
     *
     * @param Schedule $schedule
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Schedule $schedule)
    {
        $this->scheduleService->deleteSchedule($schedule);
        return response()->json(null, 204);
    }


    public function filterByDateRange(Request $request)
{
    $request->validate([
        'start_date' => 'required|date_format:Y-m-d',
        'end_date' => 'required|date_format:Y-m-d',
    ]);

    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');


    $schedules = $this->scheduleService->filterSchedulesByDateRange($startDate, $endDate);
    
    if ($schedules->isEmpty()) {
        return response()->json(['message' => 'No schedules found for the specified date range.']);
    }

    return response()->json($schedules);
}
}
