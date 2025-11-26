<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="{{ route('register.attempt') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <label for="firstName">Enter your first name</label>
    <input type="text" name="firstName" id="firstName" value="{{ old('firstName') }}">
    @error('firstName')
        <div class="alert">{{ $message}}</div>
    @enderror
    
    <label for="middleName">Enter your middle name</label>
    <input type="text" name="middleName" id="middleName" value="{{ old('middleName') }}">
    @error('middleName')
        <div class="alert">{{ $message}}</div>
    @enderror
    
    <label for="lastName">Enter your last name</label>
    <input type="text" name="lastName" id="lastName" value="{{ old('lastName') }}">
    @error('lastName')
        <div class="alert">{{ $message}}</div>
    @enderror
    
    <label for="email">Enter email</label>
    <input type="text" name="email" id="email" value="{{ old('email') }}">
    @error('email')
        <div class="alert">{{ $message}}</div>
    @enderror
    
    <label for="password">Enter Password</label>
    <input type="password" name="password" id="password"> 
    @error('password')
        <div class="alert">{{ $message }}</div>
    @enderror

    <label for="contactNumber">Enter contact Number</label>
    <input type="text" name="contactNumber" id="contactNumber" value="{{ old('contactNumber') }}" >
    @error('contactNumber')
        <div class="alert">{{ $message}}</div>
    @enderror
    
    <label for="birthday">Enter birthday</label>
    <input type="date" name="birthday" id="birthday" value="{{ old('birthday') }}">
    @error('birthday')
        <div class="alert">{{ $message}}</div>
    @enderror
    
    <label for="proofOfIdentity">Enter proof Of Identity</label>
    <input type="file" accept=".jpg, .jpeg, .png" name="proofOfIdentity" id="proofOfIdentity">
    @error('proofOfIdentity')
        <div class="alert">{{ $message}}</div>
    @enderror
    
    <label for="role">Are you a resident? </label>
    <label for="yes"></label> 
    <input type="radio" name="role" id="yes" value="yes" 
           @checked(old('role', 'yes') == 'yes')>Yes
    
    <label for="no"></label>
    <input type="radio" name="role" id="no" value="no" 
           @checked(old('role') == 'no')>No
    
    @error('role')
        <div class="alert">{{ $message}}</div>
    @enderror

    <button type="submit">Submit</button>
</form>
</body>
</html>