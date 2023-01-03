<?php

namespace App\Http\Controllers;

use App\Models\GroupWall;
use Illuminate\Http\Request;
use VK\Client\VKApiClient;

class GroupWallController extends Controller
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
        $groupWalls = $request->user()->groupWalls()->latest()->get();
        foreach($groupWalls as $gw) {
            $gw['wall_id'] = -$gw['wall_id'];
        }
        $group_ids = $groupWalls->implode('wall_id', ',');
        error_log($group_ids);
        if (empty($group_ids)) {
            return view('groupWalls.index', ['vk_groups' => []]);
        }
        $response = $this->vk->groups()->getById($this->token, [
            'group_ids' => $group_ids,
        ]);
        $vk_groups = [];
        foreach($response as $profile) {
            $vk_groups[$profile['id']] = (object) [
                'id' => $profile['id'],
                'name' => $profile['name'],
                'screen_name' => $profile['screen_name'],
                'photo' => $profile['photo_100']
            ];
        }
        return view('groupWalls.index', ['vk_groups' => $vk_groups]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->user()->groupWalls()->create($request->all());
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
        GroupWall::where('wall_id', '=', $wall_id)
            ->where('user_id', '=', $request->user()->id)
            ->first()
            ->delete();
        return redirect()->back();
    }
}
