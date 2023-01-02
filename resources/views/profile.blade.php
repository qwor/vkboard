@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="user-profile bg-white">
                <div class="row">
                    <div class="col-md-2 col-sm-2 ms-3">
                        <img src="{{ $profiles[$profile_id]->photo}}" alt="user" class="profile-photo-lg">
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <h5 class="profile-link">{{ $profiles[$profile_id]->name }}</h5>
                        <p>{{ $profiles[$profile_id]->screen_name }}</p>
                    </div>
                    <div class="col-md-2 col-sm-2">
                        <button class="btn btn-primary pull-right">{{__('Favorite')}}</button>
                    </div>
                </div>
            </div>
            @foreach ($data['items'] as $item)
            <div class="card mb-3">
                <div class="card-body">
                    <div class="media mb-3 d-flex">
                        <img src="{{$profiles[$item['owner_id']]->photo}}" class="d-block ui-w-40 rounded-circle" alt="">
                        <div class="media-body ms-3">
                            <a class="link-primary" href="{{ route('profile', ['profile_id' => $item['owner_id']]) }}" target="_blank">{{ $profiles[$item['owner_id']]->name }}</a>
                            <div class="text-muted small">{{ date("d.m.y", $item['date']) }}</div>
                        </div>
                    </div>
                    <p> {{ $item['text'] }}</p>
                    @foreach($item['attachments'] as $attachment)
                        @if ($attachment['type'] == 'photo')
                        <div class="ui-rect ui-bg-cover mb-1" style="background-image: url('{{ $attachment['photo']['sizes']['4']['url'] }}');"></div>
                        @endif
                    @endforeach
                </div>
                <div class="card-footer">
                    <span><strong>{{ $item['likes']['count'] }}</strong> <i class="fa-regular fa-heart"></i></span>
<!--                    <span><strong>123</strong> <i class="fa-regular fa-heart"></i></span>-->
                </div>
            </div>
            @endforeach
            <a class="btn btn-success" href="{{ route('profile.nextPage', ['profile_id' => $profile_id, 'offset' => $offset])}}">
                {{ __('Next page')}}
            </a>
        </div>
    </div>
</div>
@endsection

