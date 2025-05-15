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
        $data = $request->validate(
            [
                'email' => 'required|email',
                'role' => 'required|in:student,teacher,admin',
                'max_uses' => 'nullable|integer|min:1',
            ],
            [
                'email.required' => 'Email je povinný',
                'email.email' => 'Email není platný',
                'role.required' => 'Role je povinná',
                'role.in' => 'Role musí být student, učitel nebo admin',
                'max_uses.integer' => 'Maximální počet použití musí být celé číslo',
                'max_uses.min' => 'Maximální počet použití musí být alespoň 1',
            ]
        );


        $token = Str::random(64);

        $invite = new RegistrationToken(
            [
                'email' => $data['email'],
                'token' => $token,
                'expires_at' => now()->addDay(),
                'role' => $data['role'],
                'max_uses' => $data['max_uses'] ?? null,
            ]
        );

        $invite->save();


        $link = config('app.frontend_url')
            . "/register?token={$invite->token}";


        return response()->json(
            [
                'message' => 'Pozvánka byla úspěšně odeslána',
                'link' => $link,
            ],
            200
        );
    }

    public function validateToken(Request $request)
    {
        $data = $request->validate(
            [
                'token' => 'required|string',
            ],
            [
                'token.required' => 'Token je povinný',
                'token.string' => 'Token musí být řetězec',
            ]
        );

        return response()->json([
            'message' => 'Token je platný',
            'valid' => true,
        ]);

//        $inv = RegistrationToken::where('token', $request->token)->first();
//
//        if (!$inv || !$inv->canUse()) {
//            return response()->json([
//                'valid' => false,
//                'message' => 'Link invalid, expired, or max uses reached.'
//            ], 404);
//        }
//
//        return response()->json([
//            'valid' => true,
//            'email' => $inv->email,
//            'role' => $inv->role,
//            'remaining' => $inv->remainingUses(),
//        ]);
    }

}
