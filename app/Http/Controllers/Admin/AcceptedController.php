<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Collector;
use Carbon\Carbon;
use Gate;
use Illuminate\Http\Request;

class AcceptedController extends Controller
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
            ->where('status', '=', 'accepted')
            ->where('research_status', '!=', 'declined');

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

        return view('admin.accepted.index', compact('collector'));
    }

    public function ajaxUpdate(Request $request)
    {
        $interviewFields = [
            'interview_date',
            'status',
            'comment',
            'briefing_passed',
            'contract_signed',
            'notary_passed',
            'training_passed',
            'telegram_attached'
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
