<?php

namespace App\Models;

use App\Trait\GlobalTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Language extends Model
{
    use HasFactory,GlobalTrait;
    protected $fillable = [
        'name', 'level', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
