<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    protected $table = 'comments';

    public function Article(): BelongsTo
    {
        return $this->belongsTo(Article::class, 'articleid', 'id');
    }

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class, 'userid', 'id');
    }
    
}
