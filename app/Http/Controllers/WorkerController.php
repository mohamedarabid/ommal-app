<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\EmailWorker;
use App\Models\MobileWorker;
use App\Models\Worker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\WorkType;


class WorkerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $worker = Worker::paginate(10);
        return response()->view('dashboard.worker.index', compact('worker'));
    }
    public function showEmail($id)
    {
        $clients = Worker::withCount(['email', 'mobile'])->find($id);

        $EmailWorker = EmailWorker::where('user_id', $id)->where('user_type', 'App\Models\EmailWorker')->paginate(10);
        return response()->view('dashboard.worker.email', compact('EmailWorker', 'clients'));
    }
    public function showMobile($id)
    {
        $clients = Worker::withCount(['email', 'mobile'])->find($id);

        $MobileWorker = MobileWorker::where('user_id', $id)->where('user_type', 'App\Models\MobileWorker')->paginate(10);
        return response()->view('dashboard.worker.mobile', compact('MobileWorker', 'clients'));
    }
    public function showDoc($id)
    {
        $clients = Worker::withCount(['email', 'mobile'])->find($id);
        return response()->view('dashboard.worker.Doc', compact('clients'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cities = City::all();
        $work = WorkType::all();

        return response()->view('dashboard.worker.create', compact('cities', 'work'));
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

            'first_name' => 'required|string|min:3|max:35',
            'first_name_hb' => 'required|string|min:3|max:35',
            'father_name' => 'required|string|min:3|max:35',
            'father_name_hb' => 'required|string|min:3|max:35',
            'grand_name' => 'required|string|min:3|max:35',
            'grand_name_hb' => 'required|string|min:3|max:35',
            'last_name_hb' => 'required|string|min:3|max:35',
            'id_number' => 'required',
            'last_name' => 'required|string|min:3|max:35',
            'mobile' => 'required|numeric',
            'email' => 'required|email|unique:workers,email',
            'password' => 'required|string',
            'city_id' => 'required',
            'work_id' => 'required',
            'address' => 'required',
            'address_hb' => 'required',



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
            $address = array(
                "ar" => $request->get('address'),
                "hb" => $request->get('address_hb')
            );
            $admin = new Worker();
            $admin->email = $request->get('email');
            $admin->password = Hash::make($request->get('password'));
            $admin->status = $request->get('status');
            $admin->first_name = json_encode($first_name);
            $admin->father_name = json_encode($father_name);
            $admin->grand_name = json_encode($grand_name);
            $admin->family_name = json_encode($last_name);
            $admin->mobile = $request->get('mobile');
            $admin->id_number = $request->get('id_number');
            $admin->city_id = $request->get('city_id');
            $admin->Work_field_id = $request->get('work_id');
            $admin->address = json_encode($address);

            $admin->code = mt_rand(1000, 9999);
            $isSaved = $admin->save();
            if ($isSaved) {
                return response()->json(['icon' => 'success', 'title' => 'worker created successfully'], $isSaved ? 201 : 400);
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
        $clients = Worker::withCount(['email', 'mobile'])->find($id);
        return response()->view('dashboard.worker.show', compact('clients'));
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
        $Contractor = Worker::find($request->id);
        $Contractor->status = $request->unit_toggle_value;
        $save = $Contractor->save();
        if ($save) {
            return true;
        } else {
            return false;
        }
    }
}
