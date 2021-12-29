<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory; 
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'description'
    ];

    public function post()
    {
        return $this->belongsTo(\App\Models\Posts::class, 'categoryid');
    }
}
