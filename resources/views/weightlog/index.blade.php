@extends('layouts.app')

@section('title', 'Weight Log')

@section('sidebar')
    @parent

@endsection

@section('content')
    @if (session('success'))
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}

                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if (session('error'))
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}

                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-3">
                    <div class="card-header">Weight Graph</div>
                    <div class="card-body"></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="card mb-3">
                    <div class="card-header">Previous logs</div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Weight</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                                @if ($logs)
                                    @foreach ($logs as $log)
                                        <tr>
                                            <td>{{ $log->created_at->format('d.m.Y') }}</td>
                                            <td>{{ $log->weight / 100 }} Kg</td>
                                            <td><a href="{{ route('weightlog.deleteLog', ['id' => $log->id]) }}" style="color: red;"><span class="oi oi-x"></span></a></td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col">

                <div class="card mb-3">
                    <div class="card-header">New Entry</div>
                    <div class="card-body">
                        <form action="{{ route('weightlog.addlog') }}" class="form" method="POST">
                            @csrf
                            <div class="col-md-6">


                                <div class="form-group">

                                    <label class="sr-only" for="weight">Weight</label>

                                    <div class="input-group">
                                        <input type="text" class="form-control{{ $errors->has('weight') ? ' is-invalid' : '' }}" value="{{ old('weight') }}" id="weight" name="weight" placeholder="Weight" required>
                                        <div class="input-group-append">
                                            <div class="input-group-text">Kg</div>
                                        </div>
                                        @if ($errors->has('weight'))
                                        <div class="invalid-feedback">
                                            <strong>{{ $errors->first('weight') }}</strong>
                                        </div>
                                        @endif
                                    </div>

                                </div>
                                <div class="form-group">
                                    <div id="sandbox-container">
                                        <div class="input-group date">
                                            <input type="text" class="form-control" id="date" name="date" placeholder="Date"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                            <div class="input-group-append">
                                                <div class="input-group-text"><span class="far fa-calendar-alt"></span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <button class="btn btn-primary" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            <script>
                $('#sandbox-container .input-group.date').datepicker({
                    startDate: 0,
                    maxViewMode: 2,
                    todayBtn: "linked",
                    calendarWeeks: true,
                    autoclose: true,
                    todayHighlight: true,
                    weekStart: 1,
                    endDate: "0d",
                    format: "dd.mm.yyyy",
                    orientation: "top auto"
                });
            </script>
        </div>
    </div>
@endsection
