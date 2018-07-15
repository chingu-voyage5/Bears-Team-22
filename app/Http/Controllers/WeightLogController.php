<?php

namespace App\Http\Controllers;

use App\WeightLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Invite;

class WeightLogController extends Controller
{



    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function hasWeightLogAccess($id = null)
    {
        if (Auth::user()->role->name === 'trainer') {

        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id = null)
    {
        if (!$id) {
            $id = Auth::id();
        }
        // check if user exists and has access for this action
        $user = User::find($id);
        if (!$user) {
            abort(404);
        }
        // if user who is viewing is not owner of the log
        if (Auth::id() != $id ) {
            $check = Invite::where(['user_id', '=', Auth::id()], ['email', '=', $user->email])->get();
            if (!$check) abort(404);
        }
        $logs = WeightLog::where('user_id', $id)->orderBy('id', 'desc')->take(10)->get();
        //dd($logs);
        return view('weightlog.index', ['logs' => $logs]);
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
    public function store(Request $request, $id = null)
    {
        $validator = Validator::make($request->all(), [
            'weight' => 'numeric:required'
        ]);
        if ($validator->fails()) {
            return redirect()->route('weightlog.index')
                        ->withErrors($validator)
                        ->withInput();
        }

        $log = WeightLog::create([
            'user_id' => Auth::id(),
            'weight' => $request->weight * 100, // we don't want to store float in db !
        ]);

        return redirect()->route('weightlog.index')->with('success', 'Log recorded: '. $request->weight .'kg');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\WeightLog  $weightLog
     * @return \Illuminate\Http\Response
     */
    public function show(WeightLog $weightLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\WeightLog  $weightLog
     * @return \Illuminate\Http\Response
     */
    public function edit(WeightLog $weightLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\WeightLog  $weightLog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WeightLog $weightLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\WeightLog  $weightLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(WeightLog $weightLog, $id)
    {
        if (Auth::id() == WeightLog::find($id)->first()->user_id) {
            WeightLog::destroy($id);
            return redirect()->route('weightlog.index')->with('success', 'Log successfully deleted!');
        }
        return redirect()->route('weightlog.index')->with('error', 'You don\'t have permission to do that!');
    }
}
