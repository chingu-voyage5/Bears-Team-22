<table class="table table-responsive" id="exercises-table">
    <thead>
        <th>Title</th>
        <th>Description</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($exercises as $exercises)
        <tr>
            <td>{!! $exercises->title !!}</td>
            <td>{!! $exercises->description !!}</td>
            <td>
                {!! Form::open(['route' => ['exercises.destroy', $exercises->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('exercises.show', [$exercises->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('exercises.edit', [$exercises->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>    @endforeach
    </tbody>
</table>
