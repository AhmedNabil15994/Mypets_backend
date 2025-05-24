<?php

namespace Modules\User\Enums;

class UserType extends \SplEnum
{
    const USER  = "user";
    const ADMIN = "admin";
    const COMPANY = "company";
    const TECHNICAL = "technical";


    public function company($user, $request)
    {
        // dd($request->all());
        $company = $user->company;
        $data = [
            "title"             => $request->title,
            "description_work"  => $request->description_work,
            "state_id"          => $request->state_id,
            "city_id"           => $request->city_id,
            "user_id"           => $user->id,
            "delivery_receive"  => $request->delivery_receive ?? 0,
            "socials"           => $request->socials,
            'lat'               => $request->lat,
            'long'              => $request->long
        ];

        if (optional($company)->document && $request->document) {
            deleteFileInStroage($company->document);
        }

        if (optional($company)->cover && $request->cover) {
            deleteFileInStroage($company->cover);
        }

        if ($request->cover) {
            $data["cover"] =  pathFileInStroage($request, "cover", "companies/" . $user->id . "/");
        }
        if ($request->document) {
            $data["document"] =  pathFileInStroage($request, "document", "companies/" . $user->id . "/");
        }

        if ($company) {
            $company->update($data);
        } else {
            $company = $user->company()->create($data);
        }

        $company->categories()->sync($request->categories ?? []);

        return $company;
    }

    public static function load($user)
    {
        switch ($user->type) {
            case 'company':
                return ["company.categories", "company.state", "company.city"];
                break;

            default:
                return [];
                break;
        }
    }

    public static function routeSelect2($type)
    {
        return route('dashboard.users.list_select');
    }
}
