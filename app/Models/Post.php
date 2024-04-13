<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $casts = [
        'published_at' => 'datetime'
    ];

    protected $fillable = [
        'title',
        'slug',
        'author',
        'content',
        'image',
        'meta_description',
        'meta_title',
        'meta_keywords',
        'published_at',
        'enabled',
        'featured',
        'notion_id'
    ];

    // public function author()
    // {
    //     return $this->belongsTo(User::class,'user_id');
    // }

    public function categories(){
        return $this->belongsToMany(
            Category::class
        );
    }

    public function scopePublished($query){
        $query->where('published_at','<=',Carbon::now());
    }

    public function scopeFeatured($query){
        $query->where('featured','1');
    }

    public function scopeEnabled($query){
        $query->where('enabled','1');
    }

    public function scopeWithCategory($query, string $category){
        $query->whereHas('categories',function($query) use ($category) {
            $query->where('slug',$category);
        });
    }

    public function getReadingTime(){
        $min = round(str_word_count($this->content)/250);
        return ( $min < 1 ) ? '1' : $min;
    }

    public function getCoverImage(){
        $isUrl = str_contains($this->image,'http');
        return ($isUrl) ? $this->image : Storage::disk('public')->url($this->image); 
    }
}
