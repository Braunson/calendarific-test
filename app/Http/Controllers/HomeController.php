<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class HomeController extends Controller
{
    /**
     * Display the Inertia Search view
     *
     * @return \Inertia\Inertia
     */
    public function index()
    {
        // Retrieve the service, sure this could have been a facade but it's used once here
        $service = app()->make('App\Services\CalendarificService');

        return Inertia::render('Search', [
            'countries' => $service->getCountriesForSelect()
        ]);
    }
}
