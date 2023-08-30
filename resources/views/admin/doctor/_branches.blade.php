

<script type="text/javascript" src="//googlemaps.github.io/js-marker-clusterer/src/markerclusterer.js"></script>


<div id="doctorBranches">

    <button type="button" class="btn btn-danger waves-effect" @click="addNewBranch()" >
        <i class="material-icons">fiber_new</i>
        Add New Branch
    </button>

    <div class="modal fade" id="largeModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="largeModalLabel">Add new branch</h4>
                </div>
                <div class="modal-body">
                    <div v-show="!modalBusy">
                        <div class="input-group input-group-lg" >
                            <span class="input-group-addon">
                                branches work days
                            </span>

                            <span v-for="d,i in daysNameInWeek">
                                <input type="checkbox" v-model="daysWeek[i]" value="1" v-bind:true-value="1" v-bind:false-value="0" name="work_days[]"  :id="`brn_` + d " class="filled-in">
                                <label :for="`brn_` + d ">@{{ d }}</label>
                            </span>
                    </div>

                        <div class="input-group input-group-lg">
                        <span class="input-group-addon">
                            {{ Form::label('Start time ') }} :
                        </span>
                            <div class="form-line">
                                <input v-model="startTime" name="branch_time_start" type="text" class="form-control time24"
                                       placeholder="Ex: 21:00">
                            </div>
                            <small>24 h format</small>
                        </div>

                        <div class="input-group input-group-lg">
                        <span class="input-group-addon">
                            {{ Form::label('End time ') }} :
                        </span>
                            <div class="form-line">
                                <input v-model="endTime" name="branch_end_time" type="text" class="form-control time24"
                                       placeholder="Ex: 01:00">

                            </div>
                            <small>24 h format</small>
                        </div>

                        <div class="input-group input-group-lg">
                        <span class="input-group-addon">
                            {{ Form::label('Patient Every ') }} :
                        </span>
                            <div class="form-line">
                                <input v-model="patientEvery" name="branch_patient_every" type="text" class="form-control">
                            </div>
                            <small>per minute</small>
                        </div>

                        <div class="input-group input-group-lg">
                        <span class="input-group-addon">
                            {{ Form::label('Phones ') }} :
                        </span>
                            <div class="form-line">
                                <input v-model="phones" name="branch_phone" type="text" class="form-control">
                            </div>
                        </div>

                        <div class="row" >
                            <div class="col-sm-6" v-for="lang,lvv in ['Ar', 'En']">
                            <div class="input-group input-group-lg">
                                <div class="input-group-addon">
                                    <label for="Phones ">Address @{{ lang }} </label>
                                </div>
                                <div class="form-line">
                                    <textarea v-model="branchAddress[lvv]" class="form-control"></textarea>
                                </div>
                            </div>
                            </div>
                        </div>

                        <div class="input-group input-group-lg">
                        <span class="input-group-addon">
                            {{ Form::label('City ') }} :
                        </span>
                            <div class="form-line">
                                {!! Form::select('branch_city_id', [] ,null ,
                                    ['class' => 'form-control bsGetAjaxData bsSelect',
                                    'id' => 'branchBsCityies',
                                    'data-val' => isset($item->city_id)?$item->city_id:'',
                                    '@change' => 'onChangeCity',
                                     'v-model'=>"city"])
                                !!}
                            </div>
                            @include('admin.partial._row_error', ['input' => 'city_id'])
                        </div>

                        <div class="input-group input-group-lg">
                        <span class="input-group-addon">
                            {{ Form::label('Area ') }} :
                        </span>
                            <div class="form-line">
                                {!! Form::select('branch_area_id', [] ,null ,
                                 ['class' => 'form-control bsGetAjaxData bsSelect',
                                 'id' => 'branchBsAreas',
                                 'data-val' => isset($item->area_id)?$item->area_id:'',
                                 '@change' => 'onChangeArea',
                                 'v-model'=>"area"])
                                 !!}
                            </div>
                            @include('admin.partial._row_error', ['input' => 'area_id'])
                        </div>

                        <div class="input-group input-group-lg">
                        <span class="input-group-addon">
                            {{ Form::label('GMap ') }} :
                        </span>
                            <div class="form-line">

                                <p style="clear: both"></p>
                                <div style="width: 100%; height: 300px">
                                    <div id="map-canvas-0" style="width: 100%; height: 100%; margin: 0; padding: 0; position: relative; overflow: hidden;"></div>
                                </div>
                                <p style="clear: both"></p>
                            </div>
                        </div>
                    </div>
                    <div class="preloader pl-size-xl center" v-if="modalBusy">
                        <div class="spinner-layer ">
                            <div class="circle-clipper left">
                                <div class="circle"></div>
                            </div>
                            <div class="circle-clipper right">
                                <div class="circle"></div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link waves-effect" @click="saveNewBranchToForm">SAVE CHANGES</button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row p-t-30">
        <div class="col-sm-6" v-for="branche,i in branches" @click="openModalToEdit(branche, i)">
            <div class="list-group">
                <a href="javascript:void(0);" class="list-group-item">
                    work days
                    <span class="badge bg-pink" v-for="day in branche.daysOfWeekName">
                        @{{ day }}
                    </span>
                    <input :name="`branche[` + i +`]['daysOfWeek']`" :value="branche.daysOfWeek" type="hidden" />
                </a>
                <a href="javascript:void(0);" class="list-group-item">
                    Start time
                    <span class="badge bg-cyan">@{{ branche.startTime }}</span>
                    <input :name="`branche[` + i +`]['startTime']`" :value="branche.startTime" type="hidden" />
                </a>
                <a href="javascript:void(0);" class="list-group-item">
                    End time
                    <span class="badge bg-teal">@{{ branche.endTime }}</span>
                    <input :name="`branche[` + i +`]['endTime']`" :value="branche.endTime" type="hidden" />
                </a>
                <a href="javascript:void(0);" class="list-group-item">
                    Patient Every
                    <span class="badge bg-orange">@{{ branche.patientEvery }} M</span>
                    <input :name="`branche[` + i +`]['patientEvery']`" :value="branche.patientEvery" type="hidden" />
                </a>
                <a href="javascript:void(0);" class="list-group-item">
                    phones
                    <span class="badge bg-purple">@{{ branche.phones }}</span>
                    <input :name="`branche[` + i +`]['phones']`" :value="branche.phones" type="hidden" />
                </a>
                <a href="javascript:void(0);" class="list-group-item">
                    Location
                    <span class="badge bg-purple">@{{ branche.area.name }}</span>
                    <span class="badge bg-purple">@{{ branche.city.name }}</span>
                    <input :name="`branche[` + i +`]['city']`" :value="branche.city.id" type="hidden" />
                    <input :name="`branche[` + i +`]['area']`" :value="branche.area.id" type="hidden" />
                </a>
                <div class="list-group-item">
                    <button type="button" @click.stop.prevent="goToReservationPage" class="btn bg-cyan waves-effect">Reservation</button>
                    <button type="button" @click.stop.prevent="openModalToEdit(branche,i)" class="btn bg-indigo waves-effect">Edit</button>
                    <button type="button" @click.stop.prevent="deleteBranch(i)" class="btn bg-red waves-effect">Delete</button>
                </div>
                <input :name="`branche[` + i +`]['lat_lng']`" :value="branche.latLng" type="hidden" />
                <input :name="`branche[` + i +`]['address'][ar]`" :value="branche.branchAddress[0]" type="hidden" />
                <input :name="`branche[` + i +`]['address'][en]`" :value="branche.branchAddress[1]" type="hidden" />
            </div>
        </div>
    </div>

</div>



