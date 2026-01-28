@foreach ($house as $houses)
    {{ $houses->house_no }}
    <a href="{{ route('admin.householdHead', $houses->id) }}">View Household</a>
@endforeach