<?php

namespace App\Http\Controllers;

use App\Models\listmodel;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Validated;
use RealRashid\SweetAlert\Facades\Alert;

class ListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = listmodel::where('user_id', auth()->user()->id)->get();
        return view('pages.list.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'todo' => 'required|string',
        ]);
        listmodel::create([
            'description' => $request->todo,
            'user_id' => auth()->user()->id,
            'index' => 0,
        ]);
        return redirect()->route('list.index');
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
        listmodel::find($id)->update([
            'description' => $request->todo
        ]);
        return response('Saved Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Alert::question('Question Title', 'Question Message');


        listmodel::find($id)->delete();
        return response('Deleted Successfully');
    }
}
