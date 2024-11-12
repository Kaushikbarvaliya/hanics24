@extends('layouts.master')
@section('title')
@lang('translation.customers')
@endsection
@section('css')
<link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('build/css/dataTables.min.css') }}" rel="stylesheet" type="text/css" />

@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1')
Dashboard
@endslot
@slot('li_2')
Theators
@endslot
@slot('li_2_link')
{{route('theator.list')}}
@endslot
@slot('title')
Graph
@endslot
@endcomponent
<div class="row">
    <div class="col-lg-12">
        <div class="card" id="customerList">
            <div class="card-body">
                <livewire:viewtheatorgraph />
            </div>
        </div>
    </div>
    <!--end col-->
</div>
<!--end row-->
@endsection
@section('script')
<script src="{{ URL::asset('build/libs/list.js/list.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/list.pagination.js/list.pagination.min.js') }}"></script>

<!--ecommerce-customer init js -->
<script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<script>
  const apiToken = '<?=session('api_token');?>';
  const apiClientToken = '<?=session('client_token');?>';
  const apiUrl = '<?=env('API_BASE_URL');?>';
</script>
<script src="{{ URL::asset('build/js/jquery-3.7.1.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ URL::asset('build/js/pages/apexcharts-heatmap.init.js') }}"></script>
<script>
    //  document.addEventListener('livewire:load', function () {
            Livewire.on('graphDataUpdated', (data) => {
                console.log(data)
                // Update the labels and data in the chart
                // chart.data.labels = data.labels;
                // chart.data.datasets[0].data = data.values;
                // chart.update(); // Re-render the chart with new data
            });
    // })

    // function getChartColorsArray(chartId) {
    //     if (document.getElementById(chartId) !== null) {
    //         var colors = document.getElementById(chartId).getAttribute("data-colors");
    //         if (colors) {
    //             colors = JSON.parse(colors);
    //             return colors.map(function(value) {
    //                 var newValue = value.replace(" ", "");
    //                 if (newValue.indexOf(",") === -1) {
    //                     var color = getComputedStyle(document.documentElement).getPropertyValue(newValue);
    //                     if (color) return color;
    //                     else return newValue;;
    //                 } else {
    //                     var val = value.split(',');
    //                     if (val.length == 2) {
    //                         var rgbaColor = getComputedStyle(document.documentElement).getPropertyValue(val[0]);
    //                         rgbaColor = "rgba(" + rgbaColor + "," + val[1] + ")";
    //                         return rgbaColor;
    //                     } else {
    //                         return newValue;
    //                     }
    //                 }
    //             });
    //         }
    //     }
    // }

    // // Basic Heatmap Charts
    // var chartHeatMapBasicColors = getChartColorsArray("basic_heatmap");
    // if (chartHeatMapBasicColors) {
    //     var options = {
    //         series: [{
    //                 name: 'Metric1',
    //                 data: generateData(18, {
    //                     min: 0,
    //                     max: 90
    //                 })
    //             },
    //             {
    //                 name: 'Metric2',
    //                 data: generateData(18, {
    //                     min: 0,
    //                     max: 90
    //                 })
    //             },
    //             {
    //                 name: 'Metric3',
    //                 data: generateData(18, {
    //                     min: 0,
    //                     max: 90
    //                 })
    //             },
    //             {
    //                 name: 'Metric4',
    //                 data: generateData(18, {
    //                     min: 0,
    //                     max: 90
    //                 })
    //             },
    //             {
    //                 name: 'Metric5',
    //                 data: generateData(18, {
    //                     min: 0,
    //                     max: 90
    //                 })
    //             },
    //             {
    //                 name: 'Metric6',
    //                 data: generateData(18, {
    //                     min: 0,
    //                     max: 90
    //                 })
    //             },
    //             {
    //                 name: 'Metric7',
    //                 data: generateData(18, {
    //                     min: 0,
    //                     max: 90
    //                 })
    //             },
    //             {
    //                 name: 'Metric8',
    //                 data: generateData(18, {
    //                     min: 0,
    //                     max: 90
    //                 })
    //             },
    //             {
    //                 name: 'Metric9',
    //                 data: generateData(18, {
    //                     min: 0,
    //                     max: 90
    //                 })
    //             }
    //         ],
    //         chart: {
    //             height: 450,
    //             type: 'heatmap',
    //             toolbar: {
    //                 show: false
    //             }
    //         },
    //         dataLabels: {
    //             enabled: false
    //         },
    //         colors: [chartHeatMapBasicColors[0]],
    //         title: {
    //             text: 'HeatMap Chart (Single color)',
    //             style: {
    //                 fontWeight: 500,
    //             },
    //         },
    //         stroke: {
    //             colors: [chartHeatMapBasicColors[1]]
    //         }
    //     };

    //     var chart = new ApexCharts(document.querySelector("#basic_heatmap"), options);
    //     chart.render();
    // }

    // function generateData(count, yrange) {
    //     var i = 0;
    //     var series = [];
    //     while (i < count) {
    //         var x = (i + 1).toString();
    //         var y = Math.floor(Math.random() * (yrange.max - yrange.min + 1)) + yrange.min;

    //         series.push({
    //             x: x,
    //             y: y
    //         });
    //         i++;
    //     }
    //     return series;
    // }

</script>
@endsection
