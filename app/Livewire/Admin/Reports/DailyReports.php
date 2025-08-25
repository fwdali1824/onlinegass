<?php

namespace App\Livewire\Admin\Reports;

use Livewire\Attributes\Layout;
use Livewire\Component;

class DailyReports extends Component
{
    #[Layout('components.layouts.admin')]
    public function render()
    {
        return view('livewire.admin.reports.daily-reports');
    }
}
