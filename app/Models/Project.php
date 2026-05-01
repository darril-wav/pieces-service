<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Project extends Model
{
    protected $fillable = ['name', 'description', 'active'];

    protected $casts = ['active' => 'boolean'];

    public function blocks(): HasMany
    {
        return $this->hasMany(Block::class);
    }

    public function pieces(): HasManyThrough
    {
        return $this->hasManyThrough(Piece::class, Block::class);
    }
}