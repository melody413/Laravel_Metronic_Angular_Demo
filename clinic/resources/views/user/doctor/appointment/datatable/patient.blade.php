<p>
    <img width="200px" height="200px" class="img-fluid"
         src="{{url($appointment->patient->image != null ? $appointment->patient->image : "dashboard/images/image_placeholder.jpg")}}"
         alt=""
         align="right"
    >
<div>
    <span>
    {{$appointment->patient->name}} <br>
    </span>
    <span>
    Phone : <b>{{$appointment->patient->phone}}</b> <br>
    Email : <b>{{$appointment->patient->email}}</b>
   </span> <br>
    <a href="javascript:void(0);" onclick="window.location.replace('{{url('/take-patient-to-prescription-page/'.$appointment->patient->id)}}')" class="btn btn-default"><i class="ti-pencil"></i> Write new prescription</a>

</div>

</p>

