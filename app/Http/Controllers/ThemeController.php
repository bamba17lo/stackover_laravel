<?php

namespace App\Http\Controllers;

use App\Models\Theme;
use Exception;
use Illuminate\Http\Request;

use function PHPSTORM_META\map;

class ThemeController extends Controller
{
    public function create(Request $request){
        $data = $request->validate([
                'libelle'=>'required|unique:themes,libelle'
            ]);

        try {
            Theme::updateOrCreate(
                ['libelle' => $data['libelle'] ],
                ['libelle' => $data['libelle'] ]
            );
            return response()->json([
                'code'=>200,
                'message'=> 'success'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'code'=>500,
                'message'=> $e->getMessage()
            ]);
        }
    }

    public function delete($id){
        $theme = Theme::find($id);
        try {
            if($theme){
                $theme->delete();
                return response()->json([
                    'code' =>200,
                    'message' => 'deleted success'
                ]);
            }
        } catch (Exception $e){
            return response()->json([
                'code' =>500,
                'message' => $e->getMessage()
            ]);
        }
    }
}
