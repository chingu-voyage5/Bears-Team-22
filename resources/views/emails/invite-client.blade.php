<p>Hi, {{$invite->email}}</p>

<p>{{$invite->user->email}} has invited you to register as a client.</p>

<a href="{{ route('invite.accept', $invite->token) }}">Click here</a> to complete registration!