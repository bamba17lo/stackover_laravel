<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    protected $fillable = ['libelle'];
    use HasFactory;

    public function questions(){
        return $this->hasMany(Question::class);
    }
}
