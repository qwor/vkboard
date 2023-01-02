@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @foreach ($data['items'] as $item)
            <div class="card mb-3">
                <div class="card-header">{{ date("d.m.y", $item['date']) }}</div>
                <div class="card-body">
                    <p> {{ $item['text'] }}</p>
                </div>
            </div>
            @endforeach
            <a class="btn btn-success" href="{{ route('feed.get')}}">
                {{ __('Next page')}}
            </a>
        </div>
    </div>
</div>
@endsection

