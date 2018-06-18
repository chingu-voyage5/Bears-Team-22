<?php

namespace App\Http\Controllers;

use App\Invite;
use App\Mail\InvitationMail;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class InviteController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invitations= Invite::with('user')->get();
        return view('invitations.index', ['invitations' => $invitations]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('invitations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $currentUser = Auth::user();
        do {
            $token = str_random();
        }
        while (Invite::where('token', $token)->first());

        $invite = Invite::create([
            'user_id'=> $currentUser->id,
            'email' => $request->get('email'),
            'token' => $token
        ]);

        Mail::to($request->get('email'))->send(new InvitationMail($invite));

        return redirect()->back();
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $invite = Invite::find($request->id);
        if (!$invite) {
            return redirect()->route('invite.list')->with('failed', 'Unable to delete specified invite');
        }
        $invite->delete();
        return redirect()->route('invite.list')->with('success', 'Invite successfully deleted');
    }

}