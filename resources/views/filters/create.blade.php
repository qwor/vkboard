@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2>{{__('New filter')}}</h2>
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('filters.store') }}" method="post" autocomplete="off">
                        @csrf
                        <div class="form-group">
                            <label for="nameInput">{{__('Filter name')}}</label>
                            <input type="text" class="form-control" name="name" id="name_input" required>
                        </div>
                        <div class="form-group">
                            <label for="queryInput">{{__('Query')}}</label>
                            <textarea class="form-control" name="q" id="query_input" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="tagInput">{{__('Tags')}}</label>
                            <input type="text" class="form-control" name="tags" id="tagInput"">
                        </div>
                        <div class="form-group">
                            <label for="startDateInput">{{__('Start date')}}</label>
                            <input type="date" class="form-control" name="start_date" id="startDateInput">
                        </div>
                        <div class="form-group">
                            <label for="endDateInput">{{__('End date')}}</label>
                            <input type="date" class="form-control" name="end_date" id="endtDateInput">
                        </div>
                        <div class="form-group">
                            <label for="countInput">{{__('Number of posts per page')}}</label>
                            <input type="number" class="form-control" name="count" value='20' id="countInput">
                        </div>
                        <div class="form-group mt-2">
                            <button type="submit" class="btn btn-primary mt-3">{{__('Save')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    let input = document.querySelector('input[name=tags]');
    let tagInput = new Tagify(input, {
        id: 'tagInput',
    });
    tagInput.removeAllTags();
</script>
@endsection

@push('head')
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
@endpush
