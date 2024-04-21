<?php

namespace App\Http\Controllers;

use App\Models\Position;
use App\Models\Subdivision;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PositionController extends Controller
{
    public function list()
    {
        return Position::with("subdivisions")->get();
    }

    public function create(Request $request)
    {
        $validated = Validator::make($request->all(), [
            "name" => "required|string|max:100|unique:positions",
            "description" => "string",
            "subdivisions" => "array",
            "subdivisions.*" => "in:" . implode(',', Subdivision::pluck("subdivision_code")->toArray())
        ]);

        if ($validated->fails()) {
            return response()->json(
                ["error" => [
                    "code" => 422,
                    "message" => "Validation error",
                    "errors" => $validated->errors()
                ]],
                422
            );
        }
        $position = Position::create([
            "name" => $validated->getData()["name"],
            "description" => $validated->getData()["description"]
        ]);
        $position->subdivisions()
            ->attach($validated->getData()["subdivisions"] ?? []);

        return response()->json(
            ["data" => ["message" => "Position is added"]],
            201
        );
    }

    public function destroy(Request $request)
    {
        if (Position::destroy($request->route("position_id"))) {
            return response()->json(
                ["data" => ["message" => "Position is removed"]],
            );
        }

        return response()->json(
            ["error" => [
                "code" => 404,
                "message" => "Not found"
            ]], 404
        );
    }

    public function update(Request $request)
    {
        $position_id = $request->route("position_id");

        try {
            $position = Position::findOrFail($position_id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException) {
            return response()->json([
                "error" => [
                    "code" => 404,
                    "message" => "Not found"
                ]
            ], 404);
        }

        $validated = Validator::make($request->all(), [
            "name" => "required|string|max:100|unique:positions,name,".$position_id,
            "description" => "string",
            "subdivisions" => "array",
            "subdivisions.*" => "in:" . implode(',', Subdivision::pluck("subdivision_code")->toArray())
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

        $position->update($validated->getData());

        $position->subdivisions()
            ->detach(Subdivision::pluck("subdivision_code")->toArray() ?? []);
        $position->subdivisions()
            ->attach($validated->getData()["subdivisions"] ?? []);

        return response()->json(["data" => ["message" => "Position data is updated"]]);
    }
}
