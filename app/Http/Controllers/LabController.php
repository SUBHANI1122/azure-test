<?php

namespace App\Http\Controllers;

use App\Models\Lab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LabController extends Controller
{
    public function index()
    {
        return view('labs.index');
    }
    public function fetch()
    {
        $labs = Lab::select(['id', 'name', 'added_by', 'created_at'])->with('added_by:name')->get();

        return datatables()->of($labs)->make(true);
    }

    public function store(Request $request)
    {
        $request['added_by'] = Auth::user()->id;
        Lab::create($request->all());
        return response()->json(['success' => true]);
    }

    public function update(Request $request, $id)
    {

        $request['added_by'] = Auth::user()->id;
        $medicines = Lab::findOrFail($id);
        $medicines->update($request->all());
        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        Lab::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }
}
