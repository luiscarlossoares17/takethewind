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
                    <th hidden>show</th>
                    <th>User</th>
                    <th>Age</th>
                    <th>Email</th>
                    <th>Category</th>
                    <th>Actions</th>
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
                        <input type="text" name="name" id="name" class="form-control" placeholder="Name">
                        <span class="span-error" id="span-name"></span>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" name="email" id="email" class="form-control" placeholder="Email">
                        <span class="span-error" id="span-email"></span>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="age">Age</label>
                        <input type="number" name="age" id="age" class="form-control" placeholder="Age">
                        <span class="span-error" id="span-age"></span>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="name">Category</label>
                        <select id="category" name="category" class="form-control">
                            <option></option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <span class="span-error" id="span-category"></span>
                    </div>
                </div>
            </div>
            <input type="text" id="userId" hidden>
        @endslot

        @slot('footer')
            @component('components.buttons', [
                'element' => 'modal',
                'buttons' => [
                    [
                        'id' => 'cancelModalButton',
                        'category' => 'cancel',
                        'text' => 'Cancel'
                    ],
                    [
                        'id' => 'editModalButton',
                        'category' => 'save',
                        'text' => 'Update'
                    ],
                    [
                        'id' => 'createModalButton',
                        'category' => 'save',
                        'text' => 'Create'
                    ],
                ]
            ])

            @endcomponent
        @endslot
    @endcomponent

@endsection


@section('scripts')
    @include('javascript.user')
@endsection