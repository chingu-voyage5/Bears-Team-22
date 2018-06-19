<html>
<head>
    <title>@yield('title')</title>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
@section('sidebar')

@show

<div class="container">
    @yield('content')
</div>
</body>
</html>
