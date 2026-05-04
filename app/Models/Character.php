<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    protected $fillable = ['name', 'picture', 'description'];

    public function movies()
    {
        return $this->belongsToMany(Movie::class);
    }
}