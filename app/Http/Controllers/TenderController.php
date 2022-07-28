<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Contractor;
use App\Models\Tender;
use App\Models\TenderRequest;
use Illuminate\Http\Request;

class TenderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id)
    {
        $clients = Contractor::find($id);
        $Tender = Tender::where('contractor_id', $id)->paginate(10);
        return response()->view('dashboard.tender.index', compact('Tender', 'clients'));
    }
    public function tenderRequests(Request $request, $id)
    {
        $clients = Contractor::find($id);
        $TenderRequest = TenderRequest::where('contractor_id', $id)->with('tender')->paginate(10);
        return response()->view('dashboard.tender.requests', compact('TenderRequest', 'clients'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $cities = City::all();

        return response()->view('dashboard.tender.create', compact('id', 'cities'));
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

            'name' => 'required|string|min:3|max:35',
            'desc' => 'required|string|min:3',
            'file' => 'required',
            'city_id' => 'required',

        ]);
        if (!$validator->fails()) {
            $name = array(
                "ar" => $request->get('name'),
                "hb" => $request->get('name_hb')
            );
            $desc = array(
                "ar" => $request->get('desc'),
                "hb" => $request->get('desc_hb')
            );
            $admin = new Tender();
            $admin->name = json_encode($name);
            $admin->desc = json_encode($desc);
            $admin->city_id = $request->get('city_id');
            $admin->status = $request->get('status');
            $admin->contractor_id = $request->get('contractor_id');
            if ($request->hasFile('file')) {
                $userImage = $request->file('file');
                $imageName = time() . '_' . $request->get('first_name') . '.' . $userImage->getClientOriginalExtension();
                $userImage->move('file/Tender', $imageName);
                $admin->file = '/file/Tender/' . $imageName;
            }
            $isSaved = $admin->save();
            if ($isSaved) {
                return response()->json(['icon' => 'success', 'title' => 'Tender created successfully'], $isSaved ? 201 : 400);
            } else {
                return response()->json(['message' => "Failed to save"], 400);
            }
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
        //
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
        //
    }
}
