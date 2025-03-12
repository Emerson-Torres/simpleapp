<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Login extends Model
{
    public $timestamps = false; // Desactiva created_at y updated_at

    protected $fillable = [
        'user_id',
        'login_time',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    protected function serializeDate(\DateTimeInterface $date)
    {
        return substr($date->toIso8601String(), 0, 19) . 'Z'; // Formato ISO 8601 sin milisegundos
    }
}
