<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="{{ route($user->role . '.users')}}" method="get">
        <input type="text" name="search">


        
    </form>
        @if($userList->count() > 0)
        <h3>Found {{ $userList->total() }} users</h3>
        
        @foreach ($userList as $list)
    <div>
        <strong>ID:</strong> {{ $list->id }}<br>
        <strong>Name:</strong> {{ $list->firstName }} {{ $list->lastName }}<br>
        <strong>Email:</strong> {{ $list->email }}<br>
        <strong>Role:</strong> {{ $list->role }}<br>
        <strong>Status:</strong> {{ $list->status }}<br>
        
        <!-- Pass $list->id as the parameter -->
        <form action="{{ route($user->role . '.update.role', $list->id) }}" method="post">
            @csrf
            @method('PUT')
            
            <input type="radio" name="role" id="admin_{{ $list->id }}" value="admin" 
                   {{ $list->role == 'admin' ? 'checked' : '' }}>
            <label for="admin_{{ $list->id }}">admin</label>
            
            <input type="radio" name="role" id="subadmin_{{ $list->id }}" value="subadmin" 
                   {{ $list->role == 'subadmin' ? 'checked' : '' }}>
            <label for="subadmin_{{ $list->id }}">subadmin</label>
            
            <input type="radio" name="role" id="resident_{{ $list->id }}" value="resident" 
                   {{ $list->role == 'resident' ? 'checked' : '' }}>
            <label for="resident_{{ $list->id }}">resident</label>
            
            <input type="radio" name="role" id="non-resident_{{ $list->id }}" value="non-resident" 
                   {{ $list->role == 'non-resident' ? 'checked' : '' }}>
            <label for="non-resident_{{ $list->id }}">non-resident</label>
            
            <button type="submit">submit</button>
        </form>
        <hr>
    </div>
@endforeach

      
        @else
        <p>No users found.</p>
        @endif
</body>
</html>