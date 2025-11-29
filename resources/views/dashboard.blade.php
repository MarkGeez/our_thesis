<h1>welcome {{ Auth::user()->name }} to the dashboard</h1>



<section class="announcements">
        <h2>Latest Announcements</h2>
        
        @if($announcements->count() > 0)
            @foreach($announcements as $announcement)
                <div class="announcement-card">
                    <h3>{{ $announcement->title }}</h3>
                    <p>{{ $announcement->details }}</p>
                    <!-- Add more announcement details as needed -->
                </div>
            @endforeach
        @else
            <p>No announcements available.</p>
        @endif
