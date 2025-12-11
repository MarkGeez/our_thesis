<head>
    <link rel="shortcut icon" href="{{ asset('template/img/svg/logo.svg') }}" type="image/x-icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('template/css/style.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Orbitron:wght@400..900&display=swap" rel="stylesheet">

    <style>
    

    </style>
</head>

 <div class="layer"></div>
    <a class="skip-link sr-only" href="#skip-target">Skip to content</a>
    <div class="page-flex">  
   
   @include('admin.admin-sidebar', ['admin' => auth()->user()])



<div class="main-wrapper">
           
    @include('admin.admin-header', ['admin' => auth()->user()])
            <main class="main users chart-page" id="skip-target"></main>

</main>
<form action="{{ route('admin.submit.complaint') }}" method="POST">
    @csrf
    
    <div>
        <label for="address">Address location to be complained </label>
        <input type="text" 
               name="address" 
               id="address" 
               value="{{ old('address') }}"
               required>
        @error('address')
            <div style="color: red;">{{ $message }}</div>
        @enderror
    </div>
    
    <div>
        <label for="details">Details of complaint </label>
        <textarea name="details" 
                  id="details" 
                  rows="5"
                  required>{{ old('details') }}</textarea>
        @error('details')
            <div style="color: red;">{{ $message }}</div>
        @enderror
    </div>
    
    
    
    <button type="submit">Submit Complaint</button>
</form>

<h1>Complaints made</h1>
@foreach ($myComplaints as $complaints)
    <p>{{ $complaints->complainant_id }}</p> 
    <P>{{ $complaints->details }}</P>   
@endforeach

<table>
    

</table>
</div>
</div> 

<script src="{{ asset('template/plugins/chart.min.js') }}"></script>
<script src="{{ asset('template/plugins/feather.min.js') }}"></script>
<script src="{{ asset('template/js/script.js') }}"></script>