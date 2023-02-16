<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCountryRequest;
use App\Models\Country;
use App\Http\Resources\CountryResource;
use App\Http\Resources\CountryCollection;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countries = CountryResource::collection(Country::all());
        
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
        $country = new CountryResource(Country::findOrFail($id));
        
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
        $validated = $request->validate([
            'name' => ['bail', 'required', 'unique:countries']
        ]);
        
        $country = Country::find($id);
        
        if(!$country){
            return response ('Country not found', 404);
        }
        
        $country->name = $validated['name'];
        $country->save();
        $country->refresh();
        
        return response($country, 200)
                ->header('Content-Type', 'Application/Json');
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
