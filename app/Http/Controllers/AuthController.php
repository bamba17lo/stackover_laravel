<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Notifications\Notif;
use Exception;
use Laravel\Sanctum\NewAccessToken;

class AuthController extends Controller
{

    public function register(RegisterRequest $request)
    {
        try {
            $data = $request->validated();

            $data['nbre_reponse'] = 0;
            // Hash du mot de passe
            $data['password'] = bcrypt($data['password']);
    
            // Enregistrement de l'utilisateur
            $user = User::create($data);
    
            // Authentification automatique après l'inscription
            auth()->login($user);

    
            $user=auth()->user();
            $token= $user->createToken('token_name',['*'],now()->addMinutes(60))->plainTextToken;

       return response()->json([
        //retourner le token avec l'heure d'expiration
        'token'=>$token,
        'expireAt'=> now()->addMinutes(60)->format('Y-m-d H:i:s'),

       

    ], 200);

        }catch(Exception $e){
            return response()->json([
                "status"=> $e->getcode(),
                "message"=> $e->getMessage()
                
            ]);

        }
        
    }

    public function login(LoginRequest $request)
{
    try{
        // accéder aux données validées via la méthode validated() de l'objet $request
    //validated() retourne un tableau des données validées
    $users = $request->validated();
    //dd($users);

    //est utilisée dans Laravel pour tenter d'authentifier un utilisateur avec les informations d'identification fournies
    if (Auth::attempt($users)) {
        //$request->session()->regenerate();
        //return redirect()->route('listerET');
       // return redirect()->intended('/dashboard');

       $user=auth()->user();
       $token=$user->createToken('token_name',['*'],now()->addMinutes(60))->plainTextToken;

       return response()->json([
        //retourner le token avec l'heure d'expiration
        'token'=>$token,
        'expireAt'=> now()->addMinutes(60)->format('Y-m-d H:i:s'),

        //"status"=> 200,
        //"message"=> "Vous etes actuellement connecter",
        //"student"=>$user,
       // "token"=>$token

    ], 200);
    }

    return response()->json([
        'status'=> 'Unauthorized'],
       // "status"=> 403,
        //"message"=> "information non valide",
    401);
    // La tentative de connexion a échoué
//return back()->withErrors(['email' => 'Les informations d\'identification sont incorrectes']);

    }catch(Exception $e){
        

    }
    
}


public function logout(Request $request)
{


    if ($request->user()) {
    $request->user()->currentAccessToken()->delete();
    return response()->json(['message'=>'logged out'], 200);
    }
    return response()->json(['message' => 'No user authenticated'], 401);
}

public function refresh(Request $request)
{
    if (Auth::check()) {
    $user=Auth::user();
   
       $token=$user->createToken('token_name',['*'],now()->addMinutes(60))->plainTextToken;

       return response()->json([
        //retourner le token avec l'heure d'expiration
        'token'=>$token,
        'expireAt'=> now()->addMinutes(60)->format('Y-m-d H:i:s'),

    ]);
}
    // Si l'utilisateur n'est pas authentifié, retourner une erreur
    return response()->json(['error' => 'Unauthorized'], 401);
}



}
