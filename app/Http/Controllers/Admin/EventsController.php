<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Collector;
use App\Event;
use Carbon\Carbon;
use Gate;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 100;

        $query = Event::latest();
        $acceptedCollectors = Collector::latest()->where('status', '=', 'accepted')->get();

        if (!empty($keyword)) {
            $events = $query->where('name', 'ILIKE', "%$keyword%")->paginate($perPage);
        } else {
            $events = $query->paginate($perPage);
        }

        return view('admin.events.index', compact('events'), compact('acceptedCollectors'));
    }
}
