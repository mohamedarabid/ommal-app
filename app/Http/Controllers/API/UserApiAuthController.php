<?php

namespace App\Http\Controllers\API;

use App\Helpers\Messages;
use App\Http\Controllers\ControllersService;
use App\Models\EmailWorker;
use App\Models\MobileWorker;
use App\Models\Worker;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

use Symfony\Component\HttpFoundation\Response;

class UserApiAuthController extends AuthBaseController
{

    private $client_id = '95c5ca8d-f2f0-4d8e-abdb-d2c42fc85d17';
    //
    //php artisan passport:client --personal
    public function login(Request $request)
    {
        $roles = [
            'id_number' => 'required|string|exists:workers,id_number',
            'password' => 'required',
        ];
        if (request()->header('lang') == 'en') {
            $customMessages = [
                'exists' => 'The :attribute field is exists.',
                'required' => 'The :attribute field is required.'
            ];
        } else {
            $customMessages = [
                'id_number.exists' => ' رقم الهويه غير مسجل مسبقا',
                'password.required' => 'كلمة المرور مطلوبه',
                'id_number.required' => ' رقم الهوية مطلوبه'

            ];
        }
        $validator = Validator::make($request->all(), $roles, $customMessages);
        if (!$validator->fails()) {

            $user = Worker::where("id_number", $request->get('id_number'))->select('id', 'first_name', 'father_name', 'grand_name', 'family_name', 'email', 'id_number', 'mobile')->first();
            if ($user && $user->status = 'Active') {
                $this->revokePreviousTokens($this->client_id, $user->id);

                return $this->passwordGrantLogin($request, $user, 'LOGGED_IN_SUCCESSFULLY');
            } else {
                return ControllersService::generateProcessResponse(false, 'ERROR_CREDENTIALS');
            }
        } else {
            return ControllersService::generateValidationErrorMessage($validator->errors()->first());
        }
    }
    public function profile(Request $request)
    {
        $userId = $request->user('worker_api')->id;
        $user = Worker::find($userId);

        $resonseData['id']         = $user->id;
        $resonseData['first_name']       = $user->name;
        $resonseData['father_name']       = $user->fname;
        $resonseData['grand_name']       =  $user->gname;
        $resonseData['family_name']       = $user->faname;
        $resonseData['mobile']       = $user->mobile;
        $resonseData['email']       = $user->email;
        $resonseData['id_number']       = $user->id_number;
        $resonseData['experiences']       = $user->exname;
        $resonseData['experiences_years']       = $user->years_experiences;
        $resonseData['city_id']       = $user->city_id;
        $resonseData['Work_field_id']       = $user->Work_field_id;
        $resonseData['city']       = $user->city->name;
        $resonseData['address']       = $user->adname;


        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $resonseData
        ]);
    }
    public function register(Request $request)
    {
        $roles = [
            'first_name' => 'required|string|min:3',
            'father_name' => 'required|string|min:3',
            'grand_name' => 'required|string|min:3',
            'family_name' => 'required|string|min:3',
            'mobile' => 'required|unique:workers,mobile',
            'email' => 'required|email|unique:workers',
            'id_number' => 'required|unique:workers,id_number',
            'Work_field_id' => 'required',

        ];
        if (request()->header('lang') == 'en') {
            $customMessages = [
                'unique' => 'The :attribute field is Must be unique.',
                'required' => 'The :attribute field is required.'

            ];
        } else {
            $customMessages = [
                'mobile.unique' => 'رقم الهاتف مسجل مسبقا',
                'id_number.unique' => 'رقم الهوية مسجل مسبقا',
                'first_name.required' => ' :الاسم الاول  مطلوب.',
                'father_name.required' => ' :الاسم الاب  مطلوب.',
                'grand_name.required' => ' :الاسم الجد  مطلوب.',
                'family_name.required' => ' :الاسم العائلة  مطلوب.',
                'family_name.required' => ' :الاسم العائلة  مطلوب.',
                'email.required' => ' :الاميل  مطلوب.',
                'id_number.required' => ' :رقم الهويه  مطلوب.',
                'Work_field_id.required' => ' :مجال العمل  مطلوب.',
                'mobile.required' => ' :الرقم الهاتف  مطلوب.',

            ];
        }
        $validator = Validator::make($request->all(), $roles, $customMessages);

        if (!$validator->fails()) {
            $user = new Worker();
            $user->first_name = $request->get('first_name');
            $user->father_name = $request->get('father_name');
            $user->grand_name = $request->get('grand_name');
            $user->family_name = $request->get('family_name');
            $user->email = $request->get('email');
            $user->id_number = $request->get('id_number');
            $user->mobile = $request->get('mobile');
            $user->city_id = $request->get('city_id');
            $user->address = $request->get('address');
            $user->Work_field_id = $request->get('Work_field_id');

            $user->status = 'Active';
            $user->code = mt_rand(1000, 9999);

            $isSaved = $user->save();
            if ($isSaved) {
                return ControllersService::generateProcessResponse(true, 'CREATE_SUCCESS');
            } else {
                return ControllersService::generateProcessResponse(false, 'LOGIN_IN_FAILED');
            }
        } else {

            return ControllersService::generateValidationErrorMessage($validator->errors()->first(), 402);
        }
    }

    public function update_profile(Request $request)
    {

        $userId = $request->user('worker_api')->id;
        $roles = [
            'first_name' => 'nullable|string|min:3',
            'father_name' => 'nullable|string|min:3',
            'grand_name' => 'nullable|string|min:3',
            'family_name' => 'nullable|string|min:3',
            'mobile' => 'nullable|unique:workers,mobile,' . $userId,
            'email' => 'nullable|email|unique:workers,email,' . $userId,
            'id_number' => 'nullable|unique:workers,id_number,' . $userId,
            'birthday' => 'nullable|date_format:Y-m-d|before:-10 years',
            'city_id' => 'nullable|integer|exists:cities,id',

        ];
        $validator = Validator::make($request->all(), $roles);
        if (!$validator->fails()) {
            $user =  Worker::find($userId);
            $user->first_name = $request->get('first_name');
            $user->father_name = $request->get('father_name');
            $user->grand_name = $request->get('grand_name');
            $user->family_name = $request->get('family_name');
            $user->mobile = $request->get('mobile');
            $user->email =  $request->get('email');
            $user->id_number = $request->get('id_number');
            $user->marriage_date = $request->get('marriage_date');
            $user->city_id = $request->get('city_id');
            $user->address = $request->get('address');
            $user->birthday = $request->get('birthday');


            $isSaved = $user->save();
            if ($isSaved) {
                return ControllersService::generateProcessResponse(true, 'USER_UPDATED_SUCCESS');
            } else {
                return ControllersService::generateProcessResponse(false, 'LOGIN_IN_FAILED');
            }
        } else {
            return ControllersService::generateValidationErrorMessage($validator->getMessageBag()->first());
        }
    }

    public function updateExperiences(Request $request)
    {
        $userId = $request->user('worker_api')->id;
        $roles = [
            'experiences' => 'nullable|string|min:30',
            'years_experiences' => 'nullable',
        ];
        $validator = Validator::make($request->all(), $roles);
        if (!$validator->fails()) {
            $user =  Worker::find($userId);
            $user->experiences = $request->get('experiences');
            $user->years_experiences = $request->get('years_experiences');
            $user->Work_field_id = $request->get('Work_field_id');

            $isSaved = $user->save();
            if ($isSaved)
                return ControllersService::generateProcessResponse(true, 'USER_UPDATED_SUCCESS');
        } else {
            return ControllersService::generateValidationErrorMessage($validator->getMessageBag()->first());
        }
    }
    public function updateDoc(Request $request)
    {
        $userId = $request->user('worker_api')->id;
        $roles = [
            'id_card' => 'nullable',
            'magnetic_card' => 'nullable',
            'permission_card' => 'nullable',
            'bank_paper' => 'nullable',
            'other_doc' => 'nullable',
        ];
        $validator = Validator::make($request->all(), $roles);
        if (!$validator->fails()) {
            $user =  Worker::find($userId);
            if ($request->hasFile('id_card')) {
                $userImage = $request->file('id_card');
                $imageName = time() . '_' . $request->get('first_name') . '.' . $userImage->getClientOriginalExtension();
                $userImage->move('files/id_card', $imageName);
                $user->id_card = '/files/id_card/' . $imageName;
            }
            if ($request->hasFile('magnetic_card')) {
                $userImage = $request->file('magnetic_card');
                $imageName = time() . '_' . $request->get('first_name') . '.' . $userImage->getClientOriginalExtension();
                $userImage->move('files/magnetic_card', $imageName);
                $user->magnetic_card = '/files/magnetic_card/' . $imageName;
            }
            if ($request->hasFile('permission_card')) {
                $userImage = $request->file('permission_card');
                $imageName = time() . '_' . $request->get('first_name') . '.' . $userImage->getClientOriginalExtension();
                $userImage->move('files/permission_card', $imageName);
                $user->permission_card = '/files/permission_card/'  . $imageName;
            }
            if ($request->hasFile('bank_paper')) {
                $userImage = $request->file('bank_paper');
                $imageName = time() . '_' . $request->get('first_name') . '.' . $userImage->getClientOriginalExtension();
                $userImage->move('files/bank_paper', $imageName);
                $user->bank_paper = '/files/bank_paper/'  . $imageName;
            }
            if ($request->hasFile('other_doc')) {
                $userImage = $request->file('other_doc');
                $imageName = time() . '_' . $request->get('first_name') . '.' . $userImage->getClientOriginalExtension();
                $userImage->move('files/other_doc', $imageName);
                $user->other_doc = '/files/other_doc/'  . $imageName;
            }
            $isSaved = $user->save();
            if ($isSaved)
                return ControllersService::generateProcessResponse(true, 'USER_UPDATED_SUCCESS');
        } else {
            return ControllersService::generateValidationErrorMessage($validator->getMessageBag()->first());
        }
    }
    public function addPassword(Request $request)
    {

        $roles = [
            'password' => 'required|string',
            'new_password_confirmation' => 'required|string|same:password'
        ];

        $validator = Validator::make($request->all(), $roles);
        if (!$validator->fails()) {
            $userId = $request->get('id_number');
            $user =  Worker::where('id_number', $userId)->first();
            $user->password = Hash::make($request->get('password'));
            $isSaved = $user->save();
            if ($isSaved) {
                return $this->passwordGrantLogin($request, $user, 'LOGGED_IN_SUCCESSFULLY');
            } else {
                return ControllersService::generateProcessResponse(false, 'CREATE_FAILED');
            }
        } else {
            return ControllersService::generateValidationErrorMessage($validator->getMessageBag()->first());
        }
    }
    public function resetPassword(Request $request)
    {
        $roles = [
            'new_password' => 'required|string',
            'new_password_confirmation' => 'required|string|same:new_password'
        ];
        $validator = Validator::make($request->all(), $roles);
        if (!$validator->fails()) {
            $userId = $request->user('worker_api')->id;
            $user =  Worker::find($userId);
            $user->password = Hash::make($request->get('new_password'));
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
    public function emails(Request $request)
    {
        $userId = $request->user('worker_api')->id;
        $Worker =  Worker::find($userId);

        $roles = [
            'email' => 'required|email|unique:email_workers',
        ];
        $validator = Validator::make($request->all(), $roles);
        if (!$validator->fails()) {
            $user =  new EmailWorker();
            $user->user()->associate($Worker);
            $user->email = $request->get('email');
            $isSaved = $user->save();
            if ($isSaved)
                return ControllersService::generateProcessResponse(true, 'CREATE_SUCCESS');
        } else {
            return ControllersService::generateValidationErrorMessage($validator->getMessageBag()->first());
        }
    }
    public function mobile(Request $request)
    {
        $userId = $request->user('worker_api')->id;
        $Worker =  Worker::find($userId);
        $roles = [
            'mobile' => 'required|unique:mobile_workers,mobile',
        ];
        $validator = Validator::make($request->all(), $roles);
        if (!$validator->fails()) {
            $user =  new MobileWorker();
            $user->user()->associate($Worker);
            $user->mobile = $request->get('mobile');
            $isSaved = $user->save();
            if ($isSaved)
                return ControllersService::generateProcessResponse(true, 'CREATE_SUCCESS');
        } else {
            return ControllersService::generateValidationErrorMessage($validator->getMessageBag()->first());
        }
    }
    public function DeleteMobile(Request $request, $id)
    {

        $isDelete =  MobileWorker::destroy($id);
        return ControllersService::generateProcessResponse(true, $isDelete ? 'DELETE_SUCCESS' : 'DELETE_FAILED');
    }
    public function DeleteEmail(Request $request, $id)
    {

        $isDelete =  EmailWorker::destroy($id);
        return ControllersService::generateProcessResponse(true, $isDelete ? 'DELETE_SUCCESS' : 'DELETE_FAILED');
    }
    public function showEmails(Request $request)
    {
        $userId = $request->user('worker_api')->id;
        $users = EmailWorker::where('user_id', $userId)->where('user_type', 'App\Models\Worker')->get();
        $resonseData = [];
        foreach ($users as $key => $user) {
            $resonseData['worker'][$key]['id'] = $user->id;
            $resonseData['worker'][$key]['email'] = $user->email;
        }
        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $resonseData
        ]);
    }
    public function showMobile(Request $request)
    {
        $userId = $request->user('worker_api')->id;
        $users = MobileWorker::where('user_id', $userId)->where('user_type', 'App\Models\Worker')->get();
        $resonseData = [];
        foreach ($users as $key => $user) {
            $resonseData['worker'][$key]['id'] = $user->id;
            $resonseData['worker'][$key]['mobile'] = $user->mobile;
        }
        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $resonseData
        ]);
    }
    public function passwordGrantLogin(Request $request, $user, $message)
    {

        try {
            $response = Http::asForm()->post('https://ommal.net/oauth/token', [
                'grant_type' => 'password',
                'client_id' => $this->client_id,
                'client_secret' => '5oxxNdKGSTCXtmJZsBhUkzHhmzBKmsaG8E3eBXYP',
                'username' => $user->email,
                'password' => $request->input('password'),
                'scope' => '*',
            ]);
            $user->setAttribute('token', $response->json()['access_token']);
            $user->setAttribute('token_type', $response->json()['token_type']);
            return response()->json([
                'status' => true,
                'message' => Messages::getMessage($message),
                'object' => $user,
            ]);
        } catch (\Throwable $th) {
            return response()->json($response->json(), Response::HTTP_UNAUTHORIZED);
        }
    }
    public function allWorker(Request $request)
    {

        $resonseData = [];
        $users = Worker::with(['workType', 'city']);


        if ($request->get('city_id')) {
            $users = $users->where('city_id', $request->get('city_id'));
        }
        if ($request->get('work_filed_id')) {
            $users = $users->where('Work_field_id', $request->get('work_filed_id'));
        }
        if ($request->get('name')) {
            $users = $users->where('first_name',  'LIKE', '%' . $request->get('name') . '%');
        }
        $users = $users->paginate(10);
        foreach ($users as $key => $user) {
            $resonseData['worker'][$key]['id']         = $user->id;
            $resonseData['worker'][$key]['first_name']       = $user->name;
            $resonseData['worker'][$key]['father_name']       = $user->fname;
            $resonseData['worker'][$key]['grand_name']       =  $user->gname;
            $resonseData['worker'][$key]['family_name']       = $user->faname;
            $resonseData['worker'][$key]['city']       = $user->city->name;
        }
        $pagination['count'] = $users->count();
        $pagination['hasMorePages'] = $users->hasMorePages();
        $pagination['currentPage'] = $users->currentPage();
        $pagination['firstItem'] = $users->firstItem();
        $pagination['last_page_id'] = $users->lastPage();
        $pagination['per_page'] = $users->perPage();
        $pagination['nextPageUr l'] = $users->nextPageUrl();
        $pagination['onFirstPage'] = $users->onFirstPage();
        $pagination['previousPageUrl'] = $users->previousPageUrl();
        $resonseData['paginate'] = $pagination;
        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $resonseData
        ]);
    }
    public function indexWorker(Request $request, $id)
    {
        $user = Worker::with('workType', 'city')->find($id);
        $resonseData['id']         = $user->id;
        $resonseData['first_name']       = $user->name;
        $resonseData['father_name']       = $user->fname;
        $resonseData['grand_name']       =  $user->gname;
        $resonseData['family_name']       = $user->faname;
        $resonseData['city']       = $user->city->name;
        $resonseData['address']       = $user->faddress;
        $resonseData['experiences']       = $user->experiences;
        $resonseData['years_experiences']       = $user->years_experiences;
        $resonseData['work_filed']       = $user->workType->name;
        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $resonseData
        ]);
    }

    public function logoutClient(Request $request)
    {
        parent::logout($request, 'client_api');
        return response()->json([
            'status' => true,
            'message' => 'Successfully logged out'
        ]);
    }
}
