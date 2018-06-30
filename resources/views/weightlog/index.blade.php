@extends('layouts.app')

@section('title', 'Weight Log')

@section('sidebar')
    @parent

@endsection

@section('content')
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
                                <tr>
                                    <td>11.11.2011.</td>
                                    <td>90Kg</td>
                                </tr>
                            </tbod>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col">

                <div class="card mb-3">
                    <div class="card-header">New Entry</div>
                    <div class="card-body">
                        <form action="#" class="form-inline">
                            <div class="form-group">
                                <label class="sr-only" for="weight">Weight</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="weight" placeholder="Weight" required>
                                    <div class="input-group-append">
                                        <div class="input-group-text">Kg</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
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
