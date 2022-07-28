<?php

namespace App\Http\Controllers\API;

use App\Helpers\Messages;
use App\Http\Controllers\ControllersService;
use App\Models\Contractor;
use App\Models\EmailWorker;
use App\Models\MobileWorker;
use App\Models\Worker;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

use Symfony\Component\HttpFoundation\Response;

class ContractorApiAuthController extends AuthBaseController
{

    private $client_id = '95c7cab6-e1e9-47da-94b0-c8efca9ff268';
    //
    //php artisan passport:client --personal
    public function login(Request $request)
    {
        $roles = [
            'id_number' => 'required|string|exists:contractors,id_number',
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
            $user = Contractor::where("id_number", $request->get('id_number'))->select('id', 'first_name', 'father_name', 'grand_name', 'family_name', 'email', 'id_number', 'mobile')->first();
            if ($user && $user->status = 'Active') {
                $this->revokePreviousTokens($this->client_id, $user->id);

                return $this->passwordGrantLogin($request, $user, 'LOGGED_IN_SUCCESSFULLY');
            } else {
                return ControllersService::generateProcessResponse(false, 'ERROR_CREDENTIALS');
            }
        } else {
            return ControllersService::generateValidationErrorMessage($validator->getMessageBag()->first());
        }
    }
    public function profile(Request $request)
    {
        $userId = $request->user('contractor_api')->id;
        $user = Contractor::with('workType', 'city')->find($userId);
        $resonseData['id']         = $user->id;
        $resonseData['first_name']       = $user->name;
        $resonseData['father_name']       = $user->fname;
        $resonseData['grand_name']       =  $user->gname;
        $resonseData['family_name']       = $user->faname;
        $resonseData['mobile']       = $user->mobile;
        $resonseData['email']       = $user->email;
        $resonseData['workType']       = $user->workType->name;
        $resonseData['city_id']       = $user->city_id;
        $resonseData['work_type_id']       = $user->work_type_id;

        $resonseData['city']       = $user->city->name;

        $resonseData['id_number']       = $user->id_number;
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
            'mobile' => 'required|unique:contractors,mobile',
            'email' => 'required|email|unique:contractors',
            'image' => 'required',
            'id_number' => 'required|unique:contractors,id_number',
            'license' => 'required',
            'work_field' => 'required',
            'city_id' => 'required',

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
                'work_field.required' => ' :مجال العمل  مطلوب.',
                'mobile.required' => ' :الرقم الهاتف  مطلوب.',
                'license.required' => ' :الترخيص  مطلوب.',



            ];
        }
        $validator = Validator::make($request->all(), $roles, $customMessages);
        if (!$validator->fails()) {
            $user = new Contractor();
            $user->first_name = $request->get('first_name');
            $user->father_name = $request->get('father_name');
            $user->grand_name = $request->get('grand_name');
            $user->family_name = $request->get('family_name');
            $user->email = $request->get('email');
            $user->id_number = $request->get('id_number');
            $user->mobile = $request->get('mobile');
            $user->status = 'Active';
            $user->code = mt_rand(1000, 9999);
            $user->license = $request->get('license');
            $user->work_type_id = $request->get('work_field');
            $user->city_id = $request->get('city_id');
            if ($request->hasFile('image')) {
                $userImage = $request->file('image');
                $imageName = time() . '_' . $request->get('first_name') . '.' . $userImage->getClientOriginalExtension();
                $userImage->move('images/contractor', $imageName);
                $user->photo = '/images/contractor/' . $imageName;
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

    public function update_profile(Request $request)
    {

        $userId = $request->user('contractor_api')->id;
        $roles = [
            'first_name' => 'nullable|string|min:3',
            'father_name' => 'nullable|string|min:3',
            'grand_name' => 'nullable|string|min:3',
            'family_name' => 'nullable|string|min:3',
            'mobile' => 'nullable|unique:contractors,mobile,' . $userId,
            'email' => 'nullable|email|unique:contractors,email,' . $userId,
            'id_number' => 'nullable|unique:contractors,id_number,' . $userId,
        ];
        $validator = Validator::make($request->all(), $roles);
        if (!$validator->fails()) {
            $user =  Contractor::find($userId);
            $user->first_name = $request->get('first_name');
            $user->father_name = $request->get('father_name');
            $user->grand_name = $request->get('grand_name');
            $user->family_name = $request->get('family_name');
            $user->mobile = $request->get('mobile');
            $user->email =  $request->get('email');
            $user->id_number = $request->get('id_number');
            $user->company_name = $request->get('company_name');
            $user->work_type_id = $request->get('work_field');
            $user->city_id = $request->get('city_id');

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


    public function updateDoc(Request $request)
    {
        $userId = $request->user('contractor_api')->id;
        $roles = [
            'id_card' => 'nullable',
            'license' => 'nullable',
            'other_doc' => 'nullable',
        ];
        $validator = Validator::make($request->all(), $roles);
        if (!$validator->fails()) {
            $user =  Contractor::find($userId);
            if ($request->hasFile('id_card')) {
                $userImage = $request->file('id_card');
                $imageName = time() . '_' . $request->get('first_name') . '.' . $userImage->getClientOriginalExtension();
                $userImage->move('files/id_card', $imageName);
                $user->id_card = '/files/id_card/'  . $imageName;
            }
            if ($request->hasFile('license')) {
                $userImage = $request->file('license');
                $imageName = time() . '_' . $request->get('first_name') . '.' . $userImage->getClientOriginalExtension();
                $userImage->move('files/license', $imageName);
                $user->license = '/files/license/' . $imageName;
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

    public function resetPassword(Request $request)
    {
        $roles = [
            'new_password' => 'required|string',
            'new_password_confirmation' => 'required|string|same:new_password'
        ];
        $validator = Validator::make($request->all(), $roles);
        if (!$validator->fails()) {
            $userId = $request->user('contractor_api')->id;
            $user =  Contractor::find($userId);
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
        $userId = $request->user('contractor_api')->id;
        $cont = Contractor::find($userId);
        $roles = [
            'email' => 'required|email|unique:email_workers',
        ];
        $validator = Validator::make($request->all(), $roles);
        if (!$validator->fails()) {
            $user =  new EmailWorker();

            $user->user()->associate($cont);
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
        $userId = $request->user('contractor_api')->id;
        $cont = Contractor::find($userId);

        $roles = [
            'mobile' => 'required|unique:mobile_workers,mobile',
        ];
        $validator = Validator::make($request->all(), $roles);
        if (!$validator->fails()) {
            $user =  new MobileWorker();
            $user->user()->associate($cont);
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
        $userId = $request->user('contractor_api')->id;
        $users = EmailWorker::where('user_id', $userId)->where('user_type', 'App\Models\Contractor')->get();
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
        $userId = $request->user('contractor_api')->id;
        $users = MobileWorker::where('user_id', $userId)->where('user_type', 'App\Models\Contractor')->get();
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
    public function addPassword(Request $request)
    {

        $roles = [
            'password' => 'required|string',
            'new_password_confirmation' => 'required|string|same:password'
        ];

        $validator = Validator::make($request->all(), $roles);
        if (!$validator->fails()) {
            $userId = $request->get('id_number');
            $user =  Contractor::where('id_number', $userId)->first();
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
    public function passwordGrantLogin(Request $request, $user, $message)
    {
        try {
            $response = Http::asForm()->post('https://ommal.net/oauth/token', [
                'grant_type' => 'password',
                'client_id' => $this->client_id,
                'client_secret' => 'nf7VlTmDAfFHJEbV7Hi32ZsTKuU6K93qBUwaNEL2',
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


    public function logoutClient(Request $request)
    {
        parent::logout($request, 'client_api');
        return response()->json([
            'status' => true,
            'message' => 'Successfully logged out'
        ]);
    }
}
