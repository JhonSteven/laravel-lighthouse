<?php

namespace App\Observers;
use App\Comment;

class TransactionObserver
{
    public function created(Comment $comment)
    {
        $reply = $comment->reply;
        $comment->reply = $reply.'a';
        return $comment->save();
    }
}
