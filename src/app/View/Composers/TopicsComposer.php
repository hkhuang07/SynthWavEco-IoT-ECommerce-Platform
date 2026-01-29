<?php

namespace App\View\Composers;

use App\Models\Topic;
use Illuminate\View\View;

class TopicsComposer
{
    public function __construct(
        protected Topic $topics,
    ){} 

    public function compose(View $view): void
    {
        $view->with('topics_menu',$this->topics->orderBy('name')->get());

    }
}
