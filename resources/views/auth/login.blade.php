
<form action="{{ route('login.attempt') }}" method="post">
    @csrf
    @if (session('status'))
        <h6>{{ session('status') }}</h6>
    @endif
    <label for="email">Email: </label>
    <input type="email" id="email" name="email" placeholder="Enter your email here:" value="{{old('email')}}">
    <label for="password">Password: </label>
    <input type="password" id="password" name="password" placeholder="Enter your Pasword here:">
    <button type="submit">Submit</button>
</form>

