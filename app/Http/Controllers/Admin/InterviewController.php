<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Collector;
use Gate;
use Illuminate\Http\Request;

class InterviewController extends Controller
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
        $perPage = 250;

        $query = Collector::latest()
            ->whereIn('status', ['research_done', 'interview_accespted', 'accepted', 'new'])
            ->where('research_status', '!=', 'declined');

        if (!empty($keyword)) {
            $collector = $query->where('name', 'LIKE', "%$keyword%")
                ->orWhere('surname', 'LIKE', "%$keyword%")
                ->latest();
        } else {
            $collector = $query->paginate($perPage);
        }

        return view('admin.interview.index', compact('collector'));
    }

    public function ajaxUpdate(Request $request)
    {
        $interviewFields = [
            'status',
            'comment',
        ];

        if (!in_array($request->get('field'), $interviewFields)) {
            return response()->json(['error'=>'true', 'error_text'=>'нельзя менять это поле']);
        }

        $collector = Collector::where('id', $request->get('id'))->firstOrFail();

        $value = $request->get('value');
        if (in_array($value, ['true', 'false'])) {
            $value = intval($value == 'true');
        }
        $collector->{$request->get('field')} = $value;
        if (!$collector->save()) {
            return response()->json(['error'=>'true', 'error_text'=>'ошибка при схоранении']);
        }

        return response()->json(['error' => 'false']);
    }
}
