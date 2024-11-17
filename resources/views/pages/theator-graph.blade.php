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
    <div class="col-lg-12" id="customerList">
        <livewire:viewtheatorgraph />
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
<script>
    function normalizeData(data, maxColumns = 8) {
        const grouped = data.reduce((acc, item) => {
            if (!acc[item.label]) acc[item.label] = [];
            acc[item.label].push(Number(item.value));
            return acc;
        }, {});
        const normalized = Object.entries(grouped).map(([label, values]) => {
            const row = Array(maxColumns).fill(0); // Fill an array with zeros
            values.slice(0, maxColumns).forEach((value, index) => {
                row[(value-1)] = value; // Replace with actual values up to maxColumns
            });
            return { label, values: row }; // Return label with its normalized values
        });
        return normalized;
    }

    const transformedData = ($maxnumber) => {
        const result = {};
        ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'].forEach(alpha => {
            result[alpha] = Array($maxnumber).fill(0);
        })
        return result;
    };

    var options = {
        series: [],
        chart: {
            // height: 350,
            type: 'heatmap',
            toolbar: {
                show: false
            }
        },  
        plotOptions: {
            heatmap: {
                distributed: true,
                shadeIntensity: 0.5,
                radius: 0,
                useFillColorAsStroke: true,
                colorScale: {
                    ranges: [
                        { from: -100, to: 0 , color: '#f3f3f9', name: 'Available' },
                        { from: 1, to: 100 , color: '#00A100', name: 'Booked' },
                    ]
                }
            }
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            width: 2
        },
        legend: {
            show: false,
        }
    };

    var theatorChart = new ApexCharts(document.querySelector("#theators_heatmap"), options);
    theatorChart.render();

    Livewire.on('graphDataUpdated', ( response ) => {
        if(response && response.length){
            let responseData = response.shift();
            let result = normalizeData(responseData.data,responseData.maxColumn);
            $noOfValues = transformedData(responseData.maxColumn);
            result.forEach(item => {
                $noOfValues[item.label] = item.values;
            });

            let apiSeries = Object.keys($noOfValues).map(label => ({
                name: label,
                data: $noOfValues[label]
            }));

            setTimeout(() => {
                theatorChart.updateSeries(apiSeries);
                theatorChart.updateOptions({
                    xaxis: {
                        categories: Array.from({ length: responseData.maxColumn }, (_, i) => `${i + 1}`)
                    }
                });
                if(responseData.screenData){
                    $('input[id^="screen"][value="'+responseData.screenData.cloud_screen_id+'"]').prop('checked',true);
                }
            },5);
        }
    });
</script>
@endsection