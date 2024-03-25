<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class post_data extends Model
{
    use HasFactory;
    protected $fillable = [
        'post_text', 'post_img'
    ];
}
