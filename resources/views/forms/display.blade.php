

<table>
    <th></th>
    <td>
         @if($blotters->count() > 0)
                <h1>Your blotters:</h1>
                @foreach ($blotters as $blotter)
                    {{ $blotter->id }}
                @endforeach
        @else
            <h1>No blotters found</h1>

        @endif
            
        
    </td>
</table>