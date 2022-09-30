@extends('layouts.app')

@section('content')
<!--Add Weekly Data -->
<div class="modal fade" id="EnterWeeklyDataModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Enter Weekly Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="add_form" enctype="multipart/form-data" action="">
                    @csrf
                    <div class="alert" id="message" style="display: none"></div>
                    <div class="form-group">
                        <label for="name">Data:</label>
                        <input type="textarea" name="data" id="data" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" name="file" id="file" class="form-control"><br />

                    </div>
                    <button type="submit" class=" enter_data btn btn-dark btn-sm mt-2">Save</button>


                </form>
            </div>
        </div>
    </div>
</div>
<!--End Weekly Data Modal -->
<!--Edit Weekly Data Modal -->
<div class="modal fade" id="EditWeeklyDataModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Weekly Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="update_form" enctype="multipart/form-data" action="">



                    <input type="hidden" id="edit_data_id" />
                    <div class="form-group">
                        <label for="name">Data</label>
                        <input type="textarea" name="edit_data" id="edit_data" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" name="edit_file" id="edit_file" class="form-control"><br />

                    </div>
                    <button class=" update_data btn btn-dark btn-sm mt-2">Update</button>


                </form>
            </div>
        </div>
    </div>
</div>
<!--End Edit Weekly Data Modal -->
<!-- Delete Weekly Data Modal -->
<div class="modal fade" id="DeleteWeeklyDataModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Weekly Data </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="delete_data_id" />
                <h4>Are you sure ? want to delete this data ?</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary distroy_data">Delete</button>
            </div>
        </div>
    </div>
</div>
<!--End Delete Weekly Data Modal -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}
                    <i class="fas fa-plus  text-primary float-end" data-bs-toggle="modal" data-bs-target="#EnterWeeklyDataModal" style="cursor:pointer;">add</i>
                </div>

                <div class="card-body">
                    <div id="success_message"></div>
                    <div id="table_data">
                        @include('pagination')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        fetchData();
        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            fetchData(page);
        });

        function fetchData(page) {
            $.ajax({
                type: "GET",
                url: "home/create?page=" + page,
                success: function(data) {
                    $('#table_data').html(data);
                }
            });
        }
        //Enter Data
        $('#add_form').on('submit', function(e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "/home",
                method: "POST",
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    $('#success_message').css('display', 'block');
                    $('#success_message').html(data.message);
                    $('#success_message').addClass(data.class_name);
                    $('#success_message').delay(10000).fadeOut('slow');
                    $('#EnterWeeklyDataModal').modal('hide');
                    $("#add_form")[0].reset();
                    fetchData();


                }
            })
        });
        //Edit Data
        $(document).on('click', '.edit_data', function(e) {

            e.preventDefault();
            let data_id = $(this).attr("id");


            $('#EditWeeklyDataModal').modal('show');
            $.ajax({
                type: "GET",
                url: "/home/" + data_id + "/edit",
                success: function(data) {
                    //console.log(response);
                    if (data.success == false) {

                        $('#success_message').html('');
                        $('#success_message').addClass(data.class_name);
                        $('#success_message').text(data.message);
                        $('#success_message').delay(10000).fadeOut('slow');
                    } else {

                        $('#edit_data').val(data.data.data);


                        $('#edit_file').val('');
                        $('#edit_data_id').val(data_id);
                    }

                }
            });
        });
        // Update Data
        $(document).on('submit', '#update_form', function(e) {
            e.preventDefault();
            let data_id = $('#edit_data_id').val();


            let data = new FormData();
            data.append('edit_data', $('#edit_data').val());


            data.append('edit_file', edit_file.files[0]);
            data.append('_method', 'put');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            $.ajax({
                url: "/home/" + data_id,
                type: 'post',
                data: data,
                cache: false,
                dataType: 'json',
                processData: false,
                contentType: false,
                success: function(data) {

                    $('#success_message').css('display', 'block');
                    $('#success_message').html(data.message);
                    $('#success_message').addClass(data.class_name);
                    $('#success_message').delay(10000).fadeOut('slow');
                    $('#EditWeeklyDataModal').modal('hide');
                    $('#EditWeeklyDataModal').find('input').val('');
                    $("#update_form")[0].reset();
                    fetchData();
                }
            });
        });
        //Delete Data
        $(document).on('click', '.delete_data', function(e) {
            e.preventDefault();


            let data_id = $(this).attr("id");
            $('#delete_data_id').val(data_id);
            $('#DeleteWeeklyDataModal').modal('show');
        });
        $(document).on('click', '.distroy_data', function(e) {
            e.preventDefault();
           
            let data_id = $('#delete_data_id').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "DELETE",
                url: "/home/" + data_id,
                success: function(data) {
                    $('#success_message').css('display', 'block');
                    $('#success_message').html(data.message);
                    $('#success_message').addClass(data.class_name);
                    $('#success_message').delay(10000).fadeOut('slow')
                    $('#DeleteWeeklyDataModal').modal('hide');
                   
                    fetchData();
                }
            });
        });
    });
</script>
@endsection