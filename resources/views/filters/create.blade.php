@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2>{{__('New filter')}}</h2>
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('filters.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="nameInput">{{__('Name')}}</label>
                            <input type="text" class="form-control" name="name" id="name_input" required>
                        </div>
                        <div class="form-group">
                            <label for="queryInput">{{__('Query')}}</label>
                            <textarea class="form-control" name="q" id="query_input" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="tagInput">{{__('Tags')}}</label>
                            <input type="text" class="form-control" name="tags" id="tagInput">
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
    new Tagify(input, input)
</script>
@endsection

@push('head')
<link rel="stylesheet" href="../node_modules/@yaireo/tagify/dist/tagify.css">
<script src="https://unpkg.com/@yaireo/tagify"></script>
<script src="https://unpkg.com/@yaireo/tagify@3.1.0/dist/tagify.polyfills.min.js"></script>
@endpush
