<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Like;

class Post extends Model
{
    use HasFactory;

    public function uesr(){
        return $this->belongsTo(User::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }
    
    public function isLikedBy($user): bool {
        return Like::where('user_id', $user->id)->where('review_id', $this->id)->first() !==null;
    }

    public function image(){
        return $this->belongsTo(Image::class);
    }
}
