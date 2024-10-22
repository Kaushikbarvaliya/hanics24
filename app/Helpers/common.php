<?php

// app/Helpers/helpers.php

if (!function_exists('getApiToken')) {
    function getApiToken(){
        return session('api_token');
    }
}

if (!function_exists('getClientToken')) {
    function getClientToken(){
        return session('client_token');
    }
}

?>