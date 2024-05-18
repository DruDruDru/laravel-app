<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function signup(Request $request)
    {
        $validated = Validator::make($request->all(), [
            "login" => "required|string|max:255|unique:users",
            "password" => "required|max:255"
        ]);

        if ($validated->fails()) {
            return response()->json(
                ["error" => [
                    "code" => 422,
                    "message" => "Validation error",
                    "errors" => $validated->errors()
                ]],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $userData = $validated->getData();

        User::create([
            "login" => $userData["login"],
            "password" => bcrypt($userData["password"]),
            "role" => "moderator"
        ]);

        return response()->json(
            ["data" => ["message" => "User is registered"]],
            Response::HTTP_CREATED
        );
    }
}
