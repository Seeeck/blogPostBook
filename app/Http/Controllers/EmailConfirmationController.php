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
            return response()->json(['message' => 'link de verificación inválido'], 400);
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'EEl email ya ha sido verificado']);
        }

        $user->markEmailAsVerified();
        return response()->json(['message' => 'Email verificado exitosamente']);
    }

    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email already verified.'], 400);
        }

        $request->user()->sendEmailVerificationNotification();
        return response()->json(['message' => 'Verification email resent']);
    }
}
