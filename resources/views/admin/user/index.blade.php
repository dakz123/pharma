@extends('layouts.master')
@section('content')

<div class="container py-2">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between">{{ __('User Update List') }}
                    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0" id="search_form" action="" method="GET">
                        <div class="input-group">
                            <input class="form-control" id="search" name="search" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
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