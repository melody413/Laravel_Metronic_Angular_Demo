

<div class="col-md-6">
    <div class="booking_holder flexer flex-column flexer_jc_center flexer_ai_stretch">
        <div class="has_booking">
            <form action="" method="post">
                <div id="bookingCarousel" class="carousel slide" data-ride="carousel" data-interval="false">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class="booking_item_row">

                                @foreach($avDays as $key=>$row)
                                    <div class="booking_item_col">
                                        <div class="booking_item flexer flex-column flexer_ai_center flexer_jc_center">
                                            <div class="day"><strong>{{ $row['name'] }}</strong></div>
                                            <div class="hours">
                                                @foreach($row['times'] as $time)
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="booking_point" id="dateTime_{{ $time['dateTime'] }}" value="{{ $time['dateTime'] }}">
                                                        <label class="form-check-label" for="dateTime_{{ $time['dateTime'] }}">
                                                            {{ $time['time'] }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="booking_action">
                                                <button type="submit" class="btn btn-dark">Book</button>
                                            </div>
                                        </div>
                                    </div>

                                    @if($key % 2 == 0 && $key != 0 && $key != 4)
                                        </div>
                                    </div>
                                    <div class="carousel-item ">
                                        <div class="booking_item_row">
                                    @endif
                                @endforeach

                            </div>
                        </div>

                    </div>

                    <a class="carousel-controller carousel-control-prev" href="#bookingCarousel" role="button" data-slide="prev">
                        <i class="fas fa-arrow-left" aria-hidden="true"></i>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-controller carousel-control-next" href="#bookingCarousel" role="button" data-slide="next">
                        <i class="fas fa-arrow-right" aria-hidden="true"></i>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>