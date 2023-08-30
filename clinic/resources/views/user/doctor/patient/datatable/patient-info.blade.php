<b>{{$patient->name}}</b> <br>
Gender : @if($patient->gender ==1)
    Male
@elseif($patient->gender == 2)
    Fe-Male
@else
    Other
@endif
<br>
Age : {{$patient->age()}} <br>

<a href="javascript:void(0);" onclick="window.location.replace('{{url('/take-patient-to-prescription-page/'.$patient->id)}}')"><i class="ti ti-ink-pen"></i> Prescribe Now </a>
<br>
<a href="javascript:void(0);" onclick="window.location.replace('{{url('/take-patient-to-appointment/'.$patient->id)}}')"><i class="ti ti-calendar"></i> New Appointment </a>
