<style>
.modal-content .form-control {
  border: 2px solid #dddddd !important;
  box-shadow: none !important;
}

.modal-content .form-control:focus {
  border: 2px solid #0056b3 !important;
  box-shadow: 0 0 0 0.15rem rgba(0,123,255,0.2) !important;
  outline: none !important;
}


</style>

<div class="modal fade" id="createAnnouncement" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Announcement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form action="{{ route('admin.create-announcement') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <label for="title">Title</label>
                    <input class="form-control" type="text" name="title" id="title" placeholder="Enter your title here..." required>
                    @error('title')
                        <p class="bg-primary m-3 p-2">{{ $message }}</p>
                    @enderror

                    <label for="details" class="mt-2">Details</label>
                    <textarea class="form-control" name="details" id="details" rows="6" required></textarea>

                    <label for="eventTime" class="mt-2">Event Start</label>
                    <input class="form-control datetime-picker" type="text" name="eventTime" id="eventTime" placeholder="Click to enter the event start time...">
                    <label for="eventEnd" class="mt-2">Event End</label>
                    <input class="form-control datetime-picker" type="text" name="eventEnd" id="eventEnd" placeholder="Click to enter the event end time...">

                    <label for="image" class="mt-2">Image</label>
                    <input class="form-control" type="file" name="image" id="image">

                    <div class="text-end mt-3">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>

                        <button class="btn btn-primary" type="submit">Post Announcement</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    flatpickr(".datetime-picker", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",  
        altInput: true,         
        altFormat: "F j, Y h:i K", 
        time_24hr: false
    });

    const form = document.querySelector("#createAnnouncement form");
    const msg = document.getElementById("localSuccessMessage");
    if(form && msg){
        form.addEventListener("submit", function() {
            msg.style.display = "block";
            setTimeout(function() {
                msg.style.opacity = "0";
                msg.style.transition = "opacity 0.6s";
                setTimeout(() => msg.remove(), 600);
            }, 2000);
        });
    }
});
</script>