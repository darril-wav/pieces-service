<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Piece extends Model
{
    protected $fillable = [
        'block_id', 'name', 'peso_teorico',
        'peso_real', 'estado', 'fecha_fabricacion',
    ];

    protected $casts = [
        'peso_teorico'      => 'decimal:3',
        'peso_real'         => 'decimal:3',
        'fecha_fabricacion' => 'datetime',
    ];

    protected $appends = ['diferencia_peso'];

    public function diferenciaPeso(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->peso_real !== null
                ? round((float)$this->peso_real - (float)$this->peso_teorico, 3)
                : null,
        );
    }

    public function block(): BelongsTo
    {
        return $this->belongsTo(Block::class);
    }

    protected static function booted(): void
    {
        static::saving(function (Piece $piece) {
            if ($piece->isDirty('estado') && $piece->estado === 'fabricada') {
                $piece->fecha_fabricacion ??= now();
            }
        });
    }
}