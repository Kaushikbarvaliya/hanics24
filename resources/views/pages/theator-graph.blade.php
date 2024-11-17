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
@endsection
@push('scripts')
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

    const inputData = [
        { label: 'A', value: '2'},
        { label: 'A', value: '8'},
        { label: 'A', value: '5'},
        { label: 'B', value: '6' },
        { label: 'C', value: '2' },
        { label: 'C', value: '7' },
        { label: 'D', value: '8' },
        { label: 'E', value: '4' },
        { label: 'F', value: '3' }
    ];

    const result = normalizeData(inputData);

    const transformedData = {};
    ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'].forEach(alpha => {
        transformedData[alpha] = [];
    })
    result.forEach(item => {
        transformedData[item.label] = item.values;
    });
    const series = Object.keys(transformedData).map(label => ({
        name: label,
        data: transformedData[label]
    }));

    var options = {
        series: series,
        chart: {
            // height: 350,
            type: 'heatmap',
            toolbar: {
                show: true
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
                        { from: -100, to: 0 , color: '#128FD9', name: 'NUN' },
                        { from: 1, to: 100 , color: '#00A100', name: 'Booked' },
                    ]
                }
            }
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            width: 1
        },
        title: {
            text: 'HeatMap Chart with Color Range',
            style: {
                fontWeight: 500,
            },
        },
    };

    var theatorChart = new ApexCharts(document.querySelector("#color_heatmap"), options);
    theatorChart.render();

    console.log('sdds')

    Livewire.on('graphDataUpdated', ( response ) => {
        if(response && response.length){
            let responseData = response.shift();
            console.log(responseData.data)
            let result = normalizeData(responseData.data,responseData.maxColumn);
            result.forEach(item => {
                transformedData[item.label] = item.values;
            });

            let apiSeries = Object.keys(transformedData).map(label => ({
                name: label,
                data: transformedData[label]
            }));

            setTimeout(() => {
                theatorChart.updateSeries(apiSeries);
                theatorChart.updateOptions({
                    xaxis: {
                        categories: Array.from({ length: responseData.maxColumn }, (_, i) => `${i + 1}`)
                    }
                });
            }, 1000);
        }
    });
</script>


@endpush