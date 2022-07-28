<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;

use Spatie\Permission\Models\Permission;



class PermissionController extends Controller

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

        //

        $page_title = 'Permission';

        $page_description = '';



        $permissions = Permission::paginate(100);

        return view('dashboard.spatie.permissions.index', compact('permissions', 'page_title', 'page_description'));

        

    }



    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        //

        return response()->view('dashboard.spatie.permissions.create');

    }



    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {

        //

        //

        $validator = Validator($request->all(), [

            'name' => 'required|string|max:100',

            'guard_name' => 'required|string|in:admin',

        ]);



        if (!$validator->fails()) {

            $permission = new Permission();

            $permission->name = $request->get('name');

            $permission->guard_name = $request->get('guard_name');

            $isSaved = $permission->save();

            return response()->json(['icon' => 'success', 'title' => 'Permission created successfully'], $isSaved ? 201 : 400);

        } else {

            return response()->json(['icon' => 'error', 'title'=> $validator->getMessageBag()->first()], 400);

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

        $permission = Permission::findById($id);

        return response()->view('dashboard.spatie.permissions.edit', compact('permission'));

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

        $validator = Validator($request->all(), [

            'name' => 'required|string|max:100',

            'guard_name' => 'required|string|in:admin,professional,customer',

        ]);



        if (!$validator->fails()) {

            $permission = Permission::findById($id);

            $permission->name = $request->get('name');

            $permission->guard_name = $request->get('guard_name');

            $isSaved = $permission->save();

            return response()->json(['icon' => 'success', 'title' => 'Permission updated successfully'], $isSaved ? 200 : 400);

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

        //

        $isDeleted = Permission::destroy($id);

        return response()->json(['icon' => 'success', 'title' => 'permission deleted successfully'], $isDeleted ? 200 : 400);

    }

}

