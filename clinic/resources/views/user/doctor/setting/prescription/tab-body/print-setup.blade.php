<div class="tab-pane active" id="print-setup">
    <form class="form-horizontal" role="form" id="prescriptionPrintSetup">
        {{csrf_field()}}
        <div class="form-group row">
            <label class="col-4 col-form-label">Show Generic Name in print prescription:</label>
            <div class="col-8">
                <input type="checkbox" name="generic_name" {{config('app.generic_name') ? 'checked' : ''}} />
            </div>
        </div>
        <div class="form-group row">
            <label class="col-4 col-form-label" for="example-email">Use fancy font</label>
            <div class="col-8">
                <input type="checkbox" name="fancy_font" {{config('app.fancy_font') ? 'checked' : ''}}/>
            </div>
        </div>
        <button type="submit" class="btn btn-success waves-block">Save</button>
        <p>After saved the prescription print setup. you hove to <a href="{{url('/config-cache')}}">cache config</a> to apply change</p>
    </form>
</div>

