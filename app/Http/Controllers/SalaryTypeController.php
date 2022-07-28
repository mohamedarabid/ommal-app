<?php

namespace App\Http\Controllers;

use App\Models\JobSalary;
use Illuminate\Http\Request;

class SalaryTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $JobSalary = JobSalary::paginate(10);
        return response()->view('dashboard.JobSalary.index', compact('JobSalary'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->view('dashboard.JobSalary.create');
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
        ]);

        if (!$validator->fails()) {
            $permission = new JobSalary();
            $permission->name = $request->get('name');
            $isSaved = $permission->save();
            return response()->json(['icon' => 'success', 'title' => ' created successfully'], $isSaved ? 201 : 400);
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
        $JobSalary = JobSalary::find($id);
        return response()->view('dashboard.JobSalary.edit', compact('JobSalary'));
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
            'name' => 'nullable|string|max:100',
        ]);

        if (!$validator->fails()) {
            $permission =  JobSalary::find($id);
            $permission->name = $request->get('name');
            $isSaved = $permission->save();
            return response()->json(['icon' => 'success', 'title' => 'Updated successfully'], $isSaved ? 201 : 400);
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
        $isDeleted = JobSalary::destroy($id);

        return response()->json(['icon' => 'success', 'title' => 'deleted successfully'], $isDeleted ? 200 : 400);
    }
}
