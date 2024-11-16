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
@endsection
@push('scripts')
<script>
    document.addEventListener('graphDataUpdated', (event) => {
        console.log('Inline listener:', event.detail);
    });
</script>


@endpush