<?php

namespace Tests\Unit\Controllers;

use App\Models\User;
use App\Models\Schedule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ScheduleControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testa a criação de um novo agendamento.
     *
     * @return void
     */
    public function testStore()
    {
        $user = User::factory()->create();
        $token = $user->createToken('auth-token')->plainTextToken;

        $response = $this->post('/api/schedules', [
            'title' => 'Test Schedule',
            'start_date' => '2024-03-19',
            'due_date' => '2024-03-21',
            'status' => 'aberto',
        ], [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(302);
    }

    /**
     * Testa a atualização de um agendamento existente.
     *
     * @return void
     */
    public function testUpdate()
    {
        $user = User::factory()->create();
        $schedule = Schedule::factory()->create(['user_id' => $user->id]);
        $token = $user->createToken('auth-token')->plainTextToken;

        $response = $this->put('/api/schedules/' . $schedule->id, [
            'title' => 'Updated Schedule',
        ], [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(302);
    }

    /**
     * Testa a exibição de um agendamento específico.
     *
     * @return void
     */
    // public function testShow()
    // {
    //     $user = User::factory()->create();
    //     $schedule = Schedule::factory()->create(['user_id' => $user->id]);
    //     $token = $user->createToken('auth-token')->plainTextToken;

    //     $response = $this->withHeaders([
    //         'Authorization' => 'Bearer ' . $token,
    //     ])->get('/api/schedules/' . $schedule->id);

    //     $response->assertStatus(200)
    //         ->assertJson([
    //             'id' => $schedule->id,
    //             'title' => $schedule->title,
    //             'start_date' => $schedule->start_date->format('Y-m-d H:i:s'),
    //             'due_date' => $schedule->due_date->format('Y-m-d H:i:s'),
    //             'status' => $schedule->status,
    //             'user_id' => $schedule->user_id,
    //             'created_at' => $schedule->created_at->toISOString(),
    //             'updated_at' => $schedule->updated_at->toISOString(),
    //         ]);
    // }
}
