<p>
    Patient Science : {{$patient->created_at->format('d-M-Y')}} <br>
    Total Prescription : {{count($patient->prescriptions)}} <br>
</p>

<a href="{{url('/patient-history/'.$patient->id)}}"><i class="fa fa-eye"></i> &nbsp; View Medical History</a> <br>
<a href="{{url('/patient-medical-file/'.$patient->id)}}"><i class="fa fa-plus"></i> &nbsp; Add Medical File </a>