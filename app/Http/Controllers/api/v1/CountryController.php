<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCountryRequest;
use App\Models\Country;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countries = Country::all();
        
        return response ($countries, 200)
                ->header('Content-Type', 'Application/Json');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCountryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCountryRequest $request)
    {
        $validated = $request->validated();
        
        if(Country::whereName($validated['name'])->count()){
            return response("Country $validated[name] already exists", 400);
        }
        
        $country = new Country();
        $country->name = $validated['name'];
        $country->save();
        $country->refresh();
        
        return response($country, 201)
                ->header('Content-Type', 'Application/Json');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $country = Country::find($id);
        
        return response($country, 200)
                ->header('Content-Type', 'Application/Json');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Country::destroy($id);
        
        return response ("Succesful", 200);
    }
}
