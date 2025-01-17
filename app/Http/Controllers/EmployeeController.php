<?php

namespace App\Http\Controllers;

use App\Http\Filters\EmployeeFilter;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;

class EmployeeController extends Controller
{
    public function list(Request $request)
    {
        $employees = Employee::with("positions");
        if ($request->has("page")) {
            return EmployeeResource::collection($employees->simplePaginate(10));
        } else {
            return EmployeeResource::collection($employees->get());
        }
    }

    public function create(Request $request)
    {
        $validated = Validator::make($request->all(), [
            "firstname" => "required|string|max:100",
            "lastname" => "required|string|max:100",
            "patronymic" => "string|max:100",
            "birth_date" => "required|date",
            "gender" => "required|string|in:female,male",
            "login" => "required|string|max:100|unique:employees",
            "hire_date" => "required|date",
            "termination_date" => "date",
            "salary" => "decimal:2",
            "positions" => "array",
            "positions.*" => "in:". implode(',', Position::pluck("id")->toArray())
        ]);

        if ($validated->fails()) {
            return response()->json(
                ["error" => [
                    "code" => 422,
                    "message" => "Validation error",
                    "errors" => $validated->errors()
                ]],
                Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $employee = Employee::create($validated->getData());
        $employee->positions()
            ->attach($validated->getData()["positions"] ?? []);

        return response()->json(
            ["data" => ["message" => "Employee is added"]],
            Response::HTTP_CREATED
        );
    }

    public function destroy(Request $request)
    {
        if (Employee::destroy($request->route("employee_id"))) {
            return response()->json(
                ["data" => ["message" => "Employee is removed"]],
                Response::HTTP_OK);
        }
        return response()->json(
            ["error" => [
                "code" => 404,
                "message" => "Not found"
            ]], Response::HTTP_NOT_FOUND
        );
    }

    public function update(Request $request)
    {
        $employee_id = $request->route("employee_id");

        try {
            $employee = Employee::findOrFail($employee_id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException) {
            return response()->json(
                ["error" => [
                    "code" => 404,
                    "message" => "Not found"
                ]], Response::HTTP_NOT_FOUND
            );
        }

        $validated = Validator::make($request->all(), [
            "firstname" => "required|string|max:100",
            "lastname" => "required|string|max:100",
            "patronymic" => "string|max:100",
            "birth_date" => "required|date",
            "gender" => "required|string|in:female,male",
            "login" => "required|string|max:100|unique:employees,login,".$employee_id,
            "hire_date" => "required|date",
            "termination_date" => "date",
            "salary" => "decimal:2",
            "positions" => "array",
            "positions.*" => "in:". implode(',', Position::pluck("id")->toArray())
        ]);

        if ($validated->fails()) {
            return response()->json(
                ["error" => [
                    "code" => 422,
                    "message" => "Validation error",
                    "errors" => $validated->errors()
                ]],
                Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $employee->update($validated->getData());
        $employee->positions()
            ->detach(Position::pluck("id")->toArray() ?? []);
        $employee->positions()
            ->attach($validated->getData()["positions"] ?? []);

        return response()->json(["data" => ["message" => "Employee data is updated"]]);
    }

    public function search(Request $request)
    {
        $query = $request->query('q');

        $employees = Employee::with('positions');

        $employees = $employees->where('id', 'like', '%' . $query . '%')
                            ->orWhere('firstname', 'like', '%' . $query . '%')
                            ->orWhere('lastname', 'like', '%' . $query . '%')
                            ->orWhere('patronymic', 'like', '%' . $query . '%')
                            ->orWhere('login', 'like', '%' . $query . '%');

        if ($request->has("page")) {
            return EmployeeResource::collection($employees->simplePaginate(10));
        } else {
            return EmployeeResource::collection($employees->get());
        }
    }

    public function filter(Request $request)
    {
        $params = $request->all();

        $filter = app()->make(EmployeeFilter::class, ['queryParams' => array_filter($params)]);
        $employees = Employee::with('positions')->filter($filter);


        if ($request->has("page")) {
            return EmployeeResource::collection($employees->simplePaginate(10));
        } else {
            return EmployeeResource::collection($employees->get());
        }
    }
}
