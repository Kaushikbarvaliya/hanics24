<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class Dashboard extends Component
{
    public $viewType;
    public $loading = false;
    public $totalDataCount = false;

    // protected $listeners = ['initLoad' => 'loadComponent'];

    public function mount($content = null)
    {
        // $this->viewType = $content;
    }

    public function fetchDashboardData()
    {
        try {
            // Make the API call using Laravel's Http client
            $response = Http::get(env('API_BASE_URL') . 'dashboard/get_dashboard_data', [
                'api_token' => getApiToken(),
                'client_token' => getClientToken(),
            ]);
            // Check for a successful response
            if ($response->successful()) {
                $responseData = $response->json();
                if(!empty($responseData) && !empty($responseData['data'])){
                    $this->totalDataCount = $responseData['data'];
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
        return view('livewire.dashboard');
    }


}
