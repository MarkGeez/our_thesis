

<table>
    <tr>
        <th>House No</th>
        <th>Households</th>
        <th>Action</th>
    </tr>

    @foreach ($houses as $house)
    <tr>
        <td>{{ $house->house_no }}</td>
        <td>{{ $house->households_count }}</td>
        <td>
            <a href="{{ route('admin.households.heads', $house->id) }}">
                View Household Head
            </a>
        </td>
    </tr>
    @endforeach
</table>

