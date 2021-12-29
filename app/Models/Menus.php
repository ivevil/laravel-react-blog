<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menus extends Model
{
    use HasFactory;
    public $table = 'menus';
    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'navigation_menu',
        'footer_menu'
    ];

        public function pages()
    {
        return $this->belongsToMany('App\Models\Pages', 'menus_pages', 'menus_id', 'pages_id');
    }
}
