<table class="table table-striped">
    <thead>
        <tr>

            <th>Id</th>
            <th>Data</th>
            <th>Image/Pdf</th>



        </tr>
    </thead>
    <tbody>
        @if(!empty($datas) && $datas->count())
        @foreach($datas as $key=> $row)
        <tr>

            @if($row->status==0)
            <td>{{ $key+1}}</td>
            <td>{{ $row->data }}</td>
            <td>{{ $row->image }}</td>
            @else
            <td><del>{{ $key+1 }}</del></td>
            <td><del>{{ $row->data }}</del></td>
            <td><del>{{ $row->image }}</del></td>
            @endif

            @if($row->status==0)
            <td><i id="{{ $row->id }}" class="edit_data fas fa-edit text-success px-2 " style="cursor:pointer"></i>
                <i id="{{ $row->id }}" class="delete_data fas fa-times text-danger" style="cursor:pointer"></i>
            </td>
            @else
            <td>
                <h6>Admin Approved</h6>
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
        {!! $datas->links() !!}
    </div>
</div>