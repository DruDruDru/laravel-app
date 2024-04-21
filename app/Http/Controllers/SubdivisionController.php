<?php

namespace App\Http\Controllers;

use App\Models\Position;
use App\Models\Subdivision;
use http\Env\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class SubdivisionController extends Controller
{
    public function list()
    {
        return Subdivision::with("positions")->get();
    }

    public function create(Request $request)
    {
        $validated = Validator::make($request->all(), [
            "subdivision_code" => "required|int|unique:subdivisions",
            "name" => "required|string|max:100|unique:subdivisions",
            "description" => "string",
            "positions" => "array",
            "positions.*" => "in:" . implode(',', Position::pluck("id")->toArray())
        ]);

        if ($validated->fails()) {
            return response()->json(
                ["error" => [
                    "code" => 422,
                    "message" => "Validate error",
                    "errors" => $validated->errors()
                ]], 422
            );
        }

        $subdivision = Subdivision::create([
            "subdivision_code" => $validated->getData()["subdivision_code"],
            "name" => $validated->getData()["name"],
            "description" => $validated->getData()["description"]
        ]);

        $subdivision->positions()
            ->attach($validated->getData()["positions"] ?? []);

        return response()->json([
            "data" => ["message" => "Subdivision is added"]
        ], 201);
    }

    public function destroy(Request $request)
    {
        if (Subdivision::destroy($request->route("subdivision_code"))) {
            return response()->json(
                ["data" => ["message" => "Subdivision is removed"]],
            );
        }

        return response()->json(
            ["error" => [
                "code" => 404,
                "message" => "Not found"
            ]], 404
        );
    }

    public function update(Request $request, $subdivision_code)
    {
        try {
            $subdivision = Subdivision::where("subdivision_code", $subdivision_code)
                ->firstOrFail();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException) {
            return response()->json([
                "error" => [
                    "code" => 404,
                    "message" => "Not found"
                ]
            ], 404);
        }

        $validated = Validator::make($request->all(), [
            "subdivision_code" => "required|int|unique:subdivisions,subdivision_code,".$subdivision_code.",subdivision_code",
            "name" => "required|string|max:100|unique:subdivisions,name,".$subdivision_code.",subdivision_code",
            "description" => "string",
            "positions" => "array",
            "positions.*" => "in:" . implode(',', Position::pluck("id")->toArray())
        ]);

        if ($validated->fails()) {
            return response()->json(
                ["error" => [
                    "code" => 422,
                    "message" => "Validation error",
                    "errors" => $validated->errors()
                ]],
                422);
        }

        $subdivision->update([
            "subdivision_code" => $validated->getData()["subdivision_code"],
            "name" => $validated->getData()["name"],
            "description" => $validated->getData()["description"]
        ]);

        $subdivision->positions()
            ->detach(Position::pluck("id")->toArray() ?? []);
        $subdivision->positions()
            ->attach($validated->getData()["positions"] ?? []);

        return response()->json(["data" => ["message" => "Subdivision data is updated"]] );
    }
}
