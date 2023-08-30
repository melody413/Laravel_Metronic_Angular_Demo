<!-- Modal -->
<div class="modal fade the_modal" id="raiting_modal" tabindex="-1" role="dialog" aria-labelledby="rating_modal_title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rating_modal_title">{{ trans('general.rating') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('frontend.doctor.review',['id'=>$row->id])}}" method="post">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="review_value" value="0" id="review-star-value">
                    <div class="form-group">
                        <label for="review_comment">{{ trans('general.review_comment_label') }}</label>
                        <textarea id="review_comment" class="form-control" rows="3" name="review_comment"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('general.close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ trans('general.save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
