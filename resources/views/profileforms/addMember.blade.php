@php
    $user= auth()->user();
@endphp


<form method="POST" action="{{ route($user->role . '.family.store') }}">
@csrf

<input name="firstName" required>
<input name="middleName">
<input name="lastName" required>
<input type="date" name="birthday" required>

<select name="sex">
    <option value="male">Male</option>
    <option value="female">Female</option>
</select>

<input name="contactNo">

<button type="submit">Add Family Member</button>
</form>
