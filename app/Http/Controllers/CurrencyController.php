<?php

namespace App\Http\Controllers;

use App\Models\currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currency = currency::paginate(10);
        return response()->view('dashboard.currency.index', compact('currency'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->view('dashboard.currency.create');
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
            $currency = new currency();
            $currency->name = $request->get('name');

            $isSaved = $currency->save();
            return response()->json(['icon' => 'success', 'title' => 'currency created successfully'], $isSaved ? 201 : 400);
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
        $currency = currency::find($id);
        return response()->view('dashboard.currency.edit', compact('currency'));
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
            $permission =  currency::find($id);
            $permission->name = $request->get('name');
            $isSaved = $permission->save();
            return response()->json(['icon' => 'success', 'title' => 'currency Updated successfully'], $isSaved ? 201 : 400);
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
        $isDeleted = currency::destroy($id);

        return response()->json(['icon' => 'success', 'title' => 'deleted successfully'], $isDeleted ? 200 : 400);
    }
}
