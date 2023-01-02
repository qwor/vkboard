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
    private array $feedReq;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->vk = new VKApiClient();
        $this->token = '2ecebee92ecebee92ecebee9e32ddcb29022ece2ecebee94d6233870f07a3260a7513b8';
        $this->feedReq = [];
    }

    public function show()
    {
        return view('search');
    }

    public function search(Request $request)
    {
        $data = $this->vk->newsfeed()->search($this->token, [
                'q' => $request->q,
                'count' => $request->postCount,
                'start_time' => strtotime($request->startDate),
                'end_time' => strtotime($request->endDate)
        ]);
        $search_params = [
            'q' => $request->q,
            'postCount' => $request->postCount,
            'startDate' => $request->startDate,
            'endDate' => $request->endDate,
            'nextFrom' => $data['next_from']
        ];
        session(['search_params' => $search_params]);
        return view('feed', ['data' => $data]);
    }

    public function nextPage()
    {
        $search_params = session('search_params');
        $data = $this->vk->newsfeed()->search($this->token, [
            'q' => $search_params['q'],
            'count' => $search_params['postCount'],
            'start_time' => strtotime($search_params['startDate']),
            'end_time' => strtotime($search_params['endDate']),
            'start_from' => $search_params['nextFrom']
        ]);
        $search_params['nextFrom'] = $data['next_from'];
        session(['search_params' => $search_params]);
        return view('feed', ['data' => $data]);
    }
}
