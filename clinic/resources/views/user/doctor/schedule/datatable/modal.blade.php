
<button onclick="$(this).getScheduleDetails({{$id}})" class="btn btn-success" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-icon"></i>See Days</button>

<!--  Modal content for the above example -->
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title mt-0" id="scheduleHead"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Day</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                    </tr>
                    </thead>
                    <tbody id="renderHear">

                    {{--@foreach($schedule->dateTime as $dateTime)--}}
                        {{--<tr>--}}
                            {{--<td>{{$dateTime->days}}</td>--}}
                            {{--<td>{{\Carbon\Carbon::parse($dateTime->start_time)->format('g:i A')}}</td>--}}
                            {{--<td>{{\Carbon\Carbon::parse($dateTime->end_time)->format('g:i A')}}</td>--}}
                            {{--<td> <button class="btn btn-danger">Delete</button> </td>--}}
                        {{--</tr>--}}
                    {{--@endforeach--}}
                    </tbody>
                </table>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->