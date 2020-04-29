<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Comment;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    protected $fillable = ["title","content","user_id"];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
