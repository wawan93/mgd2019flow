<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Collector;
use App\Event;
use Carbon\Carbon;
use Gate;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 100;

        $query = Event::latest();
        $acceptedCollectors = Collector::latest()->where('status', '=', 'accepted')->get();

        if (!empty($keyword)) {
            $events = $query->where('name', 'LIKE', "%$keyword%")->paginate($perPage);
        } else {
            $events = $query->paginate($perPage);
        }

        return view('admin.events.index', compact('events'), compact('acceptedCollectors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $event = new Event;

        $event->name = $request->get('name');
        $event->starts_at = $request->get('starts_at');
        $event->max_attendees = $request->get('max_attendees');

        $event->save();
        $event->collectors()->sync($request->get('collectors'));

        return redirect()->action('Admin\EventController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function ajaxUpdate(Request $request)
    {
        $interviewFields = [
            'name',
            'starts_at',
            'max_attendees',
            'collectors',
        ];

        $field = $request->get('field');
        if (!in_array($field, $interviewFields)) {
            return response()->json(['error'=>'true', 'error_text'=>'нельзя менять это поле']);
        }

        $event = Event::where('id', $request->get('id'))->firstOrFail();

        $value = $request->get('value');
        if (in_array($value, ['true', 'false'])) {
            $value = intval($value == 'true');
        }
        if ($field == 'starts_at') {
            $value = Carbon::createFromTimeString($value);
        }
        if ($field == 'collectors') {
            $event->collectors()->sync($request->get('value'));
        } else {
            $event->{$field} = $value;
            if (!$event->save()) {
                return response()->json(['error'=>'true', 'error_text'=>'ошибка при схоранении']);
            }
        }

        return response()->json(['error' => 'false']);
    }
}
