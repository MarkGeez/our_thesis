@php
    $role = auth()->role
@endphp

<form action="{{ route($role . '.submit.blotter') }}" method="post" enctype="multipart/form-data">

    @csrf
</form>