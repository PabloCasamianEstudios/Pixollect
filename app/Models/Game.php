<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{

    protected $fillable = [
        'title',
        'description',
        'release_date',
        'developer',
        'publisher',
        'price',
        'image_url',
        'saga_id',
        'achievements'
    ];

    public function genres()
{
    return $this->belongsToMany(Genre::class);
}

public function platforms()
{
    return $this->belongsToMany(Platform::class);
}

public function gameModes()
{
    return $this->belongsToMany(GameMode::class);
}

public function gameTags()
{
    return $this->belongsToMany(GameTag::class);
}

public function themes()
{
    return $this->belongsToMany(Theme::class);
}

public function saga()
{
    return $this->belongsTo(Saga::class);
}

// INTERACCIONES CON USER

public function users(){
    return $this->belongsToMany(User::class, 'user_games')->withTimestamps();
}

// sincronizar las tags de cada game

public function syncAutoTags()
{
    $tagNames = collect()
        ->merge($this->genres->pluck('name'))
        ->merge($this->themes->pluck('name'))
        ->merge($this->platforms->pluck('name'))
        ->merge($this->gameModes->pluck('name'));

    if ($this->saga) {
        $tagNames->push($this->saga->name);
    }

    $tags = GameTag::whereIn('name', $tagNames->unique())->get();

    $this->gameTags()->sync($tags->pluck('id'));
}

}
