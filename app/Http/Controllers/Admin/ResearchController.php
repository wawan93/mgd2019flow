<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Collector;
use Gate;
use Illuminate\Http\Request;

class ResearchController extends Controller
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

        if (!empty($keyword)) {
            $collector = Collector::where('name', 'LIKE', "%$keyword%")
                ->orWhere('surname', 'LIKE', "%$keyword%")
                ->orWhere('status', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $collector = Collector::latest()->paginate($perPage);
        }

        return view('admin.research.index', compact('collector'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.research.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {

        $requestData = $request->all();

        Collector::create($requestData);

        return redirect('admin/research')->with('flash_message', 'Collector added!');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $collector = Collector::findOrFail($id);

        return view('admin.research.show', compact('collector'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $collector = Collector::findOrFail($id);

        return view('admin.research.edit', compact('collector'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $requestData = $request->all();

        $collector = Collector::findOrFail($id);
        $collector->update($requestData);

        return redirect('admin/research')->with('flash_message', 'Collector updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Collector::destroy($id);

        return redirect('admin/research')->with('flash_message', 'Collector deleted!');
    }

    public function ajaxUpdate(Request $request)
    {
        $researchFields = [
            'research_status',
            'research_comment',
        ];

        if (in_array($request->get('field'), $researchFields)) {
            if (Gate::denies('update-research')) {
                return response()->json(['error' => 'true', 'error_text' => 'нет прав на изменение этого поля']);
            }
        }

        $collector = Collector::where('id', $request->get('id'))->firstOrFail();

        $value = $request->get('value');
        if (in_array($value, ['true', 'false'])) {
            $value = intval($value == 'true');
        }
        $collector->{$request->get('field')} = $value;
        $collector->save();

        return response()->json(['error' => 'false']);
    }
}
