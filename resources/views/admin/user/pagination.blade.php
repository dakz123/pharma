<table class="table table-striped">
    <thead>
        <tr>

            <th>Id</th>
            <th>User Name</th>
            <th>Data</th>
            <th>Image/Pdf</th>



        </tr>
    </thead>
    <tbody>
        @if(!empty($data) && $data->count())
        @foreach($data as $key=> $row)
        <tr>

            @if($row->status==0)
            <td>{{ $key+1}}</td>
            <td>{{ $row->user->name}}</td>
            <td>{{ $row->data }}</td>
            <td>{{ $row->image }}</td>
            @else
            <td><del>{{ $key+1 }}</del></td>
            <td><del>{{ $row->user->name }}</del></td>
            <td><del>{{ $row->data }}</del></td>
            <td><del>{{ $row->image }}</del></td>
            @endif

            @if($row->status==0)
            <td><button type="submit" class="check_data fa fa-check text-secondary px-2 " style="cursor:pointer">
                    {!! Form::open(['method' => 'PUT', 'route' => ['admin.user.update', $row->id]]) !!}
                    {!! Form::submit(trans('admin.user.update')) !!}
                    {!! Form::close() !!}
                </button>

            </td>
            @else
            <td>
                <button type="submit" class="check_data fa fa-check text-success px-2 " style="cursor:pointer">
                    {!! Form::open(['method' => 'PUT', 'route' => ['admin.user.update', $row->id]]) !!}
                    {!! Form::submit(trans('admin.user.update')) !!}
                    {!! Form::close() !!}
                </button>
            </td>
            @endif
        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="4">No data found.</td>
        </tr>
        @endif
    </tbody>

</table>
<div class="row">
    <div class="col-lg-12">
        {!! $data->links() !!}
    </div>
</div>