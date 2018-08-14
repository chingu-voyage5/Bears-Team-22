<?php

namespace App\Http\Controllers;

use App\WeightLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Invite;
use Carbon\Carbon;

class WeightLogController extends Controller
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
        $logs = WeightLog::where('user_id', $id)->orderBy('created_at', 'desc')->take(10)->get();
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
        $q = [
            'user_id' => Auth::id(),
            'weight' => $request->weight * 100, // we don't want to save float in to the database
        ];
        if (isset($request->date)) {
            $q['created_at'] = Carbon::createFromFormat('d.m.Y.', $request->date)->toDateTimeString();
            $q['updated_at'] = Carbon::now()->toDateTimeString();
        }

        if (!WeightLog::create($q)->id) {
            return redirect()->route('weightlog.index')->with('error', 'An error occurred while saving new entry. Please try again later.');
        }

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

    public function ajax($id)
    {
        $data = WeightLog::select('weight')->where('user_id', $id)->orderBy('created_at', 'desc')->take(10)->get();
        $labels = WeightLog::select('created_at')->where('user_id', $id)->orderBy('created_at', 'desc')->take(10)->get();
//dd($this->ajaxValues($labels));
        return json_encode([
            'labels' => $this->carbonDate($this->ajaxCollectionValues($labels)),
            'data' => $this->ajaxCollectionValues($data)
        ]);
    }

    // extract values from collection for ajax call
    private function ajaxCollectionValues($collection)
    {
        $dataset = [];
        foreach($collection->toArray() as $arr) {
            foreach($arr as $key => $val) {
                $dataset[] = $val;
            }
        }
        return $dataset;
    }

    // return date in friendly readable format - dd.mm.yyyy.
    private function carbonDate(array $array)
    {
        $result = [];
        foreach($array as $key) {

            $result[] = Carbon::parse($key)->format('d.m.Y');
        }
        return $result;
    }

}
