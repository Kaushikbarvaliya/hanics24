<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="mb-3">
                <label for="theater" class="form-label">Choose Theater</label>
                <select class="form-select" id="theater" name="theater" aria-label="Select a Theater" wire:model.live="selectedTheater">
                    <option selected>Select a Theater</option>
                    @foreach($theaters as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                @if($selectedTheater && count($screens) > 0)
                    <div class="form-group mt-3">
                        <label>Available Screens:</label><br>
                        @foreach($screens as $screen)
                            <div>
                                <input type="radio" id="screen-{{ $screen['cloud_screen_id'] }}" value="{{ $screen['cloud_screen_id'] }}" wire:model.live="selectedScreen">
                                <label for="screen-{{ $screen['cloud_screen_id'] }}">{{ $screen['screen_name'] }}</label>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Heatmap Color Range</h4>
            </div><!-- end card header -->
            
            <div class="card-body">
                <div class="" wire:loading wire:target="selectedTheater,selectedScreen">Loading...</div>
                <div  wire:loading.remove wire:target="selectedTheater,selectedScreen" id="theators_heatmap" class="apex-charts" dir="ltr"></div>
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div>
</div>
