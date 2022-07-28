<?php

namespace App\Http\Controllers;

use App\Models\WorkType;
use Illuminate\Http\Request;

class WorkTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $worker = WorkType::paginate(10);
        return response()->view('dashboard.workType.index', compact('worker'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->view('dashboard.workType.create');
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
            $permission = new WorkType();
            $city->name = json_encode($name);
            $permission->status = $request->get('status');
            $isSaved = $permission->save();
            return response()->json(['icon' => 'success', 'title' => 'Work Type created successfully'], $isSaved ? 201 : 400);
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
        $worker = WorkType::find($id);
        return response()->view('dashboard.workType.edit', compact('worker'));
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
            $permission =  WorkType::find($id);
            $permission->name = json_encode($name);
            $permission->status = $request->get('status');
            $isSaved = $permission->save();
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
        $isDeleted = WorkType::destroy($id);

        return response()->json(['icon' => 'success', 'title' => 'Work Type deleted successfully'], $isDeleted ? 200 : 400);
    }
}
