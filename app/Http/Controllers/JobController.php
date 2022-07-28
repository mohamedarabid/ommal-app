<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Contractor;
use App\Models\currency;
use App\Models\Job;
use App\Models\JobRequest;
use App\Models\JobSalary;
use App\Models\Worker;
use Illuminate\Http\Request;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id)
    {

        $clients = Contractor::with(['email', 'mobile'])->find($id);

        $Job = Job::where('contractor_id', $id)->with(['currency', 'JobSalary'])->paginate(10);
        return response()->view('dashboard.job.index', compact('Job', 'clients'));
    }
    public function requestsWorker(Request $request, $id)
    {

        $clients = Worker::with(['email', 'mobile'])->find($id);

        $Job = JobRequest::where('worker_id', $id)->with(['Job'])->where('job_id',!null)->paginate(10);
        return response()->view('dashboard.job.requests', compact('Job', 'clients'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $currency = currency::all();
        $JobSalary = JobSalary::all();
        $cities = City::all();

        return response()->view('dashboard.job.create', compact('currency', 'JobSalary', 'id', 'cities'));
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
            'name_hb' => 'required|string|min:3|max:35',
            'desc_hb' => 'required|string|min:3',

            'desc' => 'required|string|min:3',
            'date' => 'required',
            'salary' => 'required',
            'currency_id' => 'required',
            'job_salary_id' => 'required',
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
            $admin = new Job();
            $admin->name = json_encode($name);
            $admin->desc = json_encode($desc);

            $admin->date = $request->get('date');
            $admin->salary = $request->get('salary');
            $admin->currency_id = $request->get('currency_id');
            $admin->job_salary_id = $request->get('job_salary_id');
            $admin->contractor_id = $request->get('contractor_id');
            $admin->status = $request->get('status');
            $admin->city_id = $request->get('city_id');

            $isSaved = $admin->save();
            if ($isSaved) {
                return response()->json(['icon' => 'success', 'title' => 'Job created successfully'], $isSaved ? 201 : 400);
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
