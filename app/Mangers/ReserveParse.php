<?php

namespace App\Mangers;


class ReserveParse
{
    private $avDays = [];

    public function __construct($avDays, $branch)
    {
        $this->avDays = $avDays;
        $this->branch = $branch;
    }

    public function toArray()
    {
        return $this->avDays;
    }

    public function toJson()
    {
        return json_encode($this->avDays);
    }

    public function toHtml()
    {
        return view('frontend.doctor._reserve_unit' , [
            'avDays' => $this->avDays,
            'branch' => $this->branch
        ]);
    }
}
