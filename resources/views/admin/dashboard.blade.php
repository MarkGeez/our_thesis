<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>admin</h1>
    @foreach($announcement as $announcements)
    <div>
        <H1>{{ $announcement->title }}</H1>
        <p>{{ $announcement->details }}</p>
        <p> {{ $announcement->user->firstName . ',' . $announcement->user->lastName }}</p>
    </div>
    @endforeach
</body>
</html>