<?php

use App\Models\Enterprise;
use App\Models\GeneralInfo;
use App\Models\Offer;
use App\Models\Transaction;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Container\Container;
use Illuminate\Http\RedirectResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;




function openJSONFile($code){

    $jsonString = [];
    if(File::exists(base_path('resources/lang/'.$code.'.json'))){
        $jsonString = file_get_contents(base_path('resources/lang/'.$code.'.json'));
        $jsonString = json_decode($jsonString, true);
    }
    return $jsonString;
}

function saveJSONFile($code, $data){
    ksort($data);
    $jsonData = json_encode($data, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
    file_put_contents(base_path('resources/lang/'.$code.'.json'), stripslashes($jsonData));
}



function paginate($items, $limit, $page , $options = [])
{
    $array = [];
    foreach($items->forPage($page, $limit) as $it){
    array_push($array,$it);
    }
    // $items =coll $items
    // return new LengthAwarePaginator($items->forPage($page, $limit), $items->count(), $limit, $page, $options);

    return $array;
}


