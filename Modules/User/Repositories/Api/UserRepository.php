<?php

namespace Modules\User\Repositories\Api;

use DB;
use File;
use Hash;
use Modules\User\Entities\User;
use Modules\User\Enums\UserType;
use Illuminate\Support\Facades\Storage;
use Modules\Core\Packages\SMS\SmsGetWay;
use Modules\User\Entities\UserTransaction;
use Modules\Transaction\Services\PaymentService;
use Modules\User\Notifications\UserReachToDeposit;

class UserRepository
{
    public function __construct(User $user, SmsGetWay $sms)
    {
        $this->user      = $user;
        $this->sms       = $sms;
    }


    public function findById($id, $with=[], $withCount=[])
    {
        return  $this->user->with($with)->withCount($withCount)->where("id", $id)->firstOrFail();
    }
    public function update($request)
    {
        $user = auth()->user();
        $image = $user->image;
        if ($request->image) {
            deleteFileInStroage($user->image);
            $image = pathFileInStroage($request, "image", "users");
        }
        $firebase_uuid = $user->firebase_uuid;
        if ($request->firebase_uuid) {
            $firebase_uuid = $request->firebase_uuid;
        }

        $data = [
            'name'          => $request['name'],
            'email'         => $request['email'],
            'mobile'        => $request['mobile'],
            'phone_code'    => $request['phone_code'],
            "image"         => $image ,
            "firebase_uuid" => $firebase_uuid
        ];

        if (config("app.have_sms")) {
            if ($user->phone_code != $request['phone_code'] || $user->mobile != $request['mobile']) {
                $data = array_merge(
                    $data,
                    [
                            "is_verified" => false,
                            "code_verified" =>  generateRandomCode(5),
                        ]
                );
            }
        }



        DB::beginTransaction();
        try {
            $user->update($data);

            DB::commit();
            if ($user->is_verified == false && $user->code_verified) {
                \Message::send([
                    'phone' => str_replace('+','',$user->getPhone()),
                    'body'  => 'Your Verification Code is : '. $user->code_verified,
                ]);
            }
            if (is_callable([UserType::class, $user->type])) {
                (new UserType)->{$user->type}($user, $request);
            }
            return $user;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function rateUser($request)
    {
        $user = auth()->user();
        $user->givingRates()->updateOrCreate(["user_id"=> $request->user_id], $request->validated());
    }

    public function getUserRate($request, $id)
    {
        $user = $this->findById($id, [], [
                "rates as rates_avg"=>function ($query) {
                    $query->select(DB::raw('ROUND( IFNULL(AVG(user_rates.rate),0) , 1)'));
                },
                "rates"
            ]);

        $data["user"] = $user;

        if ($request->user_id) {
            $data["current_user_rate"] =  $user->rates()->where("from_id", $request->user_id)->first();
        }
        return $data;
    }

    public function createOrUpdateOffice(&$request)
    {
        $user = auth()->user();

        $old = $user->office;
        $image = "/uploads/default.png";
        if ($request->image) {
            if ($old && $old->image) {
                deleteFileInStroage($old->image);
            }
            $image = pathFileInStroage($request, "image", "users/".$user->id);
        }
        $data = array_merge($request->validated(), ["image"=> $image]);


        DB::beginTransaction();
        try {
            $user->office()->updateOrCreate(["user_id"=> $user->id], $data);
            if ($user->type != "office") {
                $user->update(["type"=>"office"]);
            }
            DB::commit();
            return $user;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function updatePassword(&$user, &$request)
    {
        try {
            $user->update([

                'password'      => bcrypt($request->new_password),

            ]);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }


    public function userProfile($with= [])
    {
        return auth()->user()->load($with);
    }





    public function updateSetting(&$request)
    {
        DB::beginTransaction();
        $user = auth()->user();
        $setting = array_merge($user->setting ? $user->setting : ["lang"=>"ar"], $request->all());
        try {
            $user->update([
                'setting'      => $setting ,
            ]);

            if ($request->has("lang")) {
                $user->deviceTokens()->update([
                    "lang"=> $setting["lang"]
                ]);
            }


            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
