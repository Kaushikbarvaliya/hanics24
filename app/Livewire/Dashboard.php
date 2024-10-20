<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class Dashboard extends Component
{
    public $viewType;
    public $isLoading = true;
    public $totalDataCount = [];

    public function mount($content = null)
    {
        $this->viewType = $content;

    }
    
    public function updated()
    {
        if($this->viewType == "viewTotalData"){
            // $this->fetchDashboardData();
        }
    }

    public function fetchDashboardData()
    {
        // Set the loading state to true
        $this->isLoading = true;

        try {
            // Make the API call using Laravel's Http client
            $response = Http::get('https://servecent.ajanics.com/api/v1/dashboard/get_dashboard_data', [
                'api_token' => 'c37a1b97fd8c45238a5f724c2556e9a4',
                'client_token' => '50f99cb3f36746c8bc4f63530ebee8f7',
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

        sleep(5);

        // Set the loading state to false after fetching the data
        $this->isLoading = false;
    }

    public function render()
    {
        return view('livewire.dashboard');
    }


}
