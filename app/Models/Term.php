<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    use HasFactory;
        // マスアサインメントを許可する属性を指定
        protected $fillable = [
            'content',
        ];
    }