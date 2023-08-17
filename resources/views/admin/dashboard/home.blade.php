@extends('admin.layout')

@section('content')

<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card  card-stats" title="Last Entry" >
          <div class="card-header card-header-success card-header-icon">
            <div class="card-icon">
              <i class="material-icons">perm_contact_calendar</i>
            </div>
            <a href="{{route('admin.doctor.index')}}" class="card-category">Doctors</a>
          </div>
          <div class="card-footer" title="{{$doctors_last_date}}">
            <div class="stats">
              <i class="material-icons">date_range</i> 
              <h3 class="card-title">{{$doctors_count}}</h3>
            </div>
          </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card  card-stats" title="Last Entry">
          <div class="card-header card-header-primary card-header-icon">
            <div class="card-icon">
              <i class="material-icons">theaters</i>
            </div>
            <a href="{{route('admin.doctor.index')}}" class="card-category">Branches</a>
          </div>
          <div class="card-footer" title="{{$doctor_branches_last_date}}">
            <div class="stats">
              <i class="material-icons">date_range</i> 
              <h3 class="card-title">{{$doctor_branches_count}}</h3>
            </div>
          </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card  card-stats" title="Last Entry">
          <div class="card-header card-header-warning card-header-icon">
            <div class="card-icon">
              <i class="material-icons">local_pharmacy</i>
            </div>
            <a href="{{route('admin.pharmacy.index')}}" class="card-category">Pharmacies</a>
          </div>
          <div class="card-footer" title=" {{$pharmacy_last_date}}">
            <div class="stats">
              <i class="material-icons">date_range</i>
              <h3 class="card-title">{{$pharmacy_count}}</h3>
            </div>
          </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card  card-stats" title="Last Entry">
          <div class="card-header card-header-default card-header-icon">
            <div class="card-icon">
              <i class="material-icons">label</i>
            </div>
            <a href="{{route('admin.lab.index')}}" class="card-category">labs</a>
          </div>
          <div class="card-footer" title="{{$lab_last_date}}">
            <div class="stats">
              <i class="material-icons">date_range</i> 
              <h3 class="card-title">{{$lab}}</h3>
            </div>
          </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card  card-stats" title="Last Entry">
          <div class="card-header card-header-danger card-header-icon">
            <div class="card-icon">
              <i class="material-icons">medical_services</i>
            </div>
            <a href="{{route('admin.insurance_company.index')}}" class="card-category">Insurance Co.</a>
          </div>
          <div class="card-footer" title="{{$insurance_company_last_date}}">
            <div class="stats">
              <i class="material-icons">date_range</i> 
              <h3 class="card-title">{{$insurance_company_count}}</h3>
            </div>
          </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card  card-stats" title="Last Entry">
          <div class="card-header card-header-rose card-header-icon">
            <div class="card-icon">
              <i class="material-icons">local_hospital</i>
            </div>
            <a href="{{route('admin.hospital.index')}}" class="card-category">Hospitals</a>
          </div>
          <div class="card-footer" title="{{$hospital_last_date}}">
            <div class="stats">
              <i class="material-icons">date_range</i> 
              <h3 class="card-title">{{$hospital_count}}</h3>
            </div>
          </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card  card-stats" title="Last Entry">
          <div class="card-header card-header-info card-header-icon">
            <div class="card-icon">
              <i class="material-icons">business_center</i>
            </div>
            <a href="{{route('admin.center.index')}}" class="card-category">Centers</a>
          </div>
          <div class="card-footer" title="{{$center_last_date}}">
            <div class="stats">
              <i class="material-icons">date_range</i> 
              <h3 class="card-title">{{$center_count}}</h3>
            </div>
          </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card  card-stats" title="Last Entry">
          <div class="card-header card-header-primary card-header-icon">
            <div class="card-icon">
              <i class="material-icons">vaccines</i>
            </div>
            <a href="{{route('admin.medicine.index')}}" class="card-category">Medicines</a>
          </div>
          <div class="card-footer" title="{{$medicine_last_date}}">
            <div class="stats">
              <i class="material-icons">date_range</i> 
              <h3 class="card-title">{{$medicine_count}}</h3>
            </div>
          </div>
        </div>
    </div>

</div>

<div class="card">
  <div class="card-header card-header-primary card-header-icon">
    <div class="card-icon">
      <i class="material-icons">supervised_user_circle</i>
    </div>
    <a href="{{route('admin.user.index')}}" class="card-category">
    </a>
  </div>
  <div id="canvas-holder" style="width:40%">
      <canvas id="chart-area"></canvas>
      <h4 class="card-title">Total Users No.: ({{$user_count}})</h4>
  </div>
</div>

<script src="https://www.chartjs.org/dist/2.9.3/Chart.min.js"></script>
<script>
  import colorLib from '@kurkle/color';
import {DateTime} from 'luxon';
import 'chartjs-adapter-luxon';
import {valueOrDefault} from '../../dist/helpers.esm';

// Adapted from http://indiegamr.com/generate-repeatable-random-numbers-in-js/
var _seed = Date.now();

export function srand(seed) {
  _seed = seed;
}

export function rand(min, max) {
  min = valueOrDefault(min, 0);
  max = valueOrDefault(max, 0);
  _seed = (_seed * 9301 + 49297) % 233280;
  return min + (_seed / 233280) * (max - min);
}

export function numbers(config) {
  var cfg = config || {};
  var min = valueOrDefault(cfg.min, 0);
  var max = valueOrDefault(cfg.max, 100);
  var from = valueOrDefault(cfg.from, []);
  var count = valueOrDefault(cfg.count, 8);
  var decimals = valueOrDefault(cfg.decimals, 8);
  var continuity = valueOrDefault(cfg.continuity, 1);
  var dfactor = Math.pow(10, decimals) || 0;
  var data = [];
  var i, value;

  for (i = 0; i < count; ++i) {
    value = (from[i] || 0) + this.rand(min, max);
    if (this.rand() <= continuity) {
      data.push(Math.round(dfactor * value) / dfactor);
    } else {
      data.push(null);
    }
  }

  return data;
}

export function points(config) {
  const xs = this.numbers(config);
  const ys = this.numbers(config);
  return xs.map((x, i) => ({x, y: ys[i]}));
}

export function bubbles(config) {
  return this.points(config).map(pt => {
    pt.r = this.rand(config.rmin, config.rmax);
    return pt;
  });
}

export function labels(config) {
  var cfg = config || {};
  var min = cfg.min || 0;
  var max = cfg.max || 100;
  var count = cfg.count || 8;
  var step = (max - min) / count;
  var decimals = cfg.decimals || 8;
  var dfactor = Math.pow(10, decimals) || 0;
  var prefix = cfg.prefix || '';
  var values = [];
  var i;

  for (i = min; i < max; i += step) {
    values.push(prefix + Math.round(dfactor * i) / dfactor);
  }

  return values;
}

const MONTHS = [
  'January',
  'February',
  'March',
  'April',
  'May',
  'June',
  'July',
  'August',
  'September',
  'October',
  'November',
  'December'
];

export function months(config) {
  var cfg = config || {};
  var count = cfg.count || 12;
  var section = cfg.section;
  var values = [];
  var i, value;

  for (i = 0; i < count; ++i) {
    value = MONTHS[Math.ceil(i) % 12];
    values.push(value.substring(0, section));
  }

  return values;
}

const COLORS = [
  '#4dc9f6',
  '#f67019',
  '#f53794',
  '#537bc4',
  '#acc236',
  '#166a8f',
  '#00a950',
  '#58595b',
  '#8549ba'
];

export function color(index) {
  return COLORS[index % COLORS.length];
}

export function transparentize(value, opacity) {
  var alpha = opacity === undefined ? 0.5 : 1 - opacity;
  return colorLib(value).alpha(alpha).rgbString();
}

export const CHART_COLORS = {
  red: 'rgb(255, 99, 132)',
  orange: 'rgb(255, 159, 64)',
  yellow: 'rgb(255, 205, 86)',
  green: 'rgb(75, 192, 192)',
  blue: 'rgb(54, 162, 235)',
  purple: 'rgb(153, 102, 255)',
  grey: 'rgb(201, 203, 207)'
};

const NAMED_COLORS = [
  CHART_COLORS.red,
  CHART_COLORS.orange,
  CHART_COLORS.yellow,
  CHART_COLORS.green,
  CHART_COLORS.blue,
  CHART_COLORS.purple,
  CHART_COLORS.grey,
];

export function namedColor(index) {
  return NAMED_COLORS[index % NAMED_COLORS.length];
}

export function newDate(days) {
  return DateTime.now().plus({days}).toJSDate();
}

export function newDateString(days) {
  return DateTime.now().plus({days}).toISO();
}

export function parseISODate(str) {
  return DateTime.fromISO(str);
}
</script>
<script>
    var randomScalingFactor = function() {
        return Math.round(Math.random() * 100);
    };

    var config = {
        type: 'bar',
        data: {
            datasets: [{
                data: [
                    {{$user_normal_count}},
                    {{$user_doctor_count}},
                    {{$user_moderator_count}},
                    {{$user_admin_count}},
                ],
                backgroundColor: [
                  'rgb(54, 162, 235)',
                  'rgb(75, 192, 192)',
                  'rgb(255, 159, 64)',
                  'rgb(255, 205, 86)',
                ],
                label: 'No.'
            }],
            labels: [
                'Users',
                'Doctors',
                'Moderator',
                'Admin',
            ]
        },
        options: {
            responsive: true
        }
    };

    window.onload = function() {
        var ctx = document.getElementById('chart-area').getContext('2d');
        window.myPie = new Chart(ctx, config);
    };

    document.getElementById('randomizeData').addEventListener('click', function() {
        config.data.datasets.forEach(function(dataset) {
            dataset.data = dataset.data.map(function() {
                return randomScalingFactor();
            });
        });

        window.myPie.update();
    });

    var colorNames = Object.keys(window.chartColors);
    document.getElementById('addDataset').addEventListener('click', function() {
        var newDataset = {
            backgroundColor: [],
            data: [],
            label: 'New dataset ' + config.data.datasets.length,
        };

        for (var index = 0; index < config.data.labels.length; ++index) {
            newDataset.data.push(randomScalingFactor());

            var colorName = colorNames[index % colorNames.length];
            var newColor = window.chartColors[colorName];
            newDataset.backgroundColor.push(newColor);
        }

        config.data.datasets.push(newDataset);
        window.myPie.update();
    });

    document.getElementById('removeDataset').addEventListener('click', function() {
        config.data.datasets.splice(0, 1);
        window.myPie.update();
    });
</script>
@stop
