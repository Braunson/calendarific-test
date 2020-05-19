<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CalendarificService;
use App\Http\Requests\RetrieveHolidaysFormRequest;

class ApiController extends Controller
{
    protected $service;

    public function __construct(CalendarificService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @param App\Http\Requests\RetrieveHolidays
     * @return \Illuminate\Http\Response
     */
    public function retrieveHolidays(RetrieveHolidaysFormRequest $request)
    {
        return response()->json(
            $this->service->getHolidaysForTable(
                $request->only(['country', 'year', 'month'])
            )
        );
    }

    /**
     * Retrieve countries available to select from
     *
     * @return \Illuminate\Http\Response
     */
    public function retrieveCountries()
    {
        return response()->json(
            $this->service->getCountriesForSelect()
        );
    }
}
