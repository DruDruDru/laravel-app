<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'patronymic' => $this->patronymic,
            'birth_date' => $this->birth_date,
            'gender' => $this->gender,
            'login' => $this->login,
            'hire_date' => $this->hire_date,
            'termination_date' => $this->termination_date,
            'salary' => (float) $this->salary,
            'positions' => $this->positions
        ];
    }
}
