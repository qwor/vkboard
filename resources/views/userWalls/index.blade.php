@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="mb-2">{{__('Users')}}</h2>
            @foreach ($vk_users as $vk_user)
            <div class="user-profile bg-white">
                <div class="row">
                    <div class="col-md-2 col-sm-2 ms-3">
                        <img src="{{ $vk_user->photo}}" alt="user" class="profile-photo-lg">
                    </div>
                    <div class="col-md-7 col-sm-7">
                        <h5 class="profile-link">{{ $vk_user->name }}</h5>
                        <p>{{ $vk_user->screen_name }}</p>
                    </div>
                    <div class="col-2">
                        <a class="btn btn-primary mb-2" target="_blank" href="{{route('wall', $vk_user->id)}}">{{__('Wall')}}</a>
                        <form class="me-2" method="POST" action="{{ route('userWalls.destroy', $vk_user->id) }}">
                            @csrf
                            @method('delete')
                            <input type="submit" class="btn btn-danger" value="{{ __('Delete') }}">
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

