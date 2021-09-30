<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Updated extends Component
{
    public $action;
    public $date;
    public $name;
    public $userId;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($action, $date, $name, $userId)
    {
        $this->action = $action;
        $this->date = $date;
        $this->name = $name;
        $this->userId = $userId;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.updated');
    }
}
