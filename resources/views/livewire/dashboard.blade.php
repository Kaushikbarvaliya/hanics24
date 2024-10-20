<div class="row">
    <div class="col-xl-3 col-md-6">
        <!-- card -->
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1 overflow-hidden">
                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Device alerts</p>
                    </div>
                </div>
                <div class="d-flex align-items-end justify-content-between mt-4">
                    <div>
                        <!-- Loader while loading data for device alerts -->
                        <p wire:loading wire:target="totalDataCount" class="loader">Loading...</p>
                        <!-- Display data when loaded -->
                        <h4 wire:loading.remove wire:target="totalDataCount" class="fs-22 fw-semibold ff-secondary mb-4">
                            @if(!empty($totalDataCount) && $totalDataCount['device_alerts'] != "")
                                <span class="counter-value" data-target="{{$totalDataCount['device_alerts']}}">0</span>
                            @else
                                <span>N/A</span>
                            @endif
                        </h4>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-success-subtle rounded fs-3">
                            <i class="bx ri-notification-3-fill text-success"></i>
                        </span>
                    </div>
                </div>
            </div><!-- end card body -->
        </div><!-- end card -->
    </div><!-- end col -->

    <div class="col-xl-3 col-md-6">
        <!-- card -->
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1 overflow-hidden">
                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Devices</p>
                    </div>
                </div>
                <div class="d-flex align-items-end justify-content-between mt-4">
                    <div>
                        <!-- Loader while loading data for device alerts -->
                        <p wire:loading wire:target="totalDataCount" class="loader">Loading...</p>
                        <!-- Display data when loaded -->
                        <h4 wire:loading.remove wire:target="totalDataCount" class="fs-22 fw-semibold ff-secondary mb-4">
                            @if(!empty($totalDataCount) && $totalDataCount['device_alerts'] != "")
                                <span class="counter-value" data-target="{{$totalDataCount['device_alerts']}}">0</span>
                            @else
                                <span>N/A</span>
                            @endif
                        </h4>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-info-subtle rounded fs-3">
                            <i class="bx bx-mobile-alt text-info"></i>
                        </span>
                    </div>
                </div>
            </div><!-- end card body -->
        </div><!-- end card -->
    </div><!-- end col -->

    <div class="col-xl-3 col-md-6">
        <!-- card -->
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1 overflow-hidden">
                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Locations</p>
                    </div>
                </div>
                <div class="d-flex align-items-end justify-content-between mt-4">
                    <div>
                        <!-- Loader while loading data for device alerts -->
                        <p wire:loading wire:target="fetchDashboardData" class="loader">Loading...</p>
                        <!-- Display data when loaded -->
                        <h4 wire:loading.remove wire:target="totalDataCount" class="fs-22 fw-semibold ff-secondary mb-4">
                            @if(!empty($totalDataCount) && $totalDataCount['device_alerts'] != "")
                                <span class="counter-value" data-target="{{$totalDataCount['device_alerts']}}">0</span>
                            @else
                                <span>N/A</span>
                            @endif
                        </h4>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-warning-subtle rounded fs-3">
                            <i class="bx bx-location-plus text-warning"></i>
                        </span>
                    </div>
                </div>
            </div><!-- end card body -->
        </div><!-- end card -->
    </div><!-- end col -->

    <div class="col-xl-3 col-md-6">
        <!-- card -->
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1 overflow-hidden">
                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Theaters</p>
                    </div>
                </div>
                <div class="d-flex align-items-end justify-content-between mt-4">
                    <div>
                        <!-- Loader while loading data for device alerts -->
                        <p wire:loading wire:target="totalDataCount" class="loader">Loading...</p>
                        <!-- Display data when loaded -->
                        <h4 wire:loading.remove wire:target="totalDataCount" class="fs-22 fw-semibold ff-secondary mb-4">
                            @if(!empty($totalDataCount) && $totalDataCount['device_alerts'] != "")
                                <span class="counter-value" data-target="{{$totalDataCount['device_alerts']}}">0</span>
                            @else
                                <span>N/A</span>
                            @endif
                        </h4>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-primary-subtle rounded fs-3">
                            <i class="bx bx-home-alt text-primary"></i>
                        </span>
                    </div>
                </div>
            </div><!-- end card body -->
        </div><!-- end card -->
    </div><!-- end col -->
</div> <!-- end row-->