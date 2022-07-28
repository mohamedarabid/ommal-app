<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ControllersService;
use App\Models\City;
use App\Models\currency;
use App\Models\Job;
use App\Models\JobRequest;
use App\Models\JobSalary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\WorkType;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $Jobs = Job::where('contractor_id', request()->user('contractor_api')->id)->paginate(10);

        $Jobs = $Jobs->paginate(10);
        $resonseData = [];
        foreach ($Jobs as $key => $Job) {

            $resonseData['job'][$key]['id']         = $Job->id;
            $resonseData['job'][$key]['name']       = $Job->name;
            $resonseData['job'][$key]['desc']       = $Job->desc;
            $resonseData['job'][$key]['status']       = $Job->status;
        }
        $pagination['count'] = $Job->count();
        $pagination['hasMorePages'] = $Job->hasMorePages();
        $pagination['currentPage'] = $Job->currentPage();
        $pagination['firstItem'] = $Job->firstItem();
        $pagination['last_page_id'] = $Job->lastPage();
        $pagination['per_page'] = $Job->perPage();
        $pagination['nextPageUrl'] = $Job->nextPageUrl();
        $pagination['onFirstPage'] = $Job->onFirstPage();
        $pagination['previousPageUrl'] = $Job->previousPageUrl();
        $resonseData['paginate'] = $pagination;

        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $resonseData
        ]);
    }
    public function indexJobs(Request $request)
    {

        $Jobs = Job::where('contractor_id', $request->user('contractor_api')->id);
        if ($request->get('orderBy') == 'desc') {
            $Jobs = $Jobs->orderBy('created_at', 'desc');
        } elseif ($request->get('orderBy') == 'asc') {
            $Jobs = $Jobs->orderBy('created_at', 'asc');
        }
        if ($request->get('from')) {
            $Jobs = $Jobs->whereBetween('date', [$request->get('from'), $request->get('to')]);
        }
        if ($request->get('city_id')) {
            $Jobs = $Jobs->where('city_id',    $request->get('city_id'))->paginate(10);
        }
        if ($request->get('name')) {
            $Jobs = $Jobs->where('name',  'LIKE', '%' . $request->get('name') . '%');
        }
        $Jobs = $Jobs->paginate(10);
        $resonseData = [];
        foreach ($Jobs as $key => $Job) {

            $resonseData['job'][$key]['id']         = $Job->id;
            $resonseData['job'][$key]['name']       = $Job->fname;
            $resonseData['job'][$key]['desc']       = $Job->fdesc;
            $resonseData['job'][$key]['status']       = $Job->status;
        }
        $pagination['count'] = $Jobs->count();
        $pagination['hasMorePages'] = $Jobs->hasMorePages();
        $pagination['currentPage'] = $Jobs->currentPage();
        $pagination['firstItem'] = $Jobs->firstItem();
        $pagination['last_page_id'] = $Jobs->lastPage();
        $pagination['per_page'] = $Jobs->perPage();
        $pagination['nextPageUrl'] = $Jobs->nextPageUrl();
        $pagination['onFirstPage'] = $Jobs->onFirstPage();
        $pagination['previousPageUrl'] = $Jobs->previousPageUrl();
        $resonseData['paginate'] = $pagination;

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
            'date' => 'required',
            'job_salary_id' => 'required',
            'currency_id' => 'required',
            'salary' => 'required',
        ];
        if (request()->header('lang') == 'en') {
            $customMessages = [
                'unique' => 'The :attribute field is Must be unique.',
                'required' => 'The :attribute field is required.'

            ];
        } else {
            $customMessages = [
                'name.required' => ' :الاسم   مطلوب.',
                'desc.required' => ' :الاسم   مطلوب.',
                'date.required' => ' :التاريخ  مطلوب.',
                'city_id.required' => ' :المدينة  مطلوب.',
                'salary.required' => ' : الراتب مطلوب.',
                'currency_id.required' => ' :العملة  مطلوب.',
                'job_salary_id.required' => ' :وقت الدفع مطلوب.',
            ];
        }
        $validator = Validator::make($request->all(), $roles, $customMessages);
        if (!$validator->fails()) {
            $user = new Job();
            $user->name = $request->get('name');
            $user->desc = $request->get('desc');
            $user->city_id = $request->get('city_id');
            $user->date = $request->get('date');
            $user->salary = $request->get('salary');
            $user->overnight = $request->get('overnight');
            $user->health_inssurance = $request->get('health_inssurance');
            $user->permission = $request->get('permission');
            $user->contractor_id = $request->user('contractor_api')->id;
            $user->currency_id = $request->get('currency_id');
            $user->job_salary_id = $request->get('job_salary_id');
            $isSaved = $user->save();
            if ($isSaved) {
                return ControllersService::generateProcessResponse(true, 'CREATE_SUCCESS');
            } else {
                return ControllersService::generateProcessResponse(false, 'CREATE_FAILED');
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
        $Job = Job::find($id);
        $resonseData['id']         = $Job->id;
        $resonseData['name']       = $Job->fname;
        $resonseData['desc']       = $Job->fdesc;
        $resonseData['status']       = $Job->status;
        $resonseData['city']       = $Job->city->name ?? '';
        $resonseData['overnight']       = $Job->overnight;
        $resonseData['health_inssurance']       = $Job->health_inssurance;
        $resonseData['permission']       = $Job->permission;
        $resonseData['currency']       = $Job->currency->name;
        $resonseData['duration']       = $Job->JobSalary->name;
        $resonseData['salary']       = $Job->salary;

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

            'date' => 'nullable',
            'job_salary_id' => 'nullable',
            'currency_id' => 'nullable',
            'salary' => 'nullable',
        ];
        $validator = Validator::make($request->all(), $roles);
        if (!$validator->fails()) {
            $user =  Job::find($id);
            $user->name = $request->get('name');
            $user->desc = $request->get('desc');
            $user->city_id = $request->get('city_id');
            $user->date = $request->get('date');
            $user->salary = $request->get('salary');
            $user->overnight = $request->get('overnight');
            $user->health_inssurance = $request->get('health_inssurance');
            $user->permission = $request->get('permission');
            $user->currency_id = $request->get('currency_id');
            $user->job_salary_id = $request->get('job_salary_id');
            $user->status = 'active';
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
    public function ChangeStatus(Request $request, $id)
    {
        $roles = [
            'status' => 'nullable',

        ];
        $validator = Validator::make($request->all(), $roles);
        if (!$validator->fails()) {
            $Job =  Job::find($id);
            if ($Job->status == 'stop') {
                $Job->status = 'active';
            } else {
                $Job->status = 'stop';
            }
            $isSaved = $Job->save();
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
    public function currency()
    {
        $currency = currency::all();
        $resonseData = [];
        foreach ($currency as $key => $currencies) {

            $resonseData['currency'][$key]['id']         = $currencies->id;
            $resonseData['currency'][$key]['name']       = $currencies->name;
        }
        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $resonseData
        ]);
    }
    public function jobType()
    {
        $JobSalary = JobSalary::all();
        $resonseData = [];
        foreach ($JobSalary as $key => $JobSalaries) {
            $resonseData['JobSalary'][$key]['id']         = $JobSalaries->id;
            $resonseData['JobSalary'][$key]['name']       = $JobSalaries->name;
        }
        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $resonseData
        ]);
    }

    public function ChangeStatusRequest(Request $request, $id)
    {
        $roles = [
            'status' => 'nullable',

        ];
        $validator = Validator::make($request->all(), $roles);
        if (!$validator->fails()) {
            $Job =  JobRequest::find($id);

                $Job->status = $request->status;

            $isSaved = $Job->save();
            if ($isSaved) {
                return ControllersService::generateProcessResponse(true, 'UPDATE_SUCCESS');
            } else {
                return ControllersService::generateProcessResponse(false, 'UPDATE_FAILED');
            }
        } else {
            return ControllersService::generateValidationErrorMessage($validator->getMessageBag()->first());
        }
    }
    public function requestJob(Request $request)
    {
        $roles = [
            'job_id' => 'required',
        ];
        if (request()->header('lang') == 'en') {
            $customMessages = [
                'unique' => 'The :attribute field is Must be unique.',
                'required' => 'The :attribute field is required.'

            ];
        } else {
            $customMessages = [
                'job_id.required' => ' :الوظيفة   مطلوب.',

            ];
        }
        $validator = Validator::make($request->all(), $roles, $customMessages);
        if (!$validator->fails()) {
            $user = new JobRequest();
            $user->job_id = $request->get('job_id');
            $user->worker_id = $request->user('worker_api')->id;
            $user->status = 'pending';
            $user->send_type = 'by_worker';
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

    public function requestJobByContractor(Request $request)
    {
        $userId = $request->user('contractor_api')->id;

        $roles = [
            'job_id' => 'required',
            'worker_id' => 'required'
        ];
        if (request()->header('lang') == 'en') {
            $customMessages = [
                'unique' => 'The :attribute field is Must be unique.',
                'required' => 'The :attribute field is required.'

            ];
        } else {
            $customMessages = [
                'job_id.required' => ' :الوظيفة   مطلوب.',
                'worker_id.required' => ' :العامل   مطلوب.',

            ];
        }
        $validator = Validator::make($request->all(), $roles, $customMessages);
        if (!$validator->fails()) {
            $user = new JobRequest();
            $user->worker_id = $request->get('worker_id');
            $user->status = 'pending';
            $user->send_type = 'by_contractor';
            $user->contractor_id = $userId;
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
    public function indexJobsRequestsContractor(Request $request, $id)
    {
        $Jobs = JobRequest::with(['Job' => function ($query) {
            $query->with('JobSalary');
        }])->where('job_id', $id)->orderBy('created_at', 'desc')->paginate(10);
        $resonseData = [];
        foreach ($Jobs as $key => $Job) {
            $resonseData['job'][$key]['id']         = $Job->id;
            $resonseData['job'][$key]['worker_id']       = $Job->worker_id;
            $resonseData['job'][$key]['worker_name']       = $Job->worker->name;
            $resonseData['job'][$key]['workType']       = $Job->worker->workType->name;
        }
        $pagination['count'] = $Jobs->count();
        $pagination['hasMorePages'] = $Jobs->hasMorePages();
        $pagination['currentPage'] = $Jobs->currentPage();
        $pagination['firstItem'] = $Jobs->firstItem();
        $pagination['last_page_id'] = $Jobs->lastPage();
        $pagination['per_page'] = $Jobs->perPage();
        $pagination['nextPageUrl'] = $Jobs->nextPageUrl();
        $pagination['onFirstPage'] = $Jobs->onFirstPage();
        $pagination['previousPageUrl'] = $Jobs->previousPageUrl();
        $resonseData['paginate'] = $pagination;

        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $resonseData
        ]);
    }
    public function indexJobsWorker(Request $request)
    {

        if ($request->get('orderBy') == 'desc') {
            $Jobs = Job::orderBy('created_at', 'desc')->with('JobSalary')->paginate(10);
        } elseif ($request->get('orderBy') == 'asc') {
            $Jobs = Job::orderBy('created_at', 'asc')->with('JobSalary')->paginate(10);
        }
        if ($request->get('from')) {
            $Jobs = Job::whereBetween('date', [$request->get('from'), $request->get('to')])->with('JobSalary')->paginate(10);
        }
        if ($request->get('city_id')) {
            $Jobs = Job::where('city_id',    $request->get('city_id'))->paginate(10);
        }
        if ($request->get('name')) {
            $Jobs = Job::where('name',  'LIKE', '%' . $request->get('name') . '%')->paginate(10);
        }
        if ($request->get('orderBy') == null && $request->get('name') == null &&  $request->get('from') == null &&  $request->get('lat') == null) {
            $Jobs = Job::orderBy('created_at', 'desc')->with('JobSalary')->paginate(10);
        }
        $user = $request->user('worker_api')->id;
        $resonseData = [];
        foreach ($Jobs as $key => $Job) {

            $resonseData['job'][$key]['id']         = $Job->id;
            $resonseData['job'][$key]['name']       = $Job->fname;
            $resonseData['job'][$key]['desc']       = $Job->fdesc;
            $resonseData['job'][$key]['salary']       = $Job->salary;
            $resonseData['job'][$key]['duration']       = $Job->JobSalary->name;
            $resonseData['job'][$key]['status']       = $Job->status;
            $request = JobRequest::where('job_id', $Job->id)
                ->where('worker_id', $user)->first();

            if ($request != null) {
                $resonseData['job'][$key]['request_appliad']       = true;
            } else {
                $resonseData['job'][$key]['request_appliad']       = false;
            }
        }
        $pagination['count'] = $Jobs->count();
        $pagination['hasMorePages'] = $Jobs->hasMorePages();
        $pagination['currentPage'] = $Jobs->currentPage();
        $pagination['firstItem'] = $Jobs->firstItem();
        $pagination['last_page_id'] = $Jobs->lastPage();
        $pagination['per_page'] = $Jobs->perPage();
        $pagination['nextPageUrl'] = $Jobs->nextPageUrl();
        $pagination['onFirstPage'] = $Jobs->onFirstPage();
        $pagination['previousPageUrl'] = $Jobs->previousPageUrl();
        $resonseData['paginate'] = $pagination;

        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $resonseData
        ]);
    }

    public function indexMyJobsWorker(Request $request)
    {
        $Jobs = JobRequest::with(['Job' => function ($query) {
            $query->with('JobSalary');
        }])->where('worker_id', $request->user('worker_api')->id)->where('send_type', 'by_worker')->orderBy('created_at', 'desc');
        if ($request->get('orderBy') == 'desc') {
            $Jobs = JobRequest::orderBy('created_at', 'desc');
        } elseif ($request->get('orderBy') == 'asc') {
            $Jobs = JobRequest::orderBy('created_at', 'asc');
        }
        if ($request->get('from')) {
            $Jobs = JobRequest::whereBetween('created_at', [$request->get('from'), $request->get('to')]);
        }

        if ($request->get('name')) {
            $Jobs = JobRequest::where('name',  'LIKE', '%' . $request->get('name') . '%');
        }
        if ($request->get('city_id')) {
            $Jobs = JobRequest::with(['Job' => function ($query) use ($request) {
                $query->with('JobSalary');
            }])->whereHas('Job', function ($query)use($request) {
                $query->where('city_id',  $request->get('city_id'));
            })->where('worker_id', $request->user('worker_api')->id)->where('send_type', 'by_worker')->orderBy('created_at', 'desc');
        }
        $Jobs = $Jobs->paginate(10);
        $resonseData = [];
        foreach ($Jobs as $key => $Job) {
            if ($Job->job != null) {
            $resonseData['job'][$key]['id']         = $Job->id;
            $resonseData['job'][$key]['name']       = $Job->Job->fname;
            $resonseData['job'][$key]['desc']       = $Job->Job->fdesc;
            $resonseData['job'][$key]['salary']       = $Job->Job->salary;
            $resonseData['job'][$key]['duration']       = $Job->Job->JobSalary->name;
            $resonseData['job'][$key]['status']       = $Job->Job->status;
            $resonseData['job'][$key]['created_at']       = $Job->created_at;
            }
        }
        $pagination['count'] = $Jobs->count();
        $pagination['hasMorePages'] = $Jobs->hasMorePages();
        $pagination['currentPage'] = $Jobs->currentPage();
        $pagination['firstItem'] = $Jobs->firstItem();
        $pagination['last_page_id'] = $Jobs->lastPage();
        $pagination['per_page'] = $Jobs->perPage();
        $pagination['nextPageUrl'] = $Jobs->nextPageUrl();
        $pagination['onFirstPage'] = $Jobs->onFirstPage();
        $pagination['previousPageUrl'] = $Jobs->previousPageUrl();
        $resonseData['paginate'] = $pagination;

        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $resonseData
        ]);
    }

    public function indexMyJobsWorkerInvited(Request $request)
    {
        $Jobs = JobRequest::with(['contrator'])
            ->where('worker_id', $request->user('worker_api')->id)->where('send_type', 'by_contractor')->orderBy('created_at', 'desc');


        if ($request->get('orderBy') == 'desc') {
            $Jobs = JobRequest::orderBy('created_at', 'desc');
        } elseif ($request->get('orderBy') == 'asc') {
            $Jobs = JobRequest::orderBy('created_at', 'asc');
        }
        if ($request->get('from')) {
            $Jobs = JobRequest::whereBetween('created_at', [$request->get('from'), $request->get('to')]);
        }

        if ($request->get('name')) {
            $Jobs = JobRequest::where('name',  'LIKE', '%' . $request->get('name') . '%');
        }
        if ($request->get('city_id')) {

            $Jobs = JobRequest::with(['contrator' => function ($query) use ($request) {
                $query->with('city', 'workType');
            }])->whereHas('contrator', function ($query) use ($request) {
                $query->where('city_id',  $request->get('city_id'));
            })
                ->where('worker_id', $request->user('worker_api')->id)->where('send_type', 'by_contractor')->orderBy('created_at', 'desc');
        }
        $Jobs = $Jobs->paginate(10);

        $resonseData = [];
        foreach ($Jobs as $key => $Job) {
            if ($Job->contrator != null) {


                $resonseData['job'][$key]['id']         = $Job->id;
                if ($Job->contractor_id != null) {
                    $resonseData['job'][$key]['contractor']       = $Job->contrator->name;

                    $resonseData['job'][$key]['workType']       = $Job->contrator->workType->name;
                    $resonseData['job'][$key]['city']       = $Job->contrator->city->name;
                }
                $resonseData['job'][$key]['created_at']       = $Job->created_at;
            }
        }
        $pagination['count'] = $Jobs->count();
        $pagination['hasMorePages'] = $Jobs->hasMorePages();
        $pagination['currentPage'] = $Jobs->currentPage();
        $pagination['firstItem'] = $Jobs->firstItem();
        $pagination['last_page_id'] = $Jobs->lastPage();
        $pagination['per_page'] = $Jobs->perPage();
        $pagination['nextPageUrl'] = $Jobs->nextPageUrl();
        $pagination['onFirstPage'] = $Jobs->onFirstPage();
        $pagination['previousPageUrl'] = $Jobs->previousPageUrl();
        $resonseData['paginate'] = $pagination;

        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $resonseData
        ]);
    }
    public function workType()
    {
        $WorkType = WorkType::where('status', 'active')->get();
        $resonseData = [];
        foreach ($WorkType as $key => $WorkTypes) {

            $resonseData['WorkTypes'][$key]['id']         = $WorkTypes->id;
            $resonseData['WorkTypes'][$key]['name']       = $WorkTypes->name;
        }
        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $resonseData
        ]);
    }

    public function city(Request $request)
    {
        $Cities = City::all();
        $responseData = [];

        foreach ($Cities as $key => $city) {
            $responseData['city'][$key]['id'] = $city->id;
            $responseData['city'][$key]['name'] = $city->name;
        }
        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $responseData
        ]);
    }
    public function currencies(Request $request)
    {
        $currency = currency::all();
        $responseData = [];

        foreach ($currency as $key => $currencies) {
            $responseData['currency'][$key]['id'] = $currencies->id;
            $responseData['currency'][$key]['name'] = $currencies->name;
        }
        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $responseData
        ]);
    }
    public function JobSalary(Request $request)
    {
        $JobSalary = JobSalary::all();
        $responseData = [];

        foreach ($JobSalary as $key => $JobSalars) {
            $responseData['JobSalary'][$key]['id'] = $JobSalars->id;
            $responseData['JobSalary'][$key]['name'] = $JobSalars->name;
        }
        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $responseData
        ]);
    }
}
