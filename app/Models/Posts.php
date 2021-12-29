<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'body',
        'featured_image'
    ];

    public function getImageAttribute()
    {
       return $this->featured_image;
    }

    public function comments()
    {
        return $this->hasMany(Comments::class);
    }

     public function categories()
    {
        return $this->belongsTo(Categories::class, 'categoryid');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'userid');
    }

        public function images()
    {
        return $this->hasMany(Media::class);
    }
}
