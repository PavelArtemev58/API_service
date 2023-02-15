<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCityRequest;
use App\Models\City;
use App\Models\Country;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities = City::all();
        
        return response ($cities, 200)
                ->header('Content-Type', 'Application/Json');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCityRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCityRequest $request)
    {
        $validated = $request->validated();
        
        $city = new City(['name' => $validated['name']]);
        $country = Country::where('name', '=', $validated['country'])->first();
        $country->cities()->save($city);
        $city->refresh();
        
        return response($city, 201)
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
        $city = City::findOrFail($id);
        
        return response($city, 200)
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
            'name' => ['bail', 'required'],
        ]);
        
        $city = City::find($id);
        
        if(!$city){
            return response ('City not fond', 404);
        }
        
        $city->name = $validated['name'];
        $city->save();
        $city->refresh();
        
        return response ($city, 200)
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
        City::destroy($id);
        
        return response ('Succesful', 200);
    }
}
