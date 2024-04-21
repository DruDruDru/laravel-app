<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;

class EmployeeController extends Controller
{
    public function list()
    {
        return Employee::with("positions")->get();
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
}
