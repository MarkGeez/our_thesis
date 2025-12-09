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

                    <label>Title</label>
                    <input class="form-control" type="text" name="title" required>

                    <label class="mt-2">Details</label>
                    <textarea class="form-control" name="details" rows="6"></textarea>

                    <label class="mt-2">Event Start</label>
                    <input class="form-control datetime-picker" type="text" name="eventTime">

                    <label class="mt-2">Event End</label>
                    <input class="form-control datetime-picker" type="text" name="eventEnd">

                    <label class="mt-2">Image</label>
                    <input class="form-control" type="file" name="image">

                    <button class="btn btn-primary mt-3" type="submit">Post Announcement</button>
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