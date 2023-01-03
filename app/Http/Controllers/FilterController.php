<?php

namespace App\Http\Controllers;

use App\Models\Filter;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $filters = $request->user()->filters()->latest()->get();

        foreach($filters as $filter)
        {
            $tag_arr = [];
            $tags = json_decode($filter->tags);
            if (!is_null($tags)) {
                foreach($tags as $i => $tag) {
                    $tag_arr[$i] = $tag->value;
                }
            }
            $filter->tag_arr = array_values($tag_arr);
        }
        return view('filters.index', ['filters' => $filters]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('filters.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->user()->filters()->create($request->all());
        return redirect(route('filters.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Filter  $filter
     * @return \Illuminate\Http\Response
     */
    public function edit(Filter $filter)
    {
        $this->authorize('update', $filter);

        return view('filters.edit', [
            'filter' => $filter,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Filter  $filter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Filter $filter)
    {
        $this->authorize('update', $filter);
        $filter->update($request->all());
        return redirect(route('filters.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Filter  $filter
     * @return \Illuminate\Http\Response
     */
    public function destroy(Filter $filter)
    {
        $this->authorize('delete', $filter);
        $filter->delete();
        return redirect(route('filters.index'));
    }
}
