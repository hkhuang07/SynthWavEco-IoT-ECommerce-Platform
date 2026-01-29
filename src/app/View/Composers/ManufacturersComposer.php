<?php

namespace App\View\Composers;

use App\Models\Manufacturer;
use Illuminate\View\View;

class ManufacturersComposer
{
    public function __construct(
        protected Manufacturer $manufacturers,
    ){} 

    public function compose(View $view): void
    {
        $view->with('manufacturers_menu',$this->manufacturers->orderBy('name')->get());

    }
}
