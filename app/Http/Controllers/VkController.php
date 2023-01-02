<?php

namespace App\Http\Controllers;

//use ATehnix\VkClient;
//use ATehnix\VkClient\Auth;
//use ATehnix\VkClient\Client;
//use ATehnix\VkClient\Exceptions\VkException;

use VK;
use VK\Client\VKApiClient;
use http\Env\Response;
use Illuminate\Http\Request;

class VkController extends Controller
{
    private \App\Models\User $user;
    private string $token;
    private VKApiClient $vk;


    private function makeProfiles($data)
    {
        $profiles = [];
        foreach($data['groups'] as $group)
        {
            $profiles['-'.$group['id']] = (object) [
                'name' => $group['name'],
                'screen_name' => $group['screen_name'],
                'photo' => $group['photo_100'],
                'is_closed' => false
            ];
        }
        foreach($data['profiles'] as $profile)
        {
            $profiles[$profile['id']] = (object) [
                'name' => $profile['first_name'].' '.$profile['last_name'],
                'screen_name' => $profile['screen_name'],
                'photo' => $profile['photo_100'],
                'is_closed' => $profile['is_closed']
            ];
        }
        return $profiles;
    }

    /**
     * @param mixed $search_params
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws VK\Exceptions\VKApiException
     * @throws VK\Exceptions\VKClientException
     */
    private function vkFeedHelper(mixed $search_params): \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $data = $this->vk->newsfeed()->search($this->token, $search_params);
        if (key_exists('next_from', $data)) {
            $search_params['start_from'] = $data['next_from'];
        }
        $profiles = $this->makeProfiles($data);
        return view('feed', [
            'data' => $data,
            'profiles' => $profiles,
            'search_params' => $search_params
        ]);
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->vk = new VKApiClient();
        $this->token = 'vk1.a.Qt8CpS-9-4WT5v26wQm4S3j89VlXr_4GppDW0RZutUgVqAHEbt8H9zYP6WBC2B4H0MvNW_TDfYaEGZbYr2oTvHFgEH05Y63MnUE-_uhzmQpkUybNEtJbJj97qdm1oviPK75t7ZZINei5x8AJTsKw5mN9AtZb3-7mKNcmZ3RA6lC2xQXwTQ7jZ2gUzo6QNRER_BVTG69bjXNL63hrvVItmg';
    }

    public function show()
    {
        return view('search');
    }

    public function search(Request $request)
    {
        $q = $request->q;
        $tags = json_decode($request->tags);
        if (!is_null($tags)) {
            foreach($tags as $tag) {
                error_log($tag->value);
                $q .= ' #'.$tag->value;
            }
        }
        $search_params = [
            'q' => $q,
            'count' => $request->postCount,
            'start_time' => strtotime($request->startDate),
            'end_time' => strtotime($request->endDate),
            'extended' => 1
        ];

        return $this->vkFeedHelper($search_params);
    }

    public function profile(Request $request, $profile_id)
    {
        $data = $this->vk->wall()->get($this->token, [
            'owner_id' => $profile_id,
            'extended' => 1,
            'count' => 20
        ]);
        $profiles = $this->makeProfiles($data);
        $view_data = [
            'data' => $data,
            'profiles' => $profiles,
            'profile_id' => $profile_id,
            'offset' => 0,
            'type' => 'user'
        ];
        if ($profile_id[0] == '-')
        {
            $view_data['type'] = 'group';
        }
        return view('profile', $view_data);
    }

    public function feedNextPage(Request $request)
    {
        $search_params = $request->search_params;
        return $this->vkFeedHelper($search_params);
    }

    public function profileNextPage(Request $request, $profile_id)
    {
        $offset = $request->offset + 20;
        $data = $this->vk->wall()->get($this->token, [
            'owner_id' => $profile_id,
            'extended' => 1,
            'count' => 20,
            'offset' => $offset
        ]);
        $profiles = $this->makeProfiles($data);
        $view_data = [
            'data' => $data,
            'profiles' => $profiles,
            'profile_id' => $profile_id,
            'offset' => $offset,
            'type' => 'user'
        ];
        if ($profile_id[0] == '-')
        {
            $view_data['type'] = 'group';
        }
        return view('profile', $view_data);
    }
}
