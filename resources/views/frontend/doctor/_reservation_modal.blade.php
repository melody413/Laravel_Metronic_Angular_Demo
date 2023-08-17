<!-- Modal -->
<div class="modal fade the_modal" id="reserve_modal" tabindex="-1" role="dialog" aria-labelledby="reserve_modal_title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reserve_modal_title">{{ trans('general.booking_an_appointment') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('frontend.doctor.reserve',['id'=>$row->id])}}" method="post">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="branch_id" value="0" id="doctorReserveBranchId">
                    <input type="hidden" name="reserve_date" value="0" id="doctorReserveDateId">
                    <div class="form-group">
                        <label for="reserve_name">{{ trans('general.name') }}</label>
                        <input type="text" name="reserve_name" class="form-control" value="{{ Auth::check() ? Auth::user()->name : '' }}">
                    </div>
                    <div class="form-group">
                        <label for="reserve_email">{{ trans('general.email_address') }}</label>
                        <input type="email" name="reserve_email" class="form-control" value="{{ Auth::check() ? Auth::user()->email : '' }}">
                    </div>
                    <div class="form-group">
                        <label for="reserve_phone">{{ trans('general.phone') }}</label>
                        <input type="text" name="reserve_phone" class="form-control" value="{{ Auth::check() ? Auth::user()->phone : '' }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('general.close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ trans('general.reserve_now') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
