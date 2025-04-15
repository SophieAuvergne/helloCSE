<?php

namespace App\Models;

use Database\Factories\ProfileFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Profile extends Model
{
    /** @use HasFactory<ProfileFactory> */
    use HasFactory;

    protected $fillable = ['name', 'firstname', 'status', 'admin_id', 'image_path'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Comment, \App\Models\Profile>
     */
    public function comments(): HasMany
    {
        /** @var \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Comment, \App\Models\Profile> $relation */
        $relation = $this->hasMany(Comment::class);
        return $relation;
    }
}
