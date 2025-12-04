
    <head>
    <link rel="shortcut icon" href="{{ asset('template/img/svg/logo.svg') }}" type="image/x-icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('template/css/style.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Orbitron:wght@400..900&display=swap" rel="stylesheet">
</head>

 <div class="layer"></div>
    <a class="skip-link sr-only" href="#skip-target">Skip to content</a>
    <div class="page-flex">  
   
    @include('resident.resident-sidebar', ['resident' => $resident])



<div class="main-wrapper">
           
    @include('resident.resident-header', ['resident' => $resident])
            <main class="main users chart-page" id="skip-target">
                <!--Dito lalagay main content-->

                <!-- Button trigger modal -->
                <div class="add-buttons d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModalLong">
                        Add Blotter <i class="fa-solid fa-plus"></i>
                    </button>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#vawcModal">
                        Add VAWC Blotter <i class="fa-solid fa-plus"></i>
                    </button>

                </div>
                <!-- Modal for basic Blotter -->
                <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Blotter Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

                    </div>
                    <div class="modal-body">
                    <form action="">
                        <div class="mb-3">
                            <label for="complainantName" class="form-label">Complainant Name</label>
                            <input type="text" class="form-control" id="complainantName" placeholder="Write your full name here">
                        </div>
                        <div class="mb-3">
                            <label for="complainantAddress" class="form-label">Complainant Address</label>
                            <input type="text" class="form-control" id="complainantAddress" placeholder="Write your full address here">
                        </div>
                        <div class="mb-3">
                            <label for="complainantAge" class="form-label">Complainant Age</label>
                            <input type="number" class="form-control" id="complainantAge" placeholder="Insert your age here">
                        </div>
                        <div class="mb-3">
                            <label for="complainantNumber" class="form-label">Complainant Contact Number</label>
                            <input type="tel" class="form-control" id="complainantNumber" pattern="09[0-9]{9}" placeholder="Insert your contact number here (09XXXXXXXXX)">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Example textarea</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Add Blotter</button>
                    </div>
                    </form>
                    </div>
                </div>
                </div>

                <!-- Table for Blotter Status -->


                <!-- Modal for VAWC Blotter -->
                <div class="modal fade" id="vawcModal" tabindex="-1" aria-labelledby="vawcModalTitle" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">

                        <div class="modal-header">
                            <h6 class="modal-title" id="vawcModalTitle">Violence Against Women and Children Blotter Details</h6>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <form>

                            <div class="mb-3">
                                <label for="vawcComplainant" class="form-label">Complainant Name</label>
                                <input type="text" id="vawcComplainant" class="form-control" placeholder="Write your name here">
                            </div>

                            <div class="mb-3">
                                <label for="vawcVictimRelation" class="form-label">Relationship to Victim</label>
                                <input type="text" id="vawcVictimRelation" class="form-control" placeholder="Write your relationship to the victim here">
                            </div>

                            <div class="mb-3">
                                <label for="vawcContact" class="form-label">Contact Number</label>
                                <input type="tel" id="vawcContact" class="form-control" pattern="09[0-9]{9}" placeholder="Insert your contact number here (09XXXXXXXXX)">
                            </div>

                            <div class="mb-3">
                                <label for="vawcIncidentDetails" class="form-label">Incident Details</label>
                                <textarea id="vawcIncidentDetails" class="form-control" rows="3"></textarea>
                            </div>

                            

                            </form>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-danger">Add VAWC Blotter</button>
                        </div>

                        </div>
                    </div>
                    </div>


            </main>

</div>
</div> 

<script src="{{ asset('template/plugins/chart.min.js') }}"></script>
<script src="{{ asset('template/plugins/feather.min.js') }}"></script>
<script src="{{ asset('template/js/script.js') }}"></script>
<!--    -- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


