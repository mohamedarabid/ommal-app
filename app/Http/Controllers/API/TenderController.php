<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ControllersService;
use App\Models\Tender;
use App\Models\TenderRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TenderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $Tenders = Tender::where('contractor_id', '!=', $request->user('contractor_api')->id);

        if ($request->get('orderBy') == 'desc') {
            $Jobs = $Tenders->orderBy('created_at', 'desc');
        } elseif ($request->get('orderBy') == 'asc') {
            $Jobs = $Tenders->orderBy('created_at', 'asc');
        }
        if ($request->get('from')) {
            $Jobs = $Tenders->whereBetween('date', [$request->get('from'), $request->get('to')]);
        }
        if ($request->get('city_id')) {
            $Jobs = $Jobs->where('city_id',  $request->get('city_id'))->paginate(10);
        }
        if ($request->get('name')) {
            $Jobs = $Tenders->where('name',  'LIKE', '%' . $request->get('name') . '%');
        }
        $Tenders = $Tenders->paginate(10);
        $resonseData = [];
        foreach ($Tenders as $key => $Tender) {

            $resonseData['Tender'][$key]['id']         = $Tender->id;
            $resonseData['Tender'][$key]['name']       = $Tender->fname;
            $resonseData['Tender'][$key]['desc']       = $Tender->fdesc;
            // if ($Tender->contractor_id == request()->user('contractor_api')->id) {
            //     $resonseData['Tender'][$key]['owend']       = true;
            // } else {
            //     $resonseData['Tender'][$key]['owend']       = false;
            // }
        }
        if ($Tenders->count() != 0) {
            $pagination['count'] = $Tenders->count();
            $pagination['hasMorePages'] = $Tenders->hasMorePages();
            $pagination['currentPage'] = $Tenders->currentPage();
            $pagination['firstItem'] = $Tenders->firstItem();
            $pagination['last_page_id'] = $Tenders->lastPage();
            $pagination['per_page'] = $Tenders->perPage();
            $pagination['nextPageUr l'] = $Tenders->nextPageUrl();
            $pagination['onFirstPage'] = $Tenders->onFirstPage();
            $pagination['previousPageUrl'] = $Tenders->previousPageUrl();
            $resonseData['paginate'] = $pagination;
        }

        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $resonseData
        ]);
    }
    public function myTender(Request $request)
    {
        $Tenders = Tender::where('contractor_id', $request->user('contractor_api')->id)->paginate(10);
        $resonseData = [];
        foreach ($Tenders as $key => $Tender) {

            $resonseData['Tender'][$key]['id']         = $Tender->id;
            $resonseData['Tender'][$key]['name']       = $Tender->fname;
            $resonseData['Tender'][$key]['desc']       = $Tender->fdesc;
            // if ($Tender->contractor_id == request()->user('contractor_api')->id) {
            //     $resonseData['Tender'][$key]['owend']       = true;
            // } else {
            //     $resonseData['Tender'][$key]['owend']       = false;
            // }
        }
        if ($Tenders->count() != 0) {
            $pagination['count'] = $Tenders->count();
            $pagination['hasMorePages'] = $Tenders->hasMorePages();
            $pagination['currentPage'] = $Tenders->currentPage();
            $pagination['firstItem'] = $Tenders->firstItem();
            $pagination['last_page_id'] = $Tenders->lastPage();
            $pagination['per_page'] = $Tenders->perPage();
            $pagination['nextPageUr l'] = $Tenders->nextPageUrl();
            $pagination['onFirstPage'] = $Tenders->onFirstPage();
            $pagination['previousPageUrl'] = $Tenders->previousPageUrl();
            $resonseData['paginate'] = $pagination;
        }

        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $resonseData
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $roles = [
            'name' => 'required|string|min:3',
            'desc' => 'required|string|min:3',
            'city_id' => 'required',

            'file' => 'required',

        ];
        if (request()->header('lang') == 'en') {
            $customMessages = [
                'unique' => 'The :attribute field is Must be unique.',
                'required' => 'The :attribute field is required.'

            ];
        } else {
            $customMessages = [
                'name.required' => ' :الاسم   مطلوب.',
                'desc.required' => ' :التفاصيل   مطلوب.',
                'city_id.required' => ' :المدينة  مطلوب.',
                'file.required' => ' :الملف  مطلوب.',

            ];
        }
        $validator = Validator::make($request->all(), $roles, $customMessages);
        if (!$validator->fails()) {
            $user = new Tender();
            $user->name = $request->get('name');
            $user->desc = $request->get('desc');
            $user->city_id = $request->get('city_id');

            $user->status = 'active';
            $user->contractor_id = $request->user('contractor_api')->id;

            if ($request->hasFile('file')) {
                $userImage = $request->file('file');
                $imageName = time() . '_' . $request->get('first_name') . '.' . $userImage->getClientOriginalExtension();
                $userImage->move('file/Tender', $imageName);
                $user->file = '/file/Tender/' . $imageName;
            }
            $isSaved = $user->save();
            if ($isSaved) {
                return ControllersService::generateProcessResponse(true, 'CREATE_SUCCESS');
            } else {
                return ControllersService::generateProcessResponse(false, 'LOGIN_IN_FAILED');
            }
        } else {
            return ControllersService::generateValidationErrorMessage($validator->getMessageBag()->first());
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
        $Tender = Tender::find($id);
        $resonseData['id']         = $Tender->id;
        $resonseData['name']       = $Tender->fname;
        $resonseData['desc']       = $Tender->fdesc;
        $resonseData['city']       = $Tender->city->name;

        $resonseData['file']       = url($Tender->file);
        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $resonseData
        ]);
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
        $roles = [
            'name' => 'nullable|string|min:3',
            'desc' => 'nullable|string|min:3',
            'city_id' => 'nullable',
            'file' => 'nullable',

        ];
        $validator = Validator::make($request->all(), $roles);
        if (!$validator->fails()) {
            $user =  Tender::find($id);
            $user->name = $request->get('name');
            $user->desc = $request->get('desc');
            $user->city_id = $request->get('city_id');
            $user->status = $request->get('status');
            if ($request->hasFile('file')) {
                $userImage = $request->file('file');
                $imageName = time() . '_' . $request->get('first_name') . '.' . $userImage->getClientOriginalExtension();
                $userImage->move('file/Tender', $imageName);
                $user->file = '/file/Tender/' . $imageName;
            }
            $isSaved = $user->save();
            if ($isSaved) {
                return ControllersService::generateProcessResponse(true, 'UPDATE_SUCCESS');
            } else {
                return ControllersService::generateProcessResponse(false, 'UPDATE_FAILED');
            }
        } else {
            return ControllersService::generateValidationErrorMessage($validator->getMessageBag()->first());
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
    }
    public function requestTender(Request $request)
    {
        $roles = [
            'file' => 'required',
            'budget' => 'required',
        ];
        if (request()->header('lang') == 'en') {
            $customMessages = [
                'unique' => 'The :attribute field is Must be unique.',
                'required' => 'The :attribute field is required.'

            ];
        } else {
            $customMessages = [

                'budget.required' => ' :الميزامية  مطلوب.',
                'file.required' => ' :الملف  مطلوب.',

            ];
        }
        $validator = Validator::make($request->all(), $roles, $customMessages);
        if (!$validator->fails()) {
            $user = new TenderRequest();
            $user->budget = $request->get('budget');
            $user->tender_id = $request->get('tender_id');
            $user->currency_id = $request->get('currency_id');
            $user->contractor_id = $request->user('contractor_api')->id;
            $user->status = 'pending';
            if ($request->hasFile('file')) {
                $userImage = $request->file('file');
                $imageName = time() .  '.' . $userImage->getClientOriginalExtension();
                $userImage->move('file/Tender', $imageName);
                $user->file = '/file/Tender/' . $imageName;
            }
            $isSaved = $user->save();
            if ($isSaved) {
                return ControllersService::generateProcessResponse(true, 'CREATE_SUCCESS');
            } else {
                return ControllersService::generateProcessResponse(false, 'LOGIN_IN_FAILED');
            }
        } else {
            return ControllersService::generateValidationErrorMessage($validator->getMessageBag()->first());
        }
    }
    public function showTenderRequest($id)
    {
        $Tenders = TenderRequest::where('tender_id', $id)->get();
        $resonseData['requestsCount']         = $Tenders->count();

        foreach ($Tenders as $key => $Tender) {
            $resonseData[$key]['id']         = $Tender->id;
            $resonseData[$key]['budget']       = $Tender->budget;
            $resonseData[$key]['currency']       = $Tender->currency->name;
            $resonseData[$key]['file']       = url($Tender->file);
            $resonseData[$key]['contractor']       = $Tender->contractor->name . '' . $Tender->contractor->fname . '' . $Tender->contractor->gname . '' . $Tender->contractor->faname;
            $resonseData[$key]['workType']       = $Tender->contractor->workType->name;
        }
        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $resonseData, 'requestsCount' => $Tenders->count()
        ]);
    }
    public function ChangeStatus(Request $request, $id)
    {
        $roles = [
            'status' => 'nullable',

        ];
        $validator = Validator::make($request->all(), $roles);
        if (!$validator->fails()) {
            $TenderRequest =  TenderRequest::find($id);
            if ($TenderRequest->status == 'accept') {
                $TenderRequest->status = 'reject';
            } else {
                $TenderRequest->status = 'accept';
            }
            $isSaved = $TenderRequest->save();
            if ($isSaved) {
                return ControllersService::generateProcessResponse(true, 'UPDATE_SUCCESS');
            } else {
                return ControllersService::generateProcessResponse(false, 'UPDATE_FAILED');
            }
        } else {
            return ControllersService::generateValidationErrorMessage($validator->getMessageBag()->first());
        }
    }
    public function TenderRequest()
    {
        $Tenders = TenderRequest::paginate(10);
        $TendersCount = TenderRequest::count();
        $resonseData = [];
        foreach ($Tenders as $key => $Tender) {

            $resonseData['Tender'][$key]['id']         = $Tender->id;
            $resonseData['Tender'][$key]['file']         = url($Tender->file);
            $resonseData['Tender'][$key]['name']       = $Tender->contractor->name . '' . $Tender->contractor->fname . '' . $Tender->contractor->gname . '' . $Tender->contractor->faname;
            $resonseData['Tender'][$key]['count_request'] = $TendersCount;
        }
        $pagination['count'] = $Tenders->count();
        $pagination['hasMorePages'] = $Tenders->hasMorePages();
        $pagination['currentPage'] = $Tenders->currentPage();
        $pagination['firstItem'] = $Tenders->firstItem();
        $pagination['last_page_id'] = $Tenders->lastPage();
        $pagination['per_page'] = $Tenders->perPage();
        $pagination['nextPageUr l'] = $Tenders->nextPageUrl();
        $pagination['onFirstPage'] = $Tenders->onFirstPage();
        $pagination['previousPageUrl'] = $Tenders->previousPageUrl();
        $resonseData['paginate'] = $pagination;

        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $resonseData
        ]);
    }
}
