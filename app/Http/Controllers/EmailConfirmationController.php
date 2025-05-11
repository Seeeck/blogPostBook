<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class EmailConfirmationController extends Controller
{
    //

    

    public function verify(Request $request, $id, $hash)
    {
        $user = User::findOrFail($id);
      
        if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            return "link de verificación inválido";
        }

        if ($user->hasVerifiedEmail()) {
            return "El email ya ha sido verificado";
        }

        $user->markEmailAsVerified();
        return "Email verificado exitosamente";
    }

    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email ya verificado'], 400);
        }

        $request->user()->sendEmailVerificationNotification();
        return response()->json(['message' => 'Email de verificación reenviado']);
    }
}
