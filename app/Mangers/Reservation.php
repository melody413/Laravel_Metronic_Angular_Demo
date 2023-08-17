<?php

namespace App\Mangers;


use Carbon\Carbon;

class Reservation
{
    const NUMBER_OF_DAYS = 45;
    const DATE_FORMAT = 'd/m/Y';
    const TIME_FORMAT = 'H,i,a';
    private $carbon;
    private $fromDate;

    private $daysOfWeek = [
        Carbon::SUNDAY,
        Carbon::MONDAY,
        Carbon::TUESDAY,
        Carbon::WEDNESDAY,
        Carbon::THURSDAY,
        Carbon::FRIDAY,
        Carbon::SATURDAY
    ];

    private $reservationDays;
    private $reservationDaysSplit;
    private $toDayOfWeek;
    private $avaliableDayDate = [];
    private $start_time;
    private $end_time;

    public function __construct($branch, $reservationDays, $fromDate)
    {
        $this->branch = $branch;
        $this->setFromDate($fromDate);
        $this->setReservationDays($reservationDays);

        $this->initCarbon();
        $this->initReservation();
    }

    private function setFromDate($fromDate)
    {
        $this->fromDate = $fromDate;
    }

    private function setReservationDays($reservationDays)
    {
        $this->reservationDays = $reservationDays;
    }

    private function initCarbon()
    {
        $this->carbon = Carbon::createFromFormat('d/m/Y', $this->fromDate);
    }

    private function initReservation()
    {
        $this->toDayOfWeek = $this->carbon->dayOfWeek;
        $this->reservationDaysSplit = str_split($this->reservationDays);
    }

    private function setAvaliableDayDate($date)
    {
        $this->avaliableDayDate[] = $date;
    }

    private function setTodayReservation()
    {
        if($this->reservationDaysSplit[$this->toDayOfWeek] == 1)
        {
            $this->setAvaliableDayDate($this->carbon->format(self::DATE_FORMAT));
        }
    }

    private function getTodayReservation()
    {
        return $this->avaliableDayDate;
    }

    private function getAvaliableReservationDays($ignorLastDay = false)
    {
        $round = 8;
        for($i=0;$i<$round;$i++)
        {
            foreach($this->reservationDaysSplit as $key => $day)
            {
                if ( count($this->avaliableDayDate) > self::NUMBER_OF_DAYS - 1 )
                    break;

                if ( $day == 1 && ($key > $this->toDayOfWeek | $ignorLastDay))
                    $this->setAvaliableDayDate( $this->carbon->next($this->daysOfWeek[$key])->format(self::DATE_FORMAT) );
            }
        }
    }


    public function getDays()
    {
        //checkToday and add Today
        $this->setTodayReservation();

        //normal parse date
        $this->getAvaliableReservationDays();

        //if less than 3 day
        $this->getAvaliableReservationDays(true);

        return $this->getTodayReservation();
    }

    public function setTimes($startTime, $endTime)
    {
        $this->start_time = $startTime;
        $this->end_time = $endTime;
    }

    public function getTimes()
    {
        $startTime = '30/10/2018 ' . $this->start_time;
        $endTime = '30/10/2018 ' . $this->end_time;

        $ht1 = Carbon::createFromFormat('d/m/Y H:i:s', $startTime);
        $ht2 = Carbon::createFromFormat('d/m/Y H:i:s', $endTime);
        $ht3 = Carbon::now()->format('H:i:s');

        if ($ht1->format('a') == 'pm' && $ht2->format('a') == 'am')
        {
            $endTime = '31/10/2018 ' . $this->end_time;
            $ht2 = Carbon::createFromFormat('d/m/Y H:i:s', $endTime);
        }
        $patient_every = 30;
        if ($this->branch->patient_every)
            $patient_every = $this->branch->patient_every;

        $totalAvaliableReservTimes = $ht1->diffInMinutes($ht2) /  $patient_every;

        $times = [];
        $times[] = $ht1->format(self::TIME_FORMAT);

        for( $i=0; $i < $totalAvaliableReservTimes; $i++)
        {
            $times[] = $ht1->modify('+' . $patient_every . 'minutes')->format(self::TIME_FORMAT);
        }

        unset($times[count($times) - 1]);
       return $times;
    }

}
