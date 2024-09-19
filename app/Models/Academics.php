<?php

namespace App\Models;

use App\Trait\GlobalTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Academics extends Model
{
    use HasFactory, GlobalTrait;
    protected $fillable = [
        'institution',
        'degree',
        'field_of_study',
        'start_date',
        'end_date',
        'degree',
        'grade',
        'description',
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
