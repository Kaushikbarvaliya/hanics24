<div class="row" wire:init="fetchGraphData">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Heatmap Color Range</h4>
            </div><!-- end card header -->
            
            <div class="card-body">
                <div class="" wire:loading wire:target="loading">Loading...</div>
                <div wire:loading.remove wire:target="loading" id="color_heatmap" data-colors='["--vz-info", "--vz-success", "--vz-primary", "--vz-warning"]'
                class="apex-charts" dir="ltr"></div>
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div>
</div>