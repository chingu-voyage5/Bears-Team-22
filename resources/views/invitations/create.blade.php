@extends('layouts.app')

@section('title', 'Send Invitation')

@section('sidebar')
    @parent
@endsection

@section('content')

    <h1>Create New Invitation</h1>
    <form action="{{ route('invite.store') }}" method="post">
        {{ csrf_field() }}

        <dic class="col-form-label">Email</dic>
        <input type="email" name="email" />

        <div class="">
            @foreach($roles as $role)
                <input type="radio" name="invited_role" value="{{$role->id}}"/>
                <label>Invite to become a {{$role->name}}</label>
            @endforeach
        </div>

        <button type="submit">Send invite</button>
    </form>




@endsection