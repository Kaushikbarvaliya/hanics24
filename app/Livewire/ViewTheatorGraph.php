<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ViewTheatorGraph extends Component
{
    public $loading = false;
    public $graphData = false;

    public function mount()
    {
        $this->fetchGraphData(); // Fetch data when the component mounts
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
                    $this->emit('graphDataUpdated', $this->graphData);
                }else{
                    Log::warning('API call success but not data fetch: ' . json_encode($responseData));
                }
            }
        } catch (\Exception $e) {
            Log::error('API call failed: ' . $e->getMessage());
        }
        $this->loading = true;
    }

    public function render()
    {
        return view('livewire.view-theator-graph');
    }
}
