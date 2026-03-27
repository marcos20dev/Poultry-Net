<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DashboardCard extends Component
{
    public $title;
    public $value;
    public $subValue;
    public $icon;
    public $color;
    public $trend;
    public $trendColor;
    public $trendText;

    public function __construct($title, $value, $icon = 'activity', $color = 'green', $subValue = null, $trend = null, $trendColor = null, $trendText = null)
    {
        $this->title = $title;
        $this->value = $value;
        $this->subValue = $subValue;
        $this->icon = $icon;
        $this->color = $color;
        $this->trend = $trend;
        $this->trendColor = $trendColor;
        $this->trendText = $trendText;
    }

    public function render()
    {
        return view('components.dashboard-card');
    }
}
