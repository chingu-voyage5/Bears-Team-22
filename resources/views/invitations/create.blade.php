@extends('layouts.app')

@section('title', 'Send Invitation')

@section('sidebar')
    @parent
@endsection

@section('content')
    <h1>Create New Invitation</h1>
    <form action="{{ route('invite.store') }}" method="post">
        {{ csrf_field() }}
        <input type="email" name="email" />
        <button type="submit">Send invite</button>
    </form>

@endsection