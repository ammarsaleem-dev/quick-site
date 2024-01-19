<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DeleteModal extends Component
{

    public $itemId;
    public $itemName;

    /**
     * Create a new component instance.
     */
    public function __construct($itemId, $itemName)
    {
        $this->itemId = $itemId;
        $this->itemName = $itemName;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.delete-modal');
    }
}
