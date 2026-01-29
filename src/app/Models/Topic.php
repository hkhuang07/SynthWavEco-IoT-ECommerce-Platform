<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Topic extends Model
{
    protected $table = 'topics';

    public function Article(): HasMany
    {
        return $this->hasMany(Article::class, 'topicid', 'id');
    }
}
