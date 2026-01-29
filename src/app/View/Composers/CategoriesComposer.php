<?php

namespace App\View\Composers;

use App\Models\Category;
use Illuminate\View\View;

class CategoriesComposer
{
    public function __construct(
        protected Category $categories,
    ){} 

    public function compose(View $view): void
    {
        $view->with('categories_menu',$this->categories->orderBy('name')->get());

    }
}
