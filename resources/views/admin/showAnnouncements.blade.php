<style>
    #details{
        resize:none;
    }
</style>

<form action="{{ route('submit.announcement') }}" method="post" enctype="multipart/form-data">
    @csrf
    
    <label for="title">Enter a title</label>
    <input type="text" name="title" id="title" value="{{ old('title') }}" required>

    <br><br>

    <label for="image">Upload An Image</label>
    <input type="file" name="image" id="image">
    <br><br>

    <label for="details">Add extra details</label>
    <textarea name="details" id="details" cols="40" rows="10" required>{{ old('details') }}</textarea>

    <br><br>

    <label for="eventTime">Event Start Date/Time:</label>
    <input type="datetime-local" name="eventTime" id="eventTime" value="{{ old('eventTime') }}">

    <br><br>

    <label for="eventEnd">Event End Date/Time:</label>
    <input type="datetime-local" name="eventEnd" id="eventEnd" value="{{ old('eventEnd') }}">

    <br><br>

    <label for="archiveTime">Archive Time:</label>
    <input type="datetime-local" name="archiveTime" id="archiveTime" value="{{ old('archiveTime') }}" required>

    <br><br>

    <button type="submit">Post Announcement</button>

</form>