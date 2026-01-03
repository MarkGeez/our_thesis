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
        
        @foreach ($userList as $user)
            <div>
                <strong>ID:</strong> {{ $user->id }}<br>
                <strong>Name:</strong> {{ $user->firstName }} {{ $user->lastName }}<br>
                <strong>Email:</strong> {{ $user->email }}<br>
                <strong>Role:</strong> {{ $user->role }}<br>
                <strong>Status:</strong> {{ $user->status }}<br>
                <hr>
            </div>
        @endforeach

      
        @else
        <p>No users found.</p>
        @endif
</body>
</html>