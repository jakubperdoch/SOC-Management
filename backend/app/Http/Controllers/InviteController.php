<?php

namespace App\Http\Controllers;

use App\Models\RegistrationToken;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class InviteController extends Controller
{
    public function sendInvite(Request $request)
    {

        $data = Validator::make($request->all(), [
            'email' => 'required|email',
            'role' => 'required|in:student,teacher,admin',
            'max_uses' => 'nullable|integer|min:1',
        ], [
            'email.required' => 'Email je povinný',
            'email.email' => 'Email není platný',
            'role.required' => 'Role je povinná',
            'role.in' => 'Role musí být student, učiteľ nebo admin',
            'max_uses.integer' => 'Maximálný počet použití musí být celé číslo',
            'max_uses.min' => 'Maximálný počet použití musí být väčší ako 0',
        ]);

        if ($data->fails()) {
            return response()->json(
                [
                    'message' => 'Chyba pri validácii dat',
                    'errors' => $data->errors(),
                ],
                422
            );
        }


        $token = Str::random(64);

        $invite = new RegistrationToken(
            [
                'email' => $request->email,
                'token' => $token,
                'expires_at' => now()->addDay(),
                'role' => $request->role,
                'max_uses' => $request->max_uses ?? null,
            ]
        );

        $invite->save();


        $link = config('app.frontend_url')
            . "/register?token={$invite->token}";


        return response()->json(
            [
                'message' => 'Pozvánka bola úspešne odoslaná',
                'link' => $link,
            ],
            200
        );
    }

    public function validateToken(Request $request)
    {

        $data = Validator::make($request->all(), [
            'token' => 'required|string',
        ], [
            'token.required' => 'Token je povinný',
            'token.string' => 'Token musí být reťazec',
        ]);

        if ($data->fails()) {
            return response()->json(
                [
                    'message' => 'Chyba pri validácii dat',
                    'errors' => $data->errors(),
                ],
                422
            );
        }

        $inv = RegistrationToken::where('token', $request->token)->first();

        if (!$inv) {
            return response()->json([
                'valid' => false,
                'message' => 'Link neexistuje',
            ], 404);
        }

        if ($inv->expires_at < now()) {
            return response()->json([
                'valid' => false,
                'message' => 'Link vypršal',
            ], 410);
        }

        return response()->json([
            'valid' => true,
            'email' => $inv->email,
            'role' => $inv->role,
            'remaining' => $inv->remainingUses(),
        ]);
    }

}
