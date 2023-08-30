<?php


namespace App\Mangers;


use App\Models\DoctorBranch;
use Carbon\Carbon;

class DoctorReservation
{
    const TZ = 3;
    const NUMBER_OF_DAYS = 20;

    private $startFrom;
    private $doctor;
    private $avDays = [];

    public function __construct($doctor,$branch , $startFrom)
    {
        $this->doctor = $doctor;
        $this->startFrom = $startFrom;
        $this->branch = $branch;
    }

    private function getBranchAvbDays(DoctorBranch $branch)
    {
        $carbonNow = Carbon::now(3);

        $reservation = new Reservation($branch, $branch->day_of_week, $this->startFrom);
        $reservation->setTimes($branch->time_start, $branch->time_end);
        $avTimes = $reservation->getTimes();

        //if ($nextTime > $ht3)
        $weFoundTimes = false;
        foreach ($reservation->getDays() as $day)
        {
            $isToday = false;
            $dt = Carbon::createFromFormat('d/m/Y', $day);

            $dayTimeStamp = $dt->getTimestamp();

            if($dt->isToday())
            {
                $dayName = 'Today';
                $isToday = true;
            }
            else if ($dt->isTomorrow())
                $dayName = trans('general.tomorrow');
            else
                $dayName = $dt->format('D  d/m');

            $this->avDays[$dayTimeStamp] = [
                'name' => $dayName,
                'date' => $day,
                'times' => []
            ];

            //dd($avTimes);
            foreach ($avTimes as $time)
            {
                $timeSplit = explode(',', $time);

                $dayDate = $dt->format('d/m/Y');
                if($timeSplit[2] == 'am')
                    $dayDate = $carbonNow->format('d/m/Y');

                $dtCarbonTime = Carbon::createFromFormat('d/m/Y H:i',  $dayDate . ' ' . $timeSplit[0] . ':' . $timeSplit[1] , self::TZ);

                if( $isToday && $carbonNow > $dtCarbonTime )
                    continue;

                $dateTimeRow = Carbon::createFromFormat('d/m/Y H:i',  $dt->format('d/m/Y') . ' ' . $timeSplit[0] . ':' . $timeSplit[1] , self::TZ);

                $reserveDateTimeCheckDb = \App\Models\DoctorReservation::where('doctor_id', $this->doctor->id)
                    ->where('doctor_branch_id', $this->branch->id)
                    ->where('reserve_date', $dateTimeRow->format('Y-m-d') )
                    ->where('reserve_time', $dateTimeRow->format('H:i') )
                    ->first()
                    ;

                if(isset($reserveDateTimeCheckDb->id))
                    continue;

                $weFoundTimes = true;
                $this->avDays[$dayTimeStamp]['times'][] = [
                    'branch' => $branch->id,
                    'time' => $dtCarbonTime->format('h:i a'),
                    'dateTime' => $dateTimeRow->format('d/m/Y H:i')
                ];
            }

            if($weFoundTimes == false)
                unset($this->avDays[$dayTimeStamp]);
        }
    }

    public function getAvailableDays()
    {
        $carbonNow = Carbon::now(3);

        $d=0;
        foreach($this->doctor->branches as $branch)
        {
            $this->getBranchAvbDays($branch);
            $d++;
        }

        ksort($this->avDays);
        $this->avDays = array_splice($this->avDays, 0, self::NUMBER_OF_DAYS);
    }

    public function parse()
    {
        $this->getBranchAvbDays($this->branch);

        ksort($this->avDays);
        $this->avDays = array_splice($this->avDays, 0, self::NUMBER_OF_DAYS);

        return (new ReserveParse($this->avDays, $this->branch));
    }
}
