<?php

namespace App\Http\Filters;

use Carbon\Carbon;
use Carbon\Exceptions\Exception;
use Illuminate\Database\Eloquent\Builder;

class EmployeeFilter extends AbstractFilter
{
    public const GENDER = 'gender';
    public const MAX_SALARY = 'max_salary';
    public const MIN_SALARY = 'min_salary';
    public const MIN_BIRTH_DATE = 'min_birth_date';
    public const MAX_BIRTH_DATE = 'max_birth_date';
    public const MIN_HIRE_DATE = 'min_hire_date';
    public const MAX_HIRE_DATE = 'max_hire_date';
    public const MIN_TERMINATION_DATE = 'min_termination_date';
    public const MAX_TERMINATION_DATE = 'max_termination_date';
    public const POSITION = 'position';


    protected function getCallbacks(): array
    {
        return [
            self::GENDER => [$this, 'gender'],
            self::MAX_SALARY => [$this, 'maxSalary'],
            self::MIN_SALARY => [$this, 'minSalary'],
            self::MIN_BIRTH_DATE => [$this, 'minBirthDate'],
            self::MAX_BIRTH_DATE => [$this, 'maxBirthDate'],
            self::MIN_HIRE_DATE => [$this, 'minHireDate'],
            self::MAX_HIRE_DATE => [$this, 'maxHireDate'],
            self::MIN_TERMINATION_DATE => [$this, 'minTerminationDate'],
            self::MAX_TERMINATION_DATE => [$this, 'maxTerminationDate'],
            self::POSITION => [$this, 'position']
        ];
    }

    public function gender(Builder $builder, $value)
    {
        $builder->where('gender', $value);
    }

    public function maxSalary(Builder $builder, $value)
    {
        $builder->where('salary', '<=', (float)$value);
    }

    public function minSalary(Builder $builder, $value)
    {
        $builder->where('salary', '>=', (float)$value);
    }

    public function maxBirthDate(Builder $builder, $value)
    {
        try {
            $builder->where('birth_date', '<=', Carbon::parse($value));
        } catch (Exception) {}
    }

    public function minBirthDate(Builder $builder, $value)
    {
        $builder->where('birth_date', '>=', $value);
    }

    public function maxHireDate(Builder $builder, $value)
    {
        $builder->where('hire_date', '<=', $value);
    }

    public function minHireDate(Builder $builder, $value)
    {
        $builder->where('hire_date', '>=', $value);
    }

    public function maxTerminationDate(Builder $builder, $value)
    {
        $builder->where('termination_date', '<=', $value);
    }

    public function minTerminationDate(Builder $builder, $value)
    {
        $builder->where('termination_date', '>=', $value);
    }

    public function position(Builder $builder, $value)
    {
        $builder->whereHas('positions', function ($query) use ($value) {
            $query->where('name', $value);
        });
    }
}
