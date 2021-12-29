<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pages extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'slug'
    ];

    public function menus()
    {
        return $this->belongsToMany('App\Models\Menus', 'menus_pages', 'pages_id', 'menus_id');
    }
}
