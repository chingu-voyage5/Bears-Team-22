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
                    <div class="alert alert-success">
                        {{ session('success') }}
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
                            </tr>
                            </thead>
                            <tbod>
                                @if ($logs)
                                    @foreach ($logs as $log)
                                        <tr>
                                            <td>{{ $log->created_at->format('d.m.Y') }}</td>
                                            <td>{{ $log->weight / 100 }} Kg</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbod>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col">

                <div class="card mb-3">
                    <div class="card-header">New Entry</div>
                    <div class="card-body">
                        <form action="{{ route('weightlog.addlog') }}" class="form-inline" method="POST">
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
        </div>
    </div>
@endsection
