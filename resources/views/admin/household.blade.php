<p>
@foreach ($street as $streets )
    <tr>
                <td>{{ $streets->street_name }}</td>
                <td>{{ $streets->houses_count }}</td>
                <td>
                    <a href="{{ route('admin.streets.show', $streets->id) }}"
                       class="btn btn-sm btn-primary">
                        View Houses
                    </a>
                </td>
            </tr>
@endforeach

</p>