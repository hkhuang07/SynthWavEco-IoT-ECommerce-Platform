<?php

namespace App\View\Composers;

use App\Models\ArticleType;
use Illuminate\View\View;

class ArticleTypesComposer
{
    public function __construct(
        protected ArticleType $article_types,
    ){} 

    public function compose(View $view): void
    {
        $view->with('article_types_menu',$this->article_types->orderBy('name')->get());

    }
}
