@extends('layouts.layout')

@section('content')
<h2>Teams</h2>
<div class="form-row" id="crud-options">
    <button type="button" id="create-team" class="btn btn-success">Create Team</button>
</div>

<meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="form-row">
        <div class="col-md-12">
        <table style="width:100%" class="table2 table-bordered2" id="teamsTable">
            <thead>
                <tr>
                    <th hidden>show</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
                
            </thead>
            <tbody>
            
            </tbody>
        </table>

        </div>
    </div>

    @component('components.modal', ['id' => 'team-modal', 'name' => 'team-modal', 'title' => 'Create Team', 'size' => 'large'])
        @slot('content')
            <div class="form-row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Name">
                        <div id="span-name"></div>
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
    @include('javascript.team')
@endsection