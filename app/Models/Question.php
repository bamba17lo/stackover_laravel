<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['contenu','user_id','theme_id'];
    use HasFactory;

    public function theme(){
        return $this->belongsTo(Theme::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function reponses(){
        return $this->hasMany(Reponse::class);
    }

}
