<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'telephone',
        'point',
    ];

    public function sale()
    {
        return $this->hasMany(Sale::class, 'member_id');
    }
    public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}
}
