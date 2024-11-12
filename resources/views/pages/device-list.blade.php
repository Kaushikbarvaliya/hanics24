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
@slot('title')
Devices
@endslot
@endcomponent
<div class="row">
    <div class="col-lg-12">
        <div class="card" id="customerList">
            <div class="card-header border-bottom-dashed">

                <div class="row g-4 align-items-center">
                    <div class="col-sm">
                        <div>
                            <h5 class="card-title mb-0">Device Listing</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive table-card mb-1">
                    <table class="table align-middle table-nowrap table-striped-columns table-order" id="deviceList_dataTable" width="100%" cellspacing="0">
                        <thead class="table-light text-muted">
                            <tr>
                                <th>No.</th>
                                <th>Device Name</th>
                                <th>Serial NO.</th>
                                <th>Device Status</th>
                                <th>Device Type</th>
                                <th>Site Name</th>
                                <th>Theater Name</th>
                                <th>Device Created</th>
                            </tr>
                        </thead>
                        <tbody class="list form-check-all">
                        </tbody>
                    </table>
                    
                    <div class="noresult" style="display: none">
                        <div class="text-center">
                            <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px">
                            </lord-icon>
                            <h5 class="mt-2">Sorry! No Result Found</h5>
                            <p class="text-muted mb-0">We've searched more than 150+ customer We
                                did not find any
                                customer for you search.</p>
                        </div>
                    </div>
                </div>
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
<script src="{{ URL::asset('build/js/dataTables.min.js') }}"></script>
<script src="{{ URL::asset('build/js/pages/devicelist.js') }}"></script>
@endsection
