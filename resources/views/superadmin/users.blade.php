
<div class="container mt-5">
	<h2 class="mb-4">User List</h2>
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>Name</th>
				<th>Role</th>
				<th>Update Role</th>
			</tr>
		</thead>
		<tbody>
			@foreach($users as $user)
				<tr>
					<td>{{ $user->firstName }} {{ $user->middleName }} {{ $user->lastName }}</td>
					<td>{{ ucfirst($user->role) }}</td>
					<td>
						<form action="{{ route('superadmin.updateRole', $user->id) }}" method="POST">
							@csrf
							@method('PUT')
							<div class="d-flex gap-2">
								@foreach(['admin', 'subadmin', 'resident', 'non-resident'] as $role)
									<div>
										<input type="radio" name="role" value="{{ $role }}" id="role_{{ $role }}_{{ $user->id }}" @if($user->role === $role) checked @endif>
										<label for="role_{{ $role }}_{{ $user->id }}">{{ ucfirst($role) }}</label>
									</div>
								@endforeach
							</div>
							<button type="submit" class="btn btn-sm btn-primary mt-2">Update</button>
						</form>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>
