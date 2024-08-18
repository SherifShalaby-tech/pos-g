<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CollapseBody extends Component
{

    public $collapseId;

    public function __construct($collapseId)
    {
        $this->collapseId = $collapseId;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.collapse-body');
    }
}
