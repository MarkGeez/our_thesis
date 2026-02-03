<h2>Household – House {{ $house->house_no }}</h2>

<table border="1" cellpadding="8">
    <thead>
        <tr>
            <th>First Name</th>
            <th>Middle Name</th>
            <th>Last Name</th>
            <th>Contact</th>
            <th>Role</th>
        </tr>
    </thead>

    <tbody>
        {{-- Household Heads --}}
        @forelse ($heads as $head)
            <tr>
                <td>{{ $head->resident->firstName }}</td>
                <td>{{ $head->resident->middleName ?? '—' }}</td>
                <td>{{ $head->resident->lastName }}</td>
                <td>{{ $head->resident->contactNo }}</td>
                <td><strong>Head</strong></td>
            </tr>
        @empty
            <tr>
                <td colspan="5">No household head found</td>
            </tr>
        @endforelse

        {{-- Members --}}
        @forelse ($members as $member)
            <tr>
                <td>{{ $member->firstName }}</td>
                <td>{{ $member->middleName ?? '—' }}</td>
                <td>{{ $member->lastName }}</td>
                <td>{{ $member->contactNo ?? '—' }}</td>
                <td>Member</td>
            </tr>
        @empty
            <tr>
                <td colspan="5">No members tagged</td>
            </tr>
        @endforelse
    </tbody>
</table>

<a href="{{ url()->previous() }}">← Back</a>
