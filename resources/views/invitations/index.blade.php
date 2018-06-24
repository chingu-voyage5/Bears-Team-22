@extends('layouts.app')

@section('title', 'Invitations List')

@section('sidebar')
    @parent

@endsection

@section('content')

<a class="btn btn-dark" aria-label="Left Align" href="{{route('invite.create')}}">
    <i class="fas fa-envelope"></i>Invite a person</a>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
@if (session('failed'))
    <div class="alert alert-danger">
        {{ session('failed') }}
    </div>
@endif

@if(isset($invitations))
<table class="table">
    <thead>
        <tr>
            <th>User</th>
            <th>Invited email</th>
            <th>Accepted</th>
            <th>Date</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
            @foreach($invitations as $invite)
                <tr>
                    <td>{{ $invite->user->name }}</td>
                    <td>{{ $invite->email }}</td>
                    <td>{{ ($invite->is_accepted == 1) ? "Yes" : "No" }}</td>
                    <td>{{ $invite->created_at->format('d M Y') }}</td>
                    <td><a href="{{ route('invite.delete', ['id' => $invite->id] )}}" alt="Delete">X</a></td>
                </tr>
            @endforeach
    </tbody>
</table>
@endif

@endsection
