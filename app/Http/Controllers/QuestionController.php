<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::all();
        return response()->json($questions);
    }

    //consulter une question spécifique de la base de données, identifiée par son ID, avec les informations associées des utilisateurs, des thèmes et des réponses.
    public function show($id)
    {
        try{
            $question = Question::with('user', 'theme', 'reponses')->findOrFail($id);
            return response()->json($question);

        }catch(\Exception $e){
            return response()->json([
                "status"=> $e->getcode(),
                "message"=> $e->getMessage()
            ]);
        }
    }

    public function store(Request $request)
    {
        try{
            $request->validate([
                'contenu' => 'required|string',
                'theme_id' => 'required|exists:themes,id',
            ]);
            $question = Question::create([
                'contenu' => $request->contenu,
                'user_id' => Auth::id(),
                'theme_id' => $request->theme_id,
            ]);
    
            return response()->json(['message' => 'Question posée avec succès', 'question' => $question], 201);

        }catch(\Exception $e){
            return response()->json([
                "status"=> $e->getcode(),
                "message"=> $e->getMessage()
                
            ]);
        }
        
    }

    public function destroy($id)
    {
        try {
            $question = Question::findOrFail($id);
            $question->delete();

            return response()->json(['message' => 'Question supprimée avec succès'], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => $e->getcode(),
                "message" => $e->getMessage()
            ]);
        }
    }

    // Méthode pour mettre à jour une question existante
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'contenu' => 'required|string',
                'theme_id' => 'required|exists:themes,id',
            ]);

            $question = Question::findOrFail($id);

            $question->update([
                'contenu' => $request->contenu,
                'theme_id' => $request->theme_id,
                
                
            ]);

            return response()->json(['message' => 'Question mise à jour avec succès', 'question' => $question], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => $e->getCode(),
                "message" => $e->getMessage()
            ], 400);
        }
    }

    public function edit(string $id)
    {
        try {
        $question=Question::find($id);
        return response()->json($question);
    }catch(\Exception $e){
        return response()->json([
            "status"=> $e->getcode(),
            "message"=> $e->getMessage()
            
        ]);
        }
    }
}
