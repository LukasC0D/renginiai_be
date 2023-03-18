<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        return Event::with('user')->get();
    }

    /** Ateinatys renginiai
     *
     */
    public function getComingEvents()
    {
        $today = date('Y-m-d');
        $events = DB::table('events')
            ->where('date', '>=', $today)
            ->orderBy('date', 'asc')
            ->get();

        return response()->json($events);
    }

    /**Praėję renginiai
     *
     */
    public function getPassedEvents()
    {
        $today = date('Y-m-d');
        $events = DB::table('events')
            ->where('date', '<=', $today)
            ->orderBy('date', 'asc')
            ->get();

        return response()->json($events);
    }

    /**Renginių peržiūrėjimas
     *
     */

    public function getEventUser($id)
    {
        $event = DB::table('events')
            ->leftJoin('event_users', 'events.id', '=', 'event_users.event_id')
            ->leftJoin('users', 'event_users.user_id', '=', 'users.id')
            ->where('events.id', $id)
            ->select('events.*', 'users.name as participant_name')
            ->get();

        if ($event === null) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        return response()->json($event);
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
            'place' => 'required|max:255',

        ]);
        $event = new Event($request->all());
        $event->user_id = auth()->id();
        $event->save();
        return $event;
    }

    /**Prisirašymas į renginį
     *
     */
    public function participate(Request $request, $eventId)
    {
        $user = Auth::user();
        $event = Event::find($eventId);

        if (!$user || !$event) {
            return response()->json(['error' => 'Invalid request.'], 400);
        }
        $eventUser = EventUser::where('user_id', $user->id)
            ->where('event_id', $eventId)
            ->first();

        if ($eventUser) {
            $eventUser->delete();
            return response()->json(['success' => 'Jūs atšaukėte dalyvavimą renginyje'], 200);
        } else {
            $eventUser = new EventUser;
            $eventUser->user_id = $user->id;
            $eventUser->event_id = $event->id;
            $eventUser->save();
            return response()->json(['success' => 'Jūs užsirašėte į renginį'], 200);
        }
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
        $event = Event::find($id);

        if (!$event) {
            return response(["status" => "failure"], 404);
        }

        if ($event->user_id !== auth()->id()) {
            return response(["status" => "failure"], 403);
        }

        $event->delete();
        return response(["status" => "success"], 200);
    }
}
