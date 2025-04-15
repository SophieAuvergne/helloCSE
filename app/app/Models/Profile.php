<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'firstname', 'status', 'admin_id', 'image_path'];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
