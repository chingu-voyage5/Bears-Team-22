@extends('layouts.app')

@section('title', 'Invitations List')

@section('sidebar')
    @parent

@endsection

@section('content')
<a href="{{route('invite.create')}}">Invite a person</a>

@endsection