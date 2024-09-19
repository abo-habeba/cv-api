<?php

namespace App\Models;

use App\Trait\GlobalTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Experience extends Model
{
    use HasFactory, GlobalTrait;

    protected $fillable = [
        'title',
        'company',
        'start_date',
        'end_date',
        'is_current',
        'description',
        'responsibilities',
        'achievements',
        'employment_type',
        'industry',
        'skills',
        'location',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function photos(): MorphMany
    {
        return $this->morphMany(Photo::class, 'imageable');
    }
}
