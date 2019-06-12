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
     * Fire the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $collector = Collector::find($id);
        $collector->status = 'fired';
        $collector->save();

        return redirect()->back();
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
            ->where('status', '=', 'accepted');

        if (!empty($keyword)) {
            $collector = $query->where('name', 'LIKE', "%$keyword%")
                ->orWhere('surname', 'LIKE', "%$keyword%")
                ->paginate($perPage);
        } else {
            $collector = $query->paginate($perPage);
        }

        return view('admin.accepted.index', compact('collector'));
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
            'briefing_passed',
            'contract_signed',
            'notary_passed',
            'training_passed',
            'telegram_attached',
            'passport_number',
            'passport_issue_date',
            'passport_issued_by',
            'passport_address',
            'account_number',
            'account_bank',
            'account_bik',
        ];

        $field = $request->get('field');
        if (!in_array($field, $interviewFields)) {
            return response()->json(['error' => 'true', 'error_text' => 'нельзя менять это поле']);
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
            return response()->json(['error' => 'true', 'error_text' => 'ошибка при схоранении']);
        }

        return response()->json(['error' => 'false']);
    }

    public function ajaxGenerate($candidate, $id)
    {
        $collector = Collector::find($id);
        $pdf = \PDF::loadView("pdf.".$candidate, compact('collector'))
            ->setPaper("A4", 'portrait');
        return $pdf->download("{$candidate}_{$id}.pdf");
    }
}
