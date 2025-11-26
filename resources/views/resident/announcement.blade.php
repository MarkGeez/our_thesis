
    <h1>{{ $resident->firstName }}</h1>
    <nav>
        
        <ul>
            <li><a href="{{ route('resident.dashboard', ['id' => $resident->id]) }}">Dashboard</a></li>
            <li><a href="{{ route('resident.profile', ['id' => $resident->id]) }}">Profile</a></li>
            <li><a href="{{ route('resident.announcement', ['id' => $resident->id]) }}">Announcement</a></li>
            <li><a href="{{ route('resident.blotter', ['id' => $resident->id]) }}">Blotter</a></li>
            <li><a href="{{ route('resident.certificate', ['id' => $resident->id]) }}">Certificate</a></li>
            <li><a href="{{ route('resident.clearance', ['id' => $resident->id]) }}">Clearance</a></li>
            <li><a href="{{ route('resident.service', ['id' => $resident->id]) }}">Service</a></li>
            <li><a href="{{ route('resident.complaint', ['id' => $resident->id]) }}">Complaint</a></li>
            <li><a href="{{ route('resident.feedback', ['id' => $resident->id]) }}">Feedback</a></li>
        </ul>
        
    </nav>

    
