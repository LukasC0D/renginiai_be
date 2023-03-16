<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        return Event::all();
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
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'date' => 'required|max:255',
            'description' => 'required|max:255',
            'place' => 'required|max:255'

        ]);
        return Event::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show($id, Request $request)
    {
        return Event::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        return Event::destroy($id) === 0
        ? response(["status" => "failure"], 404)
        : response(["status" => "success"], 200);
    }
}