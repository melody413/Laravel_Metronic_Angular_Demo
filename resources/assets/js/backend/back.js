


setGMapSelectSetLatLong = function(val){
  valX = val.toString();
  ValRpc = valX.replace("(", "");
  ValRpc = ValRpc.replace(")", "");

  $('#GMapSelectLatLng').val(ValRpc);
};

setGMapSelectMarkerEndDrag = function(event){
  setGMapSelectSetLatLong(event.latLng.lat() + ', ' + event.latLng.lng());
};

GMapMarkerChangeOnClick = function(){
  var markers = [];
  markers.push(maps[0].markers[0]);
  maps[0].markers[0].addListener('dragend', setGMapSelectMarkerEndDrag);

  google.maps.event.addListener(maps[0].map, 'click', function(event) {

    for (var i = 0; i < markers.length; i++) {
      markers[i].setMap(null);
    }
    var marker = new google.maps.Marker({
      position: event.latLng,
      map: maps[0].map,
      draggable: true
    });
    setGMapSelectSetLatLong(event.latLng);
    markers.push(marker);
    marker.addListener('dragend', setGMapSelectMarkerEndDrag);
  });
};

parentParseTranslate = function(transInputs){

  for (const [key, value] of Object.entries(transInputs)) {
    for (const [keyI, valueI] of Object.entries(value)) {
      inputName = value.locale + '[' + keyI + ']';
      tinyMcName = tinymce.get(inputName);
      $('[name="' + inputName +'"]').val(valueI);

      if(tinyMcName !== null)
        tinyMcName.setContent(valueI);
    }
  }
};

parentGetAjaxData = function(e){
  var ele = $(e.currentTarget);

  if(ele.val() < 1 || appVars.route.action == 'edit')
    return;

  bsOptions = '';
  url = appVars.site_url + '/' + ele.attr('data-from') + ele.val();

  $.get(url, function(data){
    for (const [key, value] of Object.entries(data)) {

      if(key == 'translations')
        parentParseTranslate(value);

    }
  });
};

bsChangeCountry = function() {
  var ele = $('#bsCountryId');
  var url = appVars.site_url  +'/data/cities/' + ele.val();
  var selectedVal = $('#bsCityies').attr('data-val');
  var pushTo = $('#bsCityies');
  var pushToPlus = $('#branchBsCityies');
  var bsOptions = '';

  $.get(url, function(data){
    for (const [key, value] of Object.entries(data)) {

      selected = '';
      if( key == parseInt(selectedVal) )
        selected = 'selected="selected"';

      bsOptions += '<option value="'+ key +'" '+ selected +' >'+ value +'</option>';
    }
    $(pushTo).html('');
    $(pushTo).html(bsOptions).selectpicker('refresh');

    if(pushToPlus.length)
    {
      $(pushToPlus).html('');
      $(pushToPlus).html(bsOptions).selectpicker('refresh');
    }

    bsChangeCity();
  });
};

bsChangeCity = function(){
  var ele = $('#bsCityies');
  var url = appVars.site_url + '/data/areas/' + ele.val();
  var selectedVal = $('#bsCityies').attr('data-val');
  var selectedValArea = $('#bsAreas').attr('data-val');
  var pushTo = $('#bsAreas');
  var pushToPlus = $('#branchBsAreas');
  var bsOptions = '';

  $.get(url, function(data){
    for (const [key, value] of Object.entries(data)) {
      selected = '';

      if( key == parseInt(selectedValArea) )
        selected = 'selected="selected"';

      bsOptions += '<option value="'+ key +'" '+ selected +' >'+ value +'</option>';
    }
    $(pushTo).html('');
    $(pushTo).html(bsOptions).selectpicker('refresh');

    if(pushToPlus.length)
    {
      $(pushToPlus).html('');
      $(pushToPlus).html(bsOptions).selectpicker('refresh');
    }
  });
};

branchBsChangeCity = function(){
  var ele = $('#branchBsCityies');
  var url = appVars.site_url + '/data/areas/' + ele.val();
  var selectedVal = $('#branchBsCityies').attr('data-val');
  var pushTo = $('#branchBsAreas');
  var bsOptions = '';

  $.get(url, function(data){
    for (const [key, value] of Object.entries(data)) {
      selected = '';
      if( key == parseInt(selectedVal) )
        selected = 'selected="selected"';

      bsOptions += '<option value="'+ key +'" '+ selected +' >'+ value +'</option>';
    }
    $(pushTo).html('');
    $(pushTo).html(bsOptions).selectpicker('refresh');
  });
};

bsHandleArea = function(){

};

selectActive = function(){
  // toggled
  url = window.location.href;
  if ( url.substring(22,30) == appVars.admin_prefix )
  {
    sidebarDashboardHome = $('.sidebar_dashboardHome');
    sidebarDashboardHome.find('a').addClass('toggled');
    sidebarDashboardHome.find('.ml-menu').css('display', 'block');
    return;
  }

  $('.ml-menu').removeClass('displayBlock');
  $('.sidebarMenuItems').each(function(){
    parentMenu = $(this);
    if(parentMenu.hasClass('sidebar_dashboardHome'))
      return;
    subMenu = $(this).find('.ml-menu').find('li');
    subMenu.each(function(){
      childMenu = $(this);
      hrfx = $(this).find('a');

      if (url.search(hrfx.attr('href')) != -1 && hrfx.attr('href') != '/admin/')
      {
        parentMenu.find('a').addClass('toggled');
        parentMenu.find('.ml-menu').css('display', 'block');
      }
    })
  });
};

hospitalInputTags = function(){
  var inputTag = '#tagsinputHospital';
  var source = '/data/getHospitals';
  var inputHidden = 'hospital_ids';

  if( $(inputTag).length < 0 )
    return;

  var tagApi = $(inputTag).tagsManager({onlyTagList: true});

  jQuery(inputTag).typeahead({
    minLength: 2,
    name: 'tags',
    delay: 100,
    displayKey: 'name',
    changeInputOnSelect: true,
    source: function (query, process) {
      return $.get(appVars.admin_url + source, { query: query }, function (data) {
        tagApi.tagsManager({
          onlyTagList: true,
          tagList: data
        });
        return process(data);
      });
    },
    afterSelect :function (item){
      if (item)
      {
        tagApi.tagsManager("pushTag", {
          tag: item.name,
          hidden: '<input type="hidden" name="'+ inputHidden +'[]" value="'+ item.id +'" />'
        });
      }
    },
    highlighter: function (name,item) {
      return ('<div>' + item.name + '</div>');
    }
  });


  if ($(inputTag).length > 0 && $(inputTag).attr('data-av-tags') != 'undefined' && $(inputTag).attr('data-av-tags').length > 0)
  {
    let avTags = JSON.parse($(inputTag).attr('data-av-tags'));
    Object.keys(avTags).map(function(key, index) {
      tagApi.tagsManager("pushTag", {
        tag: avTags[key],
        hidden: '<input type="hidden" name="'+ inputHidden +'[]" value="'+ key +'" />'
      });
    });
  }
};

centerInputTags = function(){
  var inputTag = '#tagsinputCenter';
  var source = '/data/getCenters';
  var inputHidden = 'center_ids';

  if( $(inputTag).length < 0 )
    return;

  var tagApi = $(inputTag).tagsManager({onlyTagList: true});

  jQuery(inputTag).typeahead({
    minLength: 2,
    name: 'tags',
    delay: 100,
    displayKey: 'name',
    changeInputOnSelect: true,
    source: function (query, process) {
      return $.get(appVars.admin_url + source, { query: query }, function (data) {
        tagApi.tagsManager({
          onlyTagList: true,
          tagList: data
        });
        return process(data);
      });
    },
    afterSelect :function (item){
      if (item)
      {
        tagApi.tagsManager("pushTag", {
          tag: item.name,
          hidden: '<input type="hidden" name="'+ inputHidden +'[]" value="'+ item.id +'" />'
        });
      }
    },
    highlighter: function (name,item) {
      return ('<div>' + item.name + '</div>');
    }
  });


  if ($(inputTag).length > 0 && $(inputTag).attr('data-av-tags') != 'undefined' && $(inputTag).attr('data-av-tags').length > 0)
  {
    let avTags = JSON.parse($(inputTag).attr('data-av-tags'));
    Object.keys(avTags).map(function(key, index) {
      tagApi.tagsManager("pushTag", {
        tag: avTags[key],
        hidden: '<input type="hidden" name="'+ inputHidden +'[]" value="'+ key +'" />'
      });
    });
  }
};
insuranceCompanyInputTags = function(){
  var inputTag = '#tagsinputInsuranceCompany';
  var source = '/data/getInsuranceCompanies';
  var inputHidden = 'insurance_company_ids';

  if( $(inputTag).length < 0 )
    return;

  var tagApi = $(inputTag).tagsManager({onlyTagList: true});

  jQuery(inputTag).typeahead({
    minLength: 2,
    name: 'tags',
    delay: 100,
    displayKey: 'name',
    changeInputOnSelect: true,
    source: function (query, process) {
      return $.get(appVars.admin_url + source, { query: query }, function (data) {
        tagApi.tagsManager({
          onlyTagList: true,
          tagList: data
        });
        return process(data);
      });
    },
    afterSelect :function (item){
      if (item)
      {
        tagApi.tagsManager("pushTag", {
          tag: item.name,
          hidden: '<input type="hidden" name="'+ inputHidden +'[]" value="'+ item.id +'" />'
        });
      }
    },
    highlighter: function (name,item) {
      return ('<div>' + item.name + '</div>');
    }
  });

  if ($(inputTag).length > 0 && $(inputTag).attr('data-av-tags') != 'undefined' && $(inputTag).attr('data-av-tags').length > 0)
  {
    let avTags = JSON.parse($(inputTag).attr('data-av-tags'));
    Object.keys(avTags).map(function(key, index) {
      tagApi.tagsManager("pushTag", {
        tag: avTags[key],
        hidden: '<input type="hidden" name="'+ inputHidden +'[]" value="'+ key +'" />'
      });
    });
  }
};

tagsInput = function(){

  var inputTag = '#tagsInput';
  var source = $(inputTag).attr('data-url');
  var inputHidden = $(inputTag).attr('data-input-hidden');
  var displayKey = $(inputTag).attr('data-display-key');
  var maxTags = $(inputTag).attr('data-max-tags');

  if( $(inputTag).length < 0 )
    return;

  var tagApi = $(inputTag).tagsManager({onlyTagList: true});

  jQuery(inputTag).typeahead({
    minLength: 2,
    name: 'tags',
    delay: 100,

    displayKey: displayKey,
    changeInputOnSelect: true,
    source: function (query, process) {
      return $.get(appVars.admin_url + source, { query: query }, function (data) {
        tagApi.tagsManager({
          onlyTagList: true,
          tagList: data
        });
        return process(data);
      });
    },
    afterSelect :function (item){
      if (item)
      {
        tagApi.tagsManager("pushTag", {
          tag: item[displayKey],
          maxTags: parseInt(maxTags),
          hidden: '<input type="hidden" name="'+ inputHidden +'[]" value="'+ item.id +'" />'
        });
      }
    },
    highlighter: function (name,item) {
      return ('<div>' + item[displayKey] + '</div>');
    }
  });

  if ($(inputTag).length > 0 && $(inputTag).attr('data-av-tags') != 'undefined' && $(inputTag).attr('data-av-tags').length > 0)
  {
    let avTags = JSON.parse($(inputTag).attr('data-av-tags'));
    Object.keys(avTags).map(function(key, index) {
      console.log ('-->',tagApi.tagsManager );
      tagApi.tagsManager("pushTag", {
        tag: avTags[key],
        maxTags: parseInt(maxTags),
        hidden: '<input type="hidden" name="'+ inputHidden +'[]" value="'+ key +'" />'
      });
    });
  }
};

dropZoneUploadsHandlers = function(){

  Dropzone.autoDiscover = false;

  const uploadEleId = "#id_dropzone";
  const upPath = $(uploadEleId).attr('data-path');
  const upFullPath = '/uploads/' + upPath + '/';
  var fileList = new Array;
  var ivar = 0;

  $(uploadEleId).dropzone({
    maxFiles: 2000,
    parallelUploads: 10,
    addRemoveLinks: true,
    dictRemoveFile: 'Remove file',
    uploadMultiple: false,
    acceptedFiles: '.jpg,.jpeg,.JPEG,.JPG,.png,.PNG',
    url: appVars.admin_url + "/data/uploadImages",
    params: {path: upPath, "_token": $('[name="_token"]').val()},
    success: function (file, response) {

      if(!response)
        response = file.name;

      fileList[file.name] = {"serverFileName" : response, "name" : file.name, "fileId" : ivar };

      let FileId =  response.split('.');
      file.name = response;
      $(uploadEleId).append('<input type="hidden" name="'+ $(uploadEleId).attr('data-input') +'[]" value="'+ fileList[file.name]['serverFileName'] +'" id="'+ FileId[0] +'">');

      ivar++;
      $('#image_gallery_count').val(ivar);
    },
    init: function () {
      var myDrzone = this;

      $(uploadEleId).append('<input type="hidden" name="image_gallery_count" value="" id="image_gallery_count">');

      this.on("removedfile", function (file) {
        let FileId =  fileList[file.name]['serverFileName'].split('.');
        $('#' + FileId).remove();
        delete fileList[file.name];

        ivar--;
        $('#image_gallery_count').val(ivar);
      });

      imgs1 = $(uploadEleId).attr('data-imgs');

      try {
        imgsP = JSON.parse(imgs1);
      } catch (e) {
        imgsP = [];
      }

      for (var i = 0; i < imgsP.length; i++) {
        var mockFile = {
          url:  upFullPath + imgsP[i],
          size: '4000',
          name: imgsP[i]
        };

        myDrzone.emit("addedfile", mockFile); //here I get the error
        myDrzone.emit("thumbnail", mockFile, upFullPath + imgsP[i]);
        myDrzone.emit("success", mockFile); // with complete fails to hide the 2buttons

        var existingFileCount = 1; // The number of files already uploaded
        myDrzone.options.maxFiles = myDrzone.options.maxFiles - existingFileCount;
      }
    },
  });
};

branchesPrepareToSave = function(){

};

$( document ).ready(function() {
  console.log( "ready!" );

  selectActive();
  hospitalInputTags();
  centerInputTags();
  insuranceCompanyInputTags();
  tagsInput();
  dropZoneUploadsHandlers();

  $(document).on("changed.bs.select","select#bsCountryId" ,function(e){ bsChangeCountry() });
  $(document).on("changed.bs.select","select#bsCityies" ,function(e){ bsChangeCity() });
  $(document).on("changed.bs.select","select#branchBsCityies" ,function(e){ branchBsChangeCity() });

  $('select#bsCountryId').trigger('changed.bs.select');

  $(document).on("changed.bs.select","select.parentGetAjaxData" ,function(e){ parentGetAjaxData(e) });

  $('.datepicker').datepicker({format: 'yyyy-mm-dd'});


});
