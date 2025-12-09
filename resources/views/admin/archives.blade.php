@if($archive->count() > 0)
    @foreach($archive as $item)
        <div class="archive-item">
            <h2>Archived type: {{ ucfirst($item->record_type) }}</h2>
            
            <p><strong>Archived By:</strong> {{ $item->archived_by }}</p>
            <p><strong>Archived At:</strong> {{ $item->created_at->format('M-d-Y H:i') }}</p>
            
            <hr>
            
            <h3>Original Record Details:</h3>
            <ul>
                @if(is_array($item->data))
                    @foreach($item->data as $key => $value)
                        <div>{{ ucfirst(str_replace('_', ' ', $key)) }}: {{ $value }}</div>                        
                    @endforeach
                @endif
            </ul>
            
            <hr style="margin: 20px 0;">
        </div>
    @endforeach
@else
    <p>No archived records found.</p>
@endif