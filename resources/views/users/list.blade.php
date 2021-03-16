@extends('layouts.layout')

@section('content')
<h2>Users</h2>
<div class="form-row" id="crud-options">
    <button type="button" id="create-user" class="btn btn-success">Create User</button>
</div>

<meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="form-row">
        <div class="col-md-12">
        <table style="width:100%" class="table2 table-bordered2" id="usersTable">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Email</th>
                </tr>
                
            </thead>
            <tbody>
            
            </tbody>
        </table>

        </div>
    </div>

    @component('components.modal', ['id' => 'user-modal', 'name' => 'user-modal', 'title' => 'Create User', 'size' => 'medium'])
        @slot('content')
            <div class="form-row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="user-name" class="form-control" placeholder="Name">
                        <div id="span-name"></div>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="email" id="email" class="form-control" placeholder="Email">
                        <div id="span-email"></div>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="name">Category</label>
                        <input type="text" name="category" id="category" class="form-control" placeholder="Category">
                        <div id="span-category"></div>
                    </div>
                </div>
            </div>
        @endslot

        @slot('footer')

        @endslot
    @endcomponent

@endsection


@section('scripts')
    @include('javascript.user')
@endsection