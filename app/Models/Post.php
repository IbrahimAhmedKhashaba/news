<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory , Sluggable;

    protected $guarded = [];

    public function category(){
        return $this->belongsTo(Category::class , 'category_id');
    }

    public function user(){
        return $this->belongsTo(User::class , 'user_id');
    }

    public function admin(){
        return $this->belongsTo(Admin::class , 'admin_id');
    }

    public function comments(){
        return $this->hasMany(Comment::class , 'post_id');
    }

    public function images(){
        return $this->hasMany(Image::class);
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function scopeActive($query){
        $query->where('status', 1);
    }

    public function scopeActiveUser($query){
        $query->whereHas('user', function($user){
            return $user->where('status', 1);
        })->orWhere('user_id' , null);
    }

    public function scopeActiveCategory($query){
        $query->whereHas('category', function($category){
            return $category->where('status', 1);
        });
    }
}
