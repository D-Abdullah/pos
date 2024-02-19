<?php

namespace App\Http\Controllers;

use App\Models\Target;
use App\Http\Requests\StoreTargetRequest;
use App\Http\Requests\UpdateTargetRequest;
use App\Http\Resources\TargetResource;


class TargetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.target.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTargetRequest $request)
    {
        $target = Target::create($request->validated());
        return new TargetResource($target);
    }

    /**
     * Display the specified resource.
     */
    public function show(Target $target)
    {
        return new TargetResource($target);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Target $target)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTargetRequest $request, Target $target)
    {
        $target->update($request->validated());
        return new TargetResource($target);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Target $target)
    {
        if(!auth()->check()){
            return response()->json([
                'message' => 'Unauthorized',
            ],401);
        }else{
            $target->delete();
            return response()->noContent();
        }
    }
}
