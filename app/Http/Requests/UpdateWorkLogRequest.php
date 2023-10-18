<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWorkLogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'date' => ['required', 'date', 'string'],
            'developer_id' => ['required'],
            'project_id' => ['required'],
            'rate' => ['nullable'],
            'hrs' => ['nullable', 'between:1, 24'],
            'status' => ['nullable'],
            'total' => ['nullable'],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'date' => $this->date,
            'developer_id' => $this->developerId,
            'project_id' => $this->projectId,
            'rate' => $this->rate,
            'hrs' => $this->hrs,
            'status' => $this->status,
            'total' => $this->total,
        ]);
    }
}
