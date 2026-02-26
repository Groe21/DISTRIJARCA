<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeContact extends Model
{
    use HasFactory;

    protected $fillable = [
        'label',
        'title',
        'description',
        'address_title',
        'address',
        'phone_title',
        'phone_1',
        'phone_2',
        'email_title',
        'email_1',
        'email_2',
        'hours_title',
        'hours_weekday',
        'hours_saturday',
    ];
}
