<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lab extends Model
{
    use HasFactory;
    protected $fillable = [
        'added_by',
        'name',
    ];

    public function added_by()
    {
        return $this->belongsTo(User::class, 'added_by');
    }
}
