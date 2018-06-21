@extends('adminlte::page')

@section('content')
    <section class="content-header">
        <h1>
            Exercises
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'exercises.store']) !!}

                        @include('exercises.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
