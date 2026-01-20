
<div class="container">
    <h1>Update Blotter #{{ $blotter->id }}</h1>
    
    <!-- Display blotter information -->
    <div class="card mb-4">
        <div class="card-body">
            <h5>Blotter Information</h5>
            <p><strong>Complainant:</strong> {{ $blotter->plaintiffName }} {{ $blotter->plaintiffLastName }}</p>
            <p><strong>Respondent:</strong> {{ $blotter->defendantName }} {{ $blotter->defendantLastName }}</p>
            <p><strong>Current Status:</strong> {{ $blotter->current_status }}</p>
        </div>
    </div>
    
    <!-- Status History -->
    <h4>Status History</h4>
    @if($blotter->update_blotter && $blotter->update_blotter->count() > 0)
        <ul class="list-group mb-4">
            @foreach($blotter->update_blotter as $update)
                <li class="list-group-item">
                    <strong>{{ $update->status }}</strong> - 
                    {{ $update->remarks }} 
                    ({{ \Carbon\Carbon::parse($update->date)->format('M d, Y') }})
                </li>
            @endforeach
        </ul>
    @else
        <p class="text-muted mb-4">No status updates yet.</p>
    @endif

    <!-- Add New Update Form -->
    <h4>Add New Update</h4>
    <form method="POST" action="{{ route('admin.blotter.update.store', $blotter->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="status" class="form-label">Status:</label>
            <select name="status" id="status" class="form-select" required>
                @foreach($availableStatuses as $status)
                    <option value="{{ $status }}">{{ ucfirst(str_replace('_', ' ', $status)) }}</option>
                @endforeach
            </select>
            @error('status')
            {{ $message }}
        @enderror
        </div>

        <div class="mb-3">
            <label for="remarks" class="form-label">Remarks:</label>
            <textarea name="remarks" id="remarks" class="form-control" rows="3" required></textarea>
        </div>
        @error('remarks')
            {{ $message }}
        @enderror
        <div class="mb-3">
            <label for="date" class="form-label">Date:</label>
            <input type="date" name="date" id="date" class="form-control" required>
        </div>
        @error('date')
            {{ $message }}
        @enderror
        <div class="mb-4">
            <label for="photo_path" class="form-label">Photo Path (Optional):</label>
            <input type="file" name="photo_path" accept="image/jpg, image/jpeg, image/png" id="photo_path" class="form-control">
        </div>
        @error('photo_path')
            {{ $message }}
        @enderror
        <button type="submit" class="btn btn-primary">Add Update</button>
        <a href="{{ route('admin.blotter.index') }}" class="btn btn-secondary">Back to List</a>
    </form>
</div>
