<?php

namespace App\Http\Controllers;

use App\Models\UserWall;
use Illuminate\Http\Request;
use VK\Client\VKApiClient;

class UserWallController extends Controller
{
    private string $token;
    private VKApiClient $vk;

    public function __construct()
    {
        $this->vk = new VKApiClient();
        $this->token = 'vk1.a.Qt8CpS-9-4WT5v26wQm4S3j89VlXr_4GppDW0RZutUgVqAHEbt8H9zYP6WBC2B4H0MvNW_TDfYaEGZbYr2oTvHFgEH05Y63MnUE-_uhzmQpkUybNEtJbJj97qdm1oviPK75t7ZZINei5x8AJTsKw5mN9AtZb3-7mKNcmZ3RA6lC2xQXwTQ7jZ2gUzo6QNRER_BVTG69bjXNL63hrvVItmg';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userWalls = $request->user()->userWalls()->latest()->get();
        $user_ids = $userWalls->implode('wall_id', ',');
        if (empty($user_ids)) {
            return view('userWalls.index', ['vk_users' => []]);
        }
        $response = $this->vk->users()->get($this->token, [
            'user_ids' => $user_ids,
            'fields' => 'screen_name, photo_100'
        ]);
        $vk_users = [];
        foreach($response as $profile) {
            $vk_users[$profile['id']] = (object) [
                'id' => $profile['id'],
                'name' => $profile['first_name'].' '.$profile['last_name'],
                'screen_name' => $profile['screen_name'],
                'photo' => $profile['photo_100']
            ];
        }
        return view('userWalls.index', ['vk_users' => $vk_users]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->user()->userWalls()->create($request->all());
        return redirect()->back();
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserWall  $userWall
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $wall_id)
    {
        UserWall::where('wall_id', '=', $wall_id)
            ->where('user_id', '=', $request->user()->id)
            ->first()
            ->delete();
        return redirect()->back();
    }
}
