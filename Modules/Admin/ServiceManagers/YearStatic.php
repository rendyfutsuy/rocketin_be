<?php

namespace Modules\Admin\ServiceManagers;

use App\Http\Resources\Form\Form;

class YearStatic extends Form
{
    public function __construct($logs)
    {
        $this->parameters = $logs->toArray();
    }

    public function render()
    {
        return [
            "January" => count($this->get("January", [])),
            "February" => count($this->get("February", [])),
            "March" => count($this->get("March", [])),
            "April" => count($this->get("April", [])),
            "May" => count($this->get("May", [])),
            "June" => count($this->get("June", [])),
            "July" => count($this->get("July", [])),
            "August" => count($this->get("August", [])),
            "September" => count($this->get("September", [])),
            "October" => count($this->get("October", [])),
            "November" => count($this->get("November", [])),
            "December" => count($this->get("December", [])),
        ];
    }
}