<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleRequest extends FormRequest
{
    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'start_date' => $this->formatDate($this->start_date),
            'due_date' => $this->formatDate($this->due_date),
        ]);
    }

    /**
     * Format the date.
     *
     * @param string|null $date
     * @return string|null
     */
    protected function formatDate($date)
    {
        if ($date) {
            $parts = explode('/', $date);
            if (count($parts) === 3) {
                return $parts[2] . '-' . $parts[1] . '-' . $parts[0]; // Formato para o banco de dados (ano-mês-dia)
            }
        }
        return $date;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:start_date',
            'user_id' => 'required|exists:users,id',
            'status' => 'required|in:open,completed',
            'completion_date' => 'nullable|date|after_or_equal:start_date',
        ];
    }
}
