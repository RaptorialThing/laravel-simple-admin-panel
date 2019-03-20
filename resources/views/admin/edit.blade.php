@extends('admin/admin_layout')
@section('content')

@if ($roles->isEmpty())
<div class="row m-2"><i>User has no role yet</i></div>
@else
<table class="table">
	<thead>
		<th>User</th><th>Role</th><th>Delete role</th></thead>

		@foreach ($roles as $role)
		<tr>
			<td>
				{{ $role->name }} ({{ $role->email }})
			</td>
			<td>
				{{ $role->role }} ({{ $role->description }})
			</td>
			<td>
			<form method="POST" action="/admin/deleteRoleFromUser">
				@csrf
				<input type="hidden" name="userId" value="{{ $userId }}">
				<input type="hidden" name="roleToRemove" value="{{ $role->user_role }}">
				<button type="submit" class="btn btn-danger">Remove role from user</button>
			</form>
		@endforeach
</table>
    	@endif
<h1>Add role to user</h1>
<form method="POST" action="/admin/addRoleToUser">
@csrf
<div class="form-group">
    <label for="roleSelect">Role</label>
    <input type="hidden" name="userId" value="{{ $userId }}">
    <select class="form-control" name="roleToAdd" id="roleSelect">
    			@foreach ($availableRoles as $role)
      			<option value="{{$role->id}}">{{$role->role}}</option>
      			@endforeach
    </select>
  </div>
	<button type="submit" class="btn btn-success">Add role to user</button>
</form>


@endsection
