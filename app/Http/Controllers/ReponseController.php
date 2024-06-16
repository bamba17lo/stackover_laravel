<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reponse;
use App\Models\Question;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ReponseController extends Controller
{
    // Répondre à une Question
    public function repondreQuestion(Request $request, $question_id)
    {
        $request->validate([
            'contenu' => 'required|string',
        ]);

        $reponse = Reponse::create([
            'contenu' => $request->contenu,
            'user_id' => Auth::id(),
            'question_id' => $question_id,
        ]);

        return response()->json(['message' => 'Réponse ajoutée avec succès', 'reponse' => $reponse], 201);
    }

    // Valider une Réponse
     public function validerReponse($reponse_id)
     {
         $reponse = Reponse::findOrFail($reponse_id);
 
         //verifier si c'est pas un superviseur
         if (!Auth::user()->isSupervisor()) {
             return response()->json(['error' => 'Unauthorized'], 403);
         }
 
         $reponse->validation = true;
         $reponse->save();

         // Incrémenter le nombre de réponses validées de l'utilisateur
        $user = User::findOrFail($reponse->user_id);
        $user->nbre_reponse += 1;

        // Promouvoir l'utilisateur en superviseur s'il a atteint 10 réponses validées
        if ($user->nbre_reponse >= 10 && $user->role !== 'superviseur') {
            $user->role = 'superviseur';
        }

        $user->save();
 
         return response()->json(['message' => 'Réponse validée avec succès', 'reponse' => $reponse], 200);
     }

    // Lister les Réponses d'une Question
    public function listerReponses($question_id)
    {
         // Récupérer toutes les réponses qui correspondent à l'ID de la question
        $reponses = Reponse::where('question_id', $question_id)->get();

        // Retourner les réponses sous forme de réponse JSON
        return response()->json(['reponses' => $reponses], 200);
    }
}

