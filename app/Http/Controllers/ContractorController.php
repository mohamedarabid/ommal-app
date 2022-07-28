<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Contractor;
use App\Models\EmailWorker;
use App\Models\MobileWorker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ContractorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Contractor = Contractor::paginate(10);
        return response()->view('dashboard.Contractor.index', compact('Contractor'));
    }
    public function showEmail($id)
    {
        $clients = Contractor::withCount(['email', 'mobile'])->find($id);

        $EmailWorker = EmailWorker::where('user_id', $id)->where('user_type', 'App\Models\EmailWorker')->paginate(10);
        return response()->view('dashboard.Contractor.email', compact('EmailWorker', 'clients'));
    }
    public function showMobile($id)
    {
        $clients = Contractor::withCount(['email', 'mobile'])->find($id);

        $MobileWorker = MobileWorker::where('user_id', $id)->where('user_type', 'App\Models\MobileWorker')->paginate(10);
        return response()->view('dashboard.Contractor.mobile', compact('MobileWorker', 'clients'));
    }
    public function showDoc($id)
    {
        $clients = Contractor::withCount(['email', 'mobile'])->find($id);
        return response()->view('dashboard.Contractor.Doc', compact('clients'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cities = City::all();
        return response()->view('dashboard.Contractor.create', compact('cities'));
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
            'first_name_hb' => 'required|string|min:3|max:35',
            'father_name' => 'required|string|min:3|max:35',
            'father_name_hb' => 'required|string|min:3|max:35',
            'grand_name' => 'required|string|min:3|max:35',
            'grand_name_hb' => 'required|string|min:3|max:35',
            'last_name_hb' => 'required|string|min:3|max:35',
            'id_number' => 'required',
            'license' => 'required',
            'last_name' => 'required|string|min:3|max:35',
            'mobile' => 'required|numeric',
            'email' => 'required|email|unique:contractors,email',
            'password' => 'required|string',
        ]);
        if (!$validator->fails()) {
            $first_name = array(
                "ar" => $request->get('first_name'),
                "hb" => $request->get('first_name_hb')
            );
            $father_name = array(
                "ar" => $request->get('father_name'),
                "hb" => $request->get('father_name_hb')
            );
            $grand_name = array(
                "ar" => $request->get('grand_name'),
                "hb" => $request->get('grand_name_hb')
            );
            $last_name = array(
                "ar" => $request->get('last_name'),
                "hb" => $request->get('last_name_hb')
            );
            $admin = new Contractor();
            $admin->email = $request->get('email');
            $admin->password = Hash::make($request->get('password'));
            $admin->status = $request->get('status');
            $admin->first_name = json_encode($first_name);
            $admin->father_name = json_encode($father_name);
            $admin->grand_name = json_encode($grand_name);
            $admin->family_name = json_encode($last_name);
            $admin->mobile = $request->get('mobile');
            $admin->id_number = $request->get('id_number');
            $admin->license = $request->get('license');
            $admin->code = mt_rand(1000, 9999);
            $isSaved = $admin->save();
            if ($isSaved) {
                return response()->json(['icon' => 'success', 'title' => 'Contractor created successfully'], $isSaved ? 201 : 400);
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
        $clients = Contractor::withCount(['email', 'mobile'])->find($id);
        return response()->view('dashboard.Contractor.show', compact('clients'));
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
    public function ajaxStatus(Request $request)

    {
        $Contractor = Contractor::find($request->id);
        $Contractor->status = $request->unit_toggle_value;
        $save = $Contractor->save();
        if ($save) {
            return true;
        } else {
            return false;
        }
    }
}
