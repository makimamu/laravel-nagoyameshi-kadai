<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegularHoliday extends Model
{
    use HasFactory;

    // 多対多のリレーションシップを定義
    public function restaurants()
    {
        return $this->belongsToMany(Restaurant::class, 'regular_holiday_restaurant');
    }
}
    