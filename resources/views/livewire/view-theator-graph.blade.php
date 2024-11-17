<div class="card">
    <div class="card-header d-flex align-items-center">
        <h4 class="card-title mb-0">Heatmap Color Range</h4>
        <div class="d-flex gap-2 ms-auto">
            <select class="form-select" id="theater" name="theater" aria-label="Select a Theater" wire:model.live="selectedTheater">
                @foreach($theaters as $id => $name)
                    <option value="{{ $id }}" @if($loop->first) selected @endif>{{ $name }}</option>
                @endforeach
            </select>
        </div>
    </div><!-- end card header -->

    <div class="card-body">
        @if($selectedTheater && count($screens) > 0)
        <div class="form-group d-flex align-items-center gap-2 available-screen-group" wire:key="radio-group">
            <label class="form-label mb-0">Available Screens:</label>
            <div class="available-list">
                @foreach($screens as $screen)
                    <div class="available-list__item">
                        <input class="form-check-input" type="radio" id="screen-{{ $screen['cloud_screen_id'] }}" value="{{ $screen['cloud_screen_id'] }}" wire:model.live="selectedScreen">
                        <label for="screen-{{ $screen['cloud_screen_id'] }}" class="form-check-label mb-0">{{ $screen['screen_name'] }}</label>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
        <div class="" wire:loading wire:target="selectedTheater,selectedScreen">Loading...</div>
        <div  wire:loading.remove wire:target="selectedTheater,selectedScreen" id="theators_heatmap" class="apex-charts" dir="ltr"></div>
    </div><!-- end card-body -->
</div>
