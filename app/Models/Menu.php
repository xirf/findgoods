<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model {
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'description',
        'icon',
        'rate',
        'status',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array {
        return [
            'name',
            'price',
            'description',
            'icon',
        ];
    }
}
