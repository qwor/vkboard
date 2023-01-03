<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupWall extends Model
{
    use HasFactory;

    protected $fillable = [
        'wall_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
