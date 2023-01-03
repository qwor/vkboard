@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="mb-2">{{__('Filters')}}</h2>
            <a class="btn btn-primary mb-3" href="{{route('filters.create')}}">{{__('Add filter')}}</a>
            <div class="accordion" id="accordion-filters">
                @foreach ($filters as $filter)
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{$filter->id}}">
                            {{ $filter->name }}
                        </button>
                    </h2>
                    <div id="collapse-{{$filter->id}}" class="accordion-collapse collapse" data-bs-parent="#accordion-filters">
                        <div class="accordion-body">
                            <div>
                                <strong>{{__('Query')}}:</strong>
                                <span>{{ $filter->q }}</span>
                            </div>
                            <div>
                                <strong>{{__('Tags')}}:</strong>
                                @foreach ($filter->tag_arr as $tag)
                                <span class="badge bg-secondary">{{ $tag }}</span>
                                @endforeach
                            </div>
                            <div>
                                <strong>{{__('Start date')}}:</strong>
                                <span>{{ $filter->start_date }}</span>
                            </div>
                            <div>
                                <strong>{{__('End date')}}:</strong>
                                <span>{{ $filter->end_date }}</span>
                            </div>
                            <div>
                                <strong>{{__('Post count')}}:</strong>
                                <span>{{ $filter->count }}</span>
                            </div>
                            <div class="mt-2 d-inline-flex">
                                <a class="btn btn-success me-2" href="{{ route('feed.show', [$filter->id]) }}" target="_blank">{{__('Search')}}</a>
                                <a class="btn btn-primary me-2" href="{{ route('filters.edit', $filter) }}"> {{__('Edit')}}</a>
                                <form class="me-2" method="POST" action="{{ route('filters.destroy', $filter) }}">
                                    @csrf
                                    @method('delete')
                                    <input type="submit" class="btn btn-danger" value="{{ __('Delete') }}">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
