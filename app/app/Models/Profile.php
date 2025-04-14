<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = ['name', 'firstname', 'status', 'admin_id', 'image_path'];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
