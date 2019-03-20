@extends('admin/admin_layout')
@section('content')

<div class="row mt-2"><h1>Create user</h1></div>
<form method="POST" action="/admin/createUser">
    @csrf
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" name="username" id="name" placeholder="Enter username">
    </div>
    <div class="form-group">
        <label for="email">Email address</label>
        <input type="email" class="form-control" name="email" id="email" placeholder="Enter email">
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

<div class="row mt-5"><h1>Edit users</h1></div>

<table class="table">
    <thead>
        <th>User</th><th>Edit</th><th>Delete</th></thead>
        @foreach ($users as $user)
        <tr><td>
            {{ $user->name }} ({{ $user->email }})
        </td>
        <td><form method="GET" action="/admin/{{ $user->id }}/edit">
            @csrf
            <input type="hidden" name="userId" value="{{ $user->id }}">
            <button type="submit" class="btn btn-success">Edit </button>
        </form></td>
        <td>
            <form method="POST" action="/admin/{{ $user->id }}">
                @csrf
                @method('DELETE')
                <input type="hidden" name="userId" value="{{ $user->id }}">
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
            @endforeach
        
</table>

<div class="row mt-2"><h1>Create role</h1></div>
<form method="POST" action="/admin/createRole">
    @csrf
    <div class="form-group">
        <label for="role">Role name</label>
        <input type="text" class="form-control" id="role" name="rolename" placeholder="Enter new role name">
        <label for="description">Description</label>

        <textarea class="form-control" id="description" name="description" placeholder="Enter role description"></textarea>   
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

<div class="row mt-5"><h1>Existing Roles</h1></div>

<table class="table">
    <thead>
        <th>Role</th><th>Description</th><th>Modify</th><th>Delete</th></thead>
        @foreach ($roles as $role)
            <tr>
            <form method="post" action="/admin/updateRole/{{ $role->id }}">
            @csrf
            <td><input type="text" class="form-control" name="role" value="{{ $role->role }}" /></td>
            <td><textarea type="text" class="form-control" name="description">{{$role->description}}</textarea></td>
            <td>
            <button type="submit" class="btn btn-success">Modify</button></td>
            </form>
            <td><form method="GET" action="/admin/deleteRole/{{ $role->id }}">
                @csrf
                <button type="submit" class="btn btn-danger">Delete</button></form>
            </form></td>
        </tr>      
        @endforeach
        
</table>



@endsection
