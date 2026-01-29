<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class ArticleStatus extends Model
{
    protected $table = 'article_statuses';
    protected $fillable = [];   

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class, 'statusid', 'id'); 
    }
}
