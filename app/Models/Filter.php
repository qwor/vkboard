<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filter extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'q',
        'tags',
        'start_date',
        'end_date',
        'count'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
