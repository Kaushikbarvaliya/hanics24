<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ViewTheatorGraph extends Component
{
    public $selectedTheater = null;
    public $selectedScreen = null;
    public $screens = [];
    public $theaters = [];
    public $graphData = false;

    public function mount()
    {
        $this->fetchGraphData();
    }

    public function fetchGraphData()
    {
        try {
            // Make the API call using Laravel's Http client
            $response = Http::get(env('API_BASE_URL') . 'theater/get_theaters', [
                'api_token' => getApiToken(),
                'client_token' => getClientToken(),
            ]);
            
            // Check for a successful response
            if ($response->successful()) {
                $responseData = $response->json();
                if(!empty($responseData) && !empty($responseData['data'])){
                    $this->graphData = $responseData['data'];
                    $theaters = collect($this->graphData)->pluck('theater_name', 'theater_id')->filter()->toArray();
                    $this->fill([
                        'theaters' => $theaters
                    ]);
                }else{
                    Log::warning('API call success but not data fetch: ' . json_encode($responseData));
                }
            }
        } catch (\Exception $e) {
            Log::error('API call failed: ' . $e->getMessage());
        }
    }

    public function updatedSelectedTheater($theaterId)
    {
        try {
            $screens = collect($this->graphData)
            ->filter(function ($data) use ($theaterId) {
                return $data['theater_id'] == $theaterId; // Filter by the desired theater ID
            })
            ->flatMap(function ($data) {
                return collect($data['screens']);
            })
            ->toArray();
            $this->screens = !empty($screens) ? $screens: [];
            $this->selectedTheater = $theaterId;
            $this->selectedScreen = null;
        } catch (\Exception $e) {
            Log::error('API call failed: ' . $e->getMessage());
        }

    }
    
    public function updatedSelectedScreen($screenId)
    {
        try {
            $selectedTheater = $this->selectedTheater;
            // Make the API call using Laravel's Http client
            $response = Http::get(env('API_BASE_URL') . 'services/get_service_list', [
                'api_token' => getApiToken(),
                'client_token' => getClientToken(),
                'theater_id' => $selectedTheater,
                'cloud_screen_id' => $screenId,
                'service_status' => 1,
                'page' => 0,
            ]);
            // Check for a successful response
            if ($response->successful()) {
                $responseData = $response->json();
                if(!empty($responseData) && !empty($responseData['screens'])){
                    $screenData = $responseData['screens'];
                    $getScreeenValue = collect($screenData)
                        ->filter(function ($data) use ($screenId,$selectedTheater) {
                            return $data['cloud_screen_id'] == $screenId && $data['cloud_theater_id'] == $selectedTheater;
                        })
                        ->toArray();
                    $screenValue = !empty($getScreeenValue) ?  reset($getScreeenValue) : [];
                    if(!empty($screenValue)){
                        $jsonArray = $screenValue['layout'];
                        $graphValues = collect($jsonArray)->map(function ($item) {
                            preg_match('/([A-Za-z]+)(\d+)/', $item, $matches);
                            return [
                                'label' => $matches[1] ?? null, // Alphabet part
                                'value' => $matches[2] ?? null    // Numeric part
                            ];
                        })
                        ->toArray();
                        $returnData  = [
                            'maxColumn' => $screenValue['num_cols']??0,
                            'data' => ($graphValues??[])
                        ];
                        $this->dispatch('graphDataUpdated', $returnData);
                    }
                }else{ 
                    Log::warning('API call success but not data fetch: ' . json_encode($responseData));
                }
            }
        } catch (\Exception $e) {
            Log::error('API call failed: ' . $e->getMessage());
        }

    }

    public function render()
    {
        return view('livewire.view-theator-graph');
    }
}
