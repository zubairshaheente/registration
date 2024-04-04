<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class enter_user_record extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'first_name', 'last_name', 'email', 'phn_num', 'password', 'address',
    ];

    public function posts()
    {
        return $this->hasMany(PostData::class);
    }
}