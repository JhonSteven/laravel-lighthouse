<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Post;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    protected $fillable = ['reply','post_id'];
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
