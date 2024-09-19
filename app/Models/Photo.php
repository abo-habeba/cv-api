<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Photo extends Model
{
    use HasFactory;
    protected $table = 'photos';

    protected $fillable = ['path', 'type', 'imageable_id', 'imageable_type'];

    /**
     * Get the parent imageable model (user, social, skill, etc.)
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }
}

