<div class="row">
    <div class="col-lg-12">

        <!--begin::Card-->

        <div class="card card-custom gutter-b">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">{{__('Column Chart')}}</h3>
                </div>
            </div>
            <div class="card-body">
                <!--begin::Chart-->
                <div id="chart_3"></div>
                <!--end::Chart-->
            </div>
        </div>
        <!--end::Card-->
    </div>

</div>

@section('scripts')
{{-- <script src="{{asset('js/pages/features/charts/apexcharts.js')}}"></script> --}}
{{-- <script src="{{asset('plugins/custom/kanban/kanban.bundle.js')}}"></script> --}}
<script>
"use strict";

// Shared Colors Definition
const primary = '#6993FF';
const success = '#1BC5BD';
const info = '#8950FC';
const warning = '#FFA800';
const danger = '#F64E60';

// Class definition
function generateBubbleData(baseval, count, yrange) {
    var i = 0;
    var series = [];
    while (i < count) {
      var x = Math.floor(Math.random() * (750 - 1 + 1)) + 1;;
      var y = Math.floor(Math.random() * (yrange.max - yrange.min + 1)) + yrange.min;
      var z = Math.floor(Math.random() * (75 - 15 + 1)) + 15;

      series.push([x, y, z]);
      baseval += 86400000;
      i++;
    }
    return series;
  }

function generateData(count, yrange) {
    var i = 0;
    var series = [];
    while (i < count) {
        var x = 'w' + (i + 1).toString();
        var y = Math.floor(Math.random() * (yrange.max - yrange.min + 1)) + yrange.min;

        series.push({
            x: x,
            y: y
        });
        i++;
    }
    return series;
}

var KTApexChartsDemo = function () {
	// Private functions


	var _demo3 = function () {
		const apexChart = "#chart_3";
		var options = {
			series: [{
				name: 'Job Requests',
				data: {{$JobChart}}
			}, {
				name: 'Tender Requests',
				data: {{$TenderChart}}
			}, {
				name: 'Worker Count',
				data: {{$WorkerChart}}
			}],
			chart: {
				type: 'bar',
				height: 350
			},
			plotOptions: {
				bar: {
					horizontal: false,
					columnWidth: '55%',
					endingShape: 'rounded'
				},
			},
			dataLabels: {
				enabled: false
			},
			stroke: {
				show: true,
				width: 2,
				colors: ['transparent']
			},
			xaxis: {
				categories: ['SAT', 'SUN', 'MON', 'May', 'TUS', 'WEN', 'THU', 'FRI'],
			},
			yaxis: {
				title: {
					text: '$ (Unit Measurement)'
				}
			},
			fill: {
				opacity: 1
			},
			// tooltip: {
			// 	y: {
			// 		formatter: function (val) {
			// 			return "$ " + val + " thousands"
			// 		}
			// 	}
			// },
			colors: [primary, success, warning]
		};

		var chart = new ApexCharts(document.querySelector(apexChart), options);
		chart.render();
	}
    var _demo11 = function () {
		const apexChart = "#chart_11";
		var options = {
			series: [44, 55, 41, 17, 15],
			chart: {
				width: 380,
				type: 'donut',
			},
			responsive: [{
				breakpoint: 480,
				options: {
					chart: {
						width: 200
					},
					legend: {
						position: 'bottom'
					}
				}
			}],
			colors: [primary, success, warning, danger, info]
		};

		var chart = new ApexCharts(document.querySelector(apexChart), options);
		chart.render();
	}

	return {
		// public functions
		init: function () {

			_demo3();
			 _demo11();
		}
	};
}();

jQuery(document).ready(function () {
	KTApexChartsDemo.init();
});

    </script>
@endsection
