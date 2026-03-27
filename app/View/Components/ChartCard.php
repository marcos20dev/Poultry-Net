<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ChartCard extends Component
{
    public $title;
    public $canvasId;
    public $buttons;

    public function __construct($title = '', $canvasId = '', $buttons = null)
    {
        $this->title = $title;
        $this->canvasId = $canvasId;
        $this->buttons = $buttons;
    }

    public function render()
    {
        return view('components.chart-card');
    }
}
