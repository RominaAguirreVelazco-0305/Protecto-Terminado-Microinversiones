<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    protected $fillable = ['title', 'description', 'amount', 'status', 'user_id', 'image'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}


