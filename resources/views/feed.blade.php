@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @empty($data['items'])
            <h4>{{__('No posts found')}}</h4>
            @endempty
            @foreach ($data['items'] as $item)
            <div class="card mb-3">
                <div class="card-body">
                    <div class="media mb-3 d-flex">
                        <img src="{{$profiles[$item['owner_id']]->photo}}" class="d-block ui-w-40 rounded-circle" alt="">
                        <div class="media-body ms-3">
                            @if ($profiles[$item['owner_id']]->is_closed)
                            <span>{{ $profiles[$item['owner_id']]->name }}</span>
                            @else
                            <a class="link-primary" href="{{ route('wall', ['wall' => $item['owner_id']]) }}" target="_blank">{{ $profiles[$item['owner_id']]->name }}</a>
                            @endif
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
                </div>
            </div>
            @endforeach
            @if (!is_null($search_params) && !is_null($search_params['start_from']))
            <a class="btn btn-success" href="{{ route('feed.nextPage', ['search_params' => $search_params]) }}">
                {{ __('Next page')}}
            </a>
            @endif
        </div>
    </div>
</div>
@endsection

