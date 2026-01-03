
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('template/img/svg/logo.svg') }}" type="image/x-icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('template/css/style.min.css') }}"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

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
            <main class="main users chart-page" id="skip-target">
                <!--Dito lalagay main content-->
    <div class="main-container">
   
  <div class="d-flex justify-content-between align-items-center">
  <h2 style="color:#000000; margin: 20px 45px;">Archives</h2>
  

</div>





  
@if($archive->count() > 0)

<div class="table-responsive" style="margin: 0 3em">
<table class="table table-bordered  table-striped-row table-hover"> 
    <thead class="table-primary">
        <tr>
            <th scope="col">Archived type</th>
            <th scope="col">Archived By</th>
            <th scope="col">Archived Date</th>
            <th scope="col">Original Record Details</th>
        </tr> 
    </thead>
<tbody>
    @foreach($archive as $item)
    <tr>
        <td>{{ ucfirst($item->record_type) }}</td>
        <td>{{ $item->user ? $item->user->firstName . ' ' . $item->user->lastName : 'Unknown' }}</td>
        <td>{{ $item->created_at->format('M-d-Y H:i') }}</td>
        <td>
                @if(is_array($item->data))
                    @foreach($item->data as $key => $value)
                        <div>{{ ucfirst(str_replace('_', ' ', $key)) }}: {{ $value }}</div>                        
                    @endforeach
                @endif
            </td>
        </tr>
    @endforeach
</tbody>

</table>
</div>
@else
    <p>No archived records found.</p>
  @endif
</main>

</div>
</div> 
@include('admin.create-announcement')


<script src="{{ asset('template/plugins/chart.min.js') }}"></script>
<script src="{{ asset('template/plugins/feather.min.js') }}"></script>
<script src="{{ asset('template/js/script.js') }}"></script>
<!--    -- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


