<p>{{$appointment->schedule->name}}</p>
<p>
    At : <b>{{\Carbon\Carbon::parse($appointment->date)->format('d-M-Y')}}</b> -
    <b>{{\Carbon\Carbon::parse($appointment->time)->format('h:i A')}}</b>
</p>
<p>
    Arranged By : <b>{{$appointment->user->name}}</b>
</p>
<p>
    Payment : <b>{{$appointment->payment ? $appointment->payment->payment : '0' }}</b>
</p>