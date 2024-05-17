<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class   PositionController extends Controller
{
    public function list(Request $request)
    {
        if ($request->has("page")) {
            return Position::simplePaginate(5);
        } else {
            return Position::all();
        }
    }

    public function create(Request $request)
    {
        $validated = Validator::make($request->all(), [
            "name" => "required|string|max:100|unique:positions",
            "description" => "string",
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

        Position::create($validated->getData());

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

        return response()->json(["data" => ["message" => "Position data is updated"]]);
    }
}
