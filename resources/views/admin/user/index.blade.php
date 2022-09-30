@extends('layouts.master')
@section('content')

<div class="container py-2">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between">{{ __('User Update List') }}
                    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0" id="search_form">
                        <div class="input-group">
                            <input class="form-control" id="search" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                            <button class="btn btn-primary search_data" id="btnNavbarSearch" type="submit"><i class="fas fa-search"></i></button>
                        </div>
                    </form>
                </div>

                <div class="card-body">
                    <div id="success_message"></div>
                    <div id="table_data">
                        @include('admin.user.pagination')
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
        $(document).on('click', '.pagination a,.search_data', function(event) {
            event.preventDefault();
            let search = $('#search').val();
            var page = $(this).attr('href').split('page=')[1];
            fetchData(page, search);
        });

        function fetchData(page, search) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "GET",
                url: "admin/user/create?page=" + page + "&search=" + search,

                success: function(data) {
                    $('#table_data').html(data);
                }
            });
        }
        $(document).on('click', '.check_data', function(e) {
            e.preventDefault();
            let data_id = $(this).attr("id");
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "PUT",
                url: "admin/user" + data_id,
                data: {
                    data_id: data_id
                },
                dataType: "json",
                success: function(response) {
                    fetchData();

                }
            });
        });

    });
</script>
@endsection