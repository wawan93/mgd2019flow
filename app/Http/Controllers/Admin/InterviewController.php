<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Collector;
use Carbon\Carbon;
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
            ->whereIn('status', ['research_done', 'interview_accepted', 'new']);

        if (!empty($keyword)) {
            $collector = $query->where('name', 'LIKE', "%$keyword%")
                ->orWhere('surname', 'LIKE', "%$keyword%")
                ->orWhereRaw('DATE_FORMAT(interview_date, \'%d/%m\') LIKE ?', "%$keyword%")
                ->orWhereRaw('DATE_FORMAT(interview_date, \'%d.%m\') LIKE ?', "%$keyword%")
                ->orWhereRaw('DATE_FORMAT(interview_date, \'%d-%m\') LIKE ?', "%$keyword%")
                ->orWhereRaw('DATE_FORMAT(interview_date, \'%d %m\') LIKE ?', "%$keyword%")
                ->orWhereRaw('DATE_FORMAT(interview_date, \'%d%m\') LIKE ?', "%$keyword%")
                ->orWhereRaw('DATE_FORMAT(interview_date, \'%m/%d\') LIKE ?', "%$keyword%")
                ->orWhereRaw('DATE_FORMAT(interview_date, \'%m.%d\') LIKE ?', "%$keyword%")
                ->orWhereRaw('DATE_FORMAT(interview_date, \'%m-%d\') LIKE ?', "%$keyword%")
                ->orWhereRaw('DATE_FORMAT(interview_date, \'%m %d\') LIKE ?', "%$keyword%")
                ->orWhereRaw('DATE_FORMAT(interview_date, \'%m%d\') LIKE ?', "%$keyword%")
                ->paginate($perPage);
        } else {
            $collector = $query->paginate($perPage);
        }

        return view('admin.interview.index', compact('collector'));
    }

    public function ajaxUpdate(Request $request)
    {
        $interviewFields = [
            'surname',
            'name',
            'middlename',
            'birthday',
            'interview_date',
            'status',
            'comment',
            'interview_status',
            'passport_number',
            'passport_issue_date',
            'passport_issued_by',
            'passport_address'
        ];

        $field = $request->get('field');
        if (!in_array($field, $interviewFields)) {
            return response()->json(['error'=>'true', 'error_text'=>'нельзя менять это поле']);
        }

        $collector = Collector::where('id', $request->get('id'))->firstOrFail();

        $value = $request->get('value');
        if (in_array($value, ['true', 'false'])) {
            $value = intval($value == 'true');
        }
        if ($field == 'interview_date') {
            $value = Carbon::createFromTimeString($value);
        }
        $collector->{$field} = $value;
        if (!$collector->save()) {
            return response()->json(['error'=>'true', 'error_text'=>'ошибка при схоранении']);
        }

        return response()->json(['error' => 'false']);
    }
}
