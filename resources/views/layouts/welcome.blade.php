@extends('layouts.layout')

@section('content')
    <h2>Welcome to teams manager</h2>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="form-row">
        <div class="col-md-12">
        <table style="width:100%" class="table2 table-bordered2" id="teamusersTable">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Email</th>
                    <th>Team</th>
                </tr>
                
            </thead>
            <tbody>
            
            </tbody>
        </table>

        </div>
    </div>

@endsection

