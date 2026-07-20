<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\View\View;

class ServiceController extends Controller
{
    
    public function show(Service $service)
{
   
    $otherServices = Service::query()
        ->where('is_active', true)
        ->where('id', '!=', $service->id)
        ->latest()
        ->take(5)
        ->get();

        $services = Service::query()
        ->where('is_active', 1)
        ->orderBy('display_order')
        ->latest()
        ->take(6)
        ->get();

    return view('frontend.services.show', compact(
        'service',
        'services',
        'otherServices'
    ));
}

}