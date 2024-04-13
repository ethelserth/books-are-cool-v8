<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'meta_description',
        'meta_title',
        'meta_keywords',
        'label_color',
        'label_text_color'
    ];

    public function posts(){
        return $this->belongsToMany(
            Post::class
        );
    }
}
