
faker = require 'faker'
_ = require 'lodash'

$('#mdModal').modal('show');

vueDoctorBranchesApp = ->

  if $('#doctorBranches').length == 0
    console.log '-->return'
    return;

  app = new window.Vue({
    el: '#doctorBranches'
    data: {
      modalOpenForId: null
      modalBusy: true
      maps: []
      daysNameInWeek: [
        'Sunday',
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday',
      ]
      branches: []
      daysWeek: [0,0,0,0,0,0,0]
      startTime: ''
      endTime: ''
      patientEvery: ''
      phones: null
      branchAddress: []
      city: ''
      area: ''
      latLng: '30.9619384,31.1659896'
      cityName: ''
      areaName: ''
      daysOfWeekName: []
    }
    methods: {

      intial: ->
        self = @
        newBranch = self.intialVarTest()
        newBranch = self.prepareNewBranchObj(newBranch)
        self.branches.push(newBranch);
        return

      intialVarTest: ->
        self = @
        newBranch =
          daysWeek: [1,0,1,0,1,0,1]
          startTime: '19:00'
          endTime: '21:00'
          patientEvery: '30'
          phones: '010200110456'
          branchAddress: [
            '51B Missr Hellowan madii,cairo',
            '105 el dokii chair factory,cairo'
          ]
          latLng: '30.9619384,31.1659896'
          city: 4
          cityName: 'Alex'
          area: 12
          areaName: 'port emad'
        return newBranch

      resetInitialData: (obj = undefined ) ->
        self = @
        self.daysWeek = if obj?.daysWeek then obj.daysWeek else [0,0,0,0,0,0,0]
        self.startTime = if obj?.startTime then obj.startTime else ''
        self.endTime = if obj?.endTime then obj.endTime else''
        self.patientEvery = if obj?.patientEvery then obj.patientEvery else ''
        self.phones = if obj?.phones then obj.phones else ''
        self.branchAddress = if obj?.branchAddress then obj.branchAddress else []
        self.city = if obj?.city then obj.city else ''
        self.area = if obj?.area then obj.area else ''
        self.latLng = if obj?.latLng then obj.latLng else '30.9619384,31.1659896'
        self.cityName = if obj?.cityName then obj.cityName else ''
        self.areaName = if obj?.areaName then obj.areaName else ''
        return

      prepareNewBranchObj: (obj = undefined) ->
        self = @

        if ! _.isEmpty(obj)
          self.resetInitialData(obj)

        newBranch = {}
        newBranch.daysOfWeek = _.concat self.daysWeek, ''
        newBranch.daysWeek = _.concat self.daysWeek, ''
        newBranch.startTime = self.startTime
        newBranch.endTime = self.endTime
        newBranch.city = {
          id: self.city
          name: self.cityName
        }
        newBranch.area = {
          id: self.area
          name: self.areaName
        }
        newBranch.phones = self.phones
        newBranch.branchAddress = self.branchAddress
        newBranch.latLng = self.latLng
        newBranch.patientEvery = self.patientEvery
        newBranch.daysOfWeekName = self.getDaysName(newBranch.daysOfWeek)
        newBranch.daysName = self.getDaysName(newBranch.daysOfWeek)

        return newBranch

      getDaysName: (daysOfWeek) ->
        self = @
        daysName = []
        for d,i in daysOfWeek
          if d == 1
            daysName.push(self.daysNameInWeek[i])
        return daysName

      onChangeCity: (event) ->
        @.city = $(event.target.selectedOptions).val()
        @.cityName = $(event.target.selectedOptions).text()
        return

      onChangeArea: (event) ->
        @.area = $(event.target.selectedOptions).val()
        @.areaName = $(event.target.selectedOptions).text()
        return

      addNewBranch: ->
        $('#largeModal').modal('show');
        @modalOpenForId = undefined
        @resetInitialData()
        @modalBusy = false
        return

      openModalToEdit: (branch, i)->
        self = @
        @modalBusy = true
        $('#largeModal').modal('show');
        @modalOpenForId = i
        @resetInitialData(branch)

        setTimeout ( ->
          $('select[name=branch_city_id]').val(branch.city.id);
          $('select[name=branch_city_id]').selectpicker('refresh')

          $('select[name=branch_area_id]').val(branch.area.id);
          $('select[name=branch_area_id]').selectpicker('refresh')

          self.modalBusy = false
          self.initialGoogleMap(branch.latLng)
        ), 300

        return

      deleteBranch: (i) ->
        self = @

        branches = []
        branches = self.branches

        preBranches = []
        branches.splice(i, 1);

        self.branches = []
        self.branches = branches
        return

      saveNewBranchToForm: ->
        self = @
        newBranch = self.prepareNewBranchObj({})
        branches = self.branches

        if self.modalOpenForId != undefined
          self.branches = []
          branches[self.modalOpenForId] = newBranch
          self.branches = branches
        else
          self.branches.push(newBranch);
        $('#largeModal').modal('hide');

        return

      goToReservationPage: ->
        return

      initialGoogleMap: (latLng = undefined) ->
        self = @
        self.maps = []

        if latLng == undefined
          latLng = '29.987922,31.2256656'

        latLng = latLng.split(',')

        bounds = new (google.maps.LatLngBounds)
        infowindow = new (google.maps.InfoWindow)
        position = new (google.maps.LatLng)(latLng[0], latLng[1])
        mapOptions_0 =
          center: position
          zoom: 14
          mapTypeId: google.maps.MapTypeId.ROADMAP
          disableDefaultUI: false
          scrollwheel: true
          zoomControl: true
          mapTypeControl: true
          scaleControl: false
          streetViewControl: true
          rotateControl: false
          fullscreenControl: true
        map_0 = new (google.maps.Map)(document.getElementById('map-canvas-0'), mapOptions_0)
        map_0.setTilt 0
        markers = []
        infowindows = []
        shapes = []
        markerPosition_0 = new (google.maps.LatLng)(latLng[0], latLng[1])
        marker_0 = new (google.maps.Marker)(
          position: markerPosition_0
          draggable: true
          title: ''
          label: ''
          animation: ''
          icon: '')
        bounds.extend marker_0.position
        marker_0.setMap map_0
        markers.push marker_0
        google.maps.event.addListener marker_0, 'dragend', (event) ->
          console.log 'drag end', event
          return
        idleListener = google.maps.event.addListenerOnce(map_0, 'idle', ->
          map_0.setZoom 14
          return
        )
        map = map_0
        google.maps.event.addListenerOnce map_0, 'tilesloaded', ->
          self.changeMarkerPosition(self.maps)
          return
        markerClusterOptions =
          imagePath: '//googlemaps.github.io/js-marker-clusterer/images/m'
          gridSize: 60
          maxZoom: null
          averageCenter: false
          minimumClusterSize: 2
        markerCluster = new MarkerClusterer(map_0, markers, markerClusterOptions)
        self.maps.push
          key: 0
          markers: markers
          infowindows: infowindows
          map: map_0
          shapes: shapes
        return

      changeMarkerPosition: (maps) ->
        self = @
        markers = []
        markers.push self.maps[0].markers[0]
        #self.maps[0].markers[0].addListener 'dragend', self.setGMapSelectMarkerEndDrag(event, self)
        google.maps.event.addListener self.maps[0].map, 'click', (event) ->
          i = 0
          while i < markers.length
            markers[i].setMap null
            i++
          marker = new (google.maps.Marker)(
            position: event.latLng
            map: self.maps[0].map
            draggable: false)
          self.setGMapSelectSetLatLong event.latLng, self
          markers.push marker
          #marker.addListener 'dragend', self.setGMapSelectSetLatLong(event, self)
          return
        return

      setGMapSelectSetLatLong: (val,self) ->
        valX = val.toString()
        ValRpc = valX.replace('(', '')
        ValRpc = ValRpc.replace(')', '')
        self.latLng = ValRpc
        return

      setGMapSelectMarkerEndDrag: (event, self) ->
        this.setGMapSelectSetLatLong event, self
        return
    }
    create: ->


    mounted: ->
      $ctrl = @;
      setTimeout ( ->
        console.log '--> init Doctor branches'
        #$( "#addNewBranch" ).trigger( "click" );
        $ctrl.initialGoogleMap();
        $ctrl.intial()
        #$('.time12').inputmask('hh:mm t', { placeholder: '__:__ _m', alias: 'time12', hourFormat: '12' });
        #$('.time24').inputmask('hh:mm', { placeholder: '__:__ _m', alias: 'time24', hourFormat: '24' });
      ), 100
  });

vueDoctorBranchesApp();


