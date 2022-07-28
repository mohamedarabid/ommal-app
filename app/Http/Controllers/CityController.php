<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use App\Models\WorkType;


class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $city = City::paginate(10);
        return response()->view('dashboard.city.index', compact('city'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->view('dashboard.city.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator($request->all(), [
            'name' => 'required|string|max:100',
            'name_hb' => 'required|string|max:100',
            'status' => 'required',
        ]);

        if (!$validator->fails()) {
            $name = array(
                "ar" => $request->get('name'),
                "hb" => $request->get('name_hb')
            );
            $name = array(
                "ar" => $request->get('desc'),
                "hb" => $request->get('desc_hb')
            );
            $city = new City();
            $city->name = json_encode($name);
            $city->location = $request->get('location');

            $isSaved = $city->save();
            return response()->json(['icon' => 'success', 'title' => 'city created successfully'], $isSaved ? 201 : 400);
        } else {

            return response()->json(['icon' => 'error', 'title' => $validator->getMessageBag()->first()], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $city = City::find($id);
        return response()->view('dashboard.city.edit', compact('city'));
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
        $validator = Validator($request->all(), [
            'name' => 'required|string|max:100',
            'name_hb' => 'required|string|max:100',

        ]);

        if (!$validator->fails()) {
            $name = array(
                "ar" => $request->get('name'),
                "hb" => $request->get('name_hb')
            );
            $name = array(
                "ar" => $request->get('desc'),
                "hb" => $request->get('desc_hb')
            );
            $city =  City::find($id);
            $city->name = json_encode($name);
            $city->status = $request->get('status');
            $city->location = $request->get('location');

            $isSaved = $city->save();
            return response()->json(['icon' => 'success', 'title' => 'Work Type Updated successfully'], $isSaved ? 201 : 400);
        } else {

            return response()->json(['icon' => 'error', 'title' => $validator->getMessageBag()->first()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $isDeleted = City::destroy($id);

        return response()->json(['icon' => 'success', 'title' => 'Work Type deleted successfully'], $isDeleted ? 200 : 400);
    }

    public function storeJson(Request $request)
    {
        $data = $request->all();
        foreach ($data as $name) {

            $city = new WorkType();
            $city->name = json_encode($name);

            $city = $city->save();
        }
        return response()->json(['icon' => 'success', 'title' => 'Work Type deleted successfully'], $city ? 200 : 400);
    }
}
