<?php

namespace App\services\UserServices;

use App\Mail\VerificationEmail;
use App\Models\Author;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class RegisterService
{
    protected $model;
    function __construct()
    {
        $this->model = new User();
    }

    function register($request) : JsonResponse
    {
        try {
            DB::beginTransaction();
            $data = $this->validation($request);
            $user = $this->store($data , $request);

            $this->model = $user;
            $this->generateToken($user->email);

            $this->sendEmail($user);
            DB::commit();
            return response()->json([
                "message" => "account has been created check your email"
            ]);
        }catch (Exception $e){
            return response()->json(["error" => $e->getMessage()], 400);
        }

    }

    public function validation($request)
    {
        $validator = Validator::make($request->all(), $request->rules());
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        return $validator;
    }
    function store($data , $request) : User
    {
        $user = $this->model->create(array_merge(
            $data->validated(),
            ['password' => bcrypt($request->password)]
        ));
        return $user;
    }
    function generateToken($email) : void
    {
        $token = substr(md5( rand(0 , 9) . $email . time()) , 0 , 32);
        $this->model->verification_token = $token;
        $this->model->save();

    }

    function sendEmail($user) : void
    {
        Mail::to($user->email)->send(new VerificationEmail($user));
    }
}
