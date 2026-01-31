
<h2>Household Head – House {{ $house->house_no }}</h2>

<table>
    <tr>
        <th>Name</th>
        <th>Contact</th>
    </tr>

    @forelse ($heads as $head)
    <tr>
        <td>
            {{ ucfirst($head->resident->firstName) }}
            {{ ucfirst($head->resident->lastName) }}
        </td>
        <td>{{ $head->resident->contactNo }}</td>
    </tr>
    @empty
    <tr>
        <td colspan="2">No household head found</td>
    </tr>
    @endforelse
</table>

<a href="{{ url()->previous() }}">← Back</a>
