@extends('layouts.app')

@section('title', 'Invitations List')

@section('sidebar')
    @parent

@endsection

@section('content')
<a href="{{route('invite.create')}}">Invite a person</a>

@if(isset($invitations))
<table class="table">
    <thead>
        <tr>
            <th>User</th>
            <th>Invited email</th>
            <th>Accepted</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
            @foreach($invitations as $invite)
                <tr>
                    <td>{{ $invite->user->name }}</td>
                    <td>{{ $invite->email }}</td>
                    <td>{{ ($invite->is_accepted == 1) ? "Yes" : "No" }}</td>
                    <td>{{ $invite->created_at->format('d M Y') }}</td>
                </tr>
            @endforeach
    </tbody>
</table>
@endif

@endsection
