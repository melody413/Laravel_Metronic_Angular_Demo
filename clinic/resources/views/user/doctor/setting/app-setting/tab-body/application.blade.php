<div class="tab-pane" id="application-setup">

    <form action="javascript:void(0)" id="appSetupForm">
        {{csrf_field()}}
        <div class="form-group-custom">
            <input type="text" name="app_name" value="{{config('app.name')}}" required="required"/>
            <label class="control-label">Application Name</label><i class="bar"></i>
        </div>
        <div class="form-group-custom">
            <input type="text" name="timezone" value="{{config('app.timezone')}}" required="required"/>
            <label class="control-label">TimeZone</label><i class="bar"></i>
            <a href="http://php.net/manual/en/timezones.php" target="_blank">Find your timezone</a>
        </div>

        <button class="btn btn-primary" type="submit">Submit</button>
    </form>
</div>