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
                    <div class="card-body">

                        <canvas id="weightChart"></canvas>

                    </div>
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
                                    @php
                                    $id;
                                    @endphp
                                    @foreach ($logs as $log)
                                        <tr>
                                            <td>{{ $log->created_at->format('d.m.Y.') }}</td>
                                            <td>{{ $log->weight / 100 }} Kg</td>
                                            <td><a href="{{ route('weightlog.deleteLog', ['id' => $log->id]) }}" style="color: #ae0d0b;"><span class="far fa-trash-alt"></span></a></td>
                                            @php
                                            $id = $log->user_id
                                            @endphp
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

        </div>
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
                format: "dd.mm.yyyy.",
                orientation: "top auto"
            });

            @if (isset($id))
            $.ajax({
                url: '{{ route('weightlog.ajax', ['id' => $id]) }}',
            }).done(function(data) {
                var dataset = JSON.parse(data);
                var ctx = document.getElementById('weightChart').getContext('2d');
                var chart = new Chart(ctx, {
                    type: "line",
                    data: {
                        labels: dataset.labels.reverse(),
                        datasets: [{
                            label: "Weight",
                            data: dataset.data.map(x => (x / 100)).reverse()
                        }]
                    },
                    options: {
                        tooltips: {
                            mode: 'nearest',
                            intersect: false
                        },
                        legend: {
                            display: false,
                            labels: {
                                fontColor: 'rgb(255, 99, 132)'
                            },
                            position: 'left',

                        },
                        title: {
                            display: false
                        },
                        elements: {
                            line: {
                                tension: 0
                            }
                        },
                        layout: {
                            padding: 50
                        }

                    }
                });

            });
            @endif
        </script>
    </div>
@endsection
