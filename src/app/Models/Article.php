<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Article extends Model
{
    protected $table = 'articles';

    protected $fillable = [
        'userid',
        'productid',
        'articletypeid',
        'topicid',
        'statusid',
        'title',
        'slug',
        'summary',
        'content',
        'image',
        'views',
        'is_enabled',
    ];

    // --- Các quan hệ giữ nguyên như cũ ---

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class, 'userid', 'id');
    }

    public function Topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class, 'topicid', 'id');
    }

    public function ArticleType(): BelongsTo
    {
        return $this->belongsTo(ArticleType::class, 'articletypeid', 'id');
    }

    public function ArticleStatus(): BelongsTo
    {
        return $this->belongsTo(ArticleStatus::class, 'statusid', 'id');
    }

    public function Comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'articleid', 'id');
    }
}