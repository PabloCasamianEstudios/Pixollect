<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameMode extends Model
{
    public function games()
{
    return $this->belongsToMany(Game::class);
}

}
