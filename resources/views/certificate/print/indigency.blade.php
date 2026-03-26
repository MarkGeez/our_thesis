<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Certification of Indigency</title>
  <style>
    :root{ --navy:#0a3a8a; --gold:#ffd000; --red:#d11f2a; --text:#111; }
    body{margin:0;background:white;font-family:'Times New Roman',serif;color:var(--text)}
    @page{size:A4;margin:10mm}
    .page{width:100%;padding:0;border:none;margin:0}
    .header-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px 20px;
      border-bottom: 10px solid #180b5f;
      box-shadow: 0 10px 0 yellow;
    }
    .logo-small{width:80px;height:auto}
    .content{display:flex;padding:15px}
    .left {
      width: 30%;
      border-right: 6px solid yellow;
      border-bottom: 6px solid yellow;
      padding-right: 1px;
      position: relative;
      box-shadow: 7px 0 0 red;
      min-height: 800px;
    }
    .circle-photo{width:130px;height:130px;border-radius:50%;overflow:hidden;margin:10px auto;border:5px solid #dfe6f5}
    .circle-photo img{width:100%;height:100%;object-fit:cover}
    .left h3{text-align:center;font-size:16px;margin:8px 0;color:var(--navy)}
    .left .position{text-align:center;font-size:12px;margin:0 0 12px 0;}
    .names{font-family: Arial, Helvetica, sans-serif; font-size:13px;line-height:1.6;color:black;text-align:center}
    .names strong{display:block;margin-top:0px}
    .footer-note{position:absolute;bottom:10px;left:10px;font-size:10px}
    .right {
      flex: 1;
      padding-left: 20px;
      border-bottom: 6px solid yellow;
      min-height: 800px;
      position: relative;
    }
    .cert-title{text-align:center;font-size:20px;font-weight:bold;margin:35px 0 12px 0}
    .fill-line{display:inline;border:none;border-bottom:1px solid #222;padding:0 4px;font-size:15px;background:transparent}
    .fill-line:focus{outline:none}
    .check-item{display:flex;align-items:center;gap:14px;font-size:14px;margin:10px 0;width:100%}
    .check-item .check{color:#000000;font-weight:bold;font-size:16px;display:inline-block;min-width:18px;text-align:center;}
    .check-item input[type="checkbox"]{width:16px;height:16px;margin-right:0;accent-color:#000000;cursor:pointer;flex:0 0 auto;}
    .signature{text-align:right;margin-top:40px}
    .signature-line{border-top:1px solid #222;width:250px;margin-left:auto;padding-top:4px}
    .watermark-arc{position:absolute;right:18px;bottom:150px;opacity:0.12}
    .brgylogo-arc{position:absolute;left:50%;top:50%;transform:translate(-50%, -50%);opacity:0.12;pointer-events:none}
    @media print{ body{background:white} .page{margin:0} .no-print{display:none!important;} }
  </style>
</head>
<body>
@php $editable = $editable ?? false; @endphp
@if($editable)
<form id="certEditForm" method="POST" action="{{ route('admin.certificate.printWithData') }}" target="_blank">
  @csrf
  <input type="hidden" name="certificate_id" value="{{ $req->id }}">
@endif
<div class="page">
  <div class="header-row">
    <div style="display:flex;gap:12px;align-items:center">
      <img src="{{ asset('images/Bagong_Pilipinas_logo.png') }}" class="logo-small" alt="">
      <div>
        <div style="font-size:15px;font-weight:bold">REPUBLIC OF THE PHILIPPINES</div>
        <div style="font-size:13px;margin-top:4px">City of Manila<br>OFFICE OF THE PUNONG BARANGAY<br>Barangay 249 Zone 23 District II</div>
      </div>
    </div>
    <img src="{{ asset('images/Brgy-logo-1.png') }}" style="width:80px;height:80px;object-fit:contain" alt="">
  </div>
  <div class="content">
    {{--  @include('certificate.certificateofficials')--}}
    <main class="right">
      <div class="cert-title">CERTIFICATION OF INDIGENCY</div>
      <div class="brgylogo-arc"><img src="{{ asset('images/Brgy-logo-1.png') }}" alt="Barangay Seal" style="width:450px;height:450px;object-fit:contain"></div>
      <div style="position:relative;z-index:1;">
        <p style="font-size:16px;text-align:justify;text-indent:50px;line-height:1.8;">This is to certify that
          @if($editable)
            <input type="text" class="fill-line" name="name" value="{{ $name }}" style="width:300px"> of legal age, a bonafide resident of BARANGAY 249 ZONE 23 DISTRICT II with postal address at <input type="text" class="fill-line" name="address" value="{{ $address }}" style="width:280px">


          @else
            <span class="fill-line">{{ $name }}</span> of legal age, a bonafide resident of BARANGAY 249 ZONE 23 DISTRICT II with postal address at <span class="fill-line">{{ $address }}</span>.
          @endif
         {{--  This Certification is being issued upon the request of the bearer for:
    @if($editable)
        <input type="text" class="fill-line" name="purpose" value="{{ $purpose }}" style="width:300px">
    @else
        <span class="fill-line">{{ $purpose }}</span>.
    @endif
           --}}
        </p>
        <p style="font-size:16px;text-align:justify;text-indent:50px;line-height:1.8;">That as a resident of said Barangay, he/she is personally known to me. His/Her family belongs to the indigent families in our Barangay.</p>
        <div style="font-weight:bold;margin:30px 0 10px 0;font-size:16px;">This Certification is being issued for:</div>
        <div style="margin-left:20px;" class="check-list">
          @php $checks = ['medical'=>'MEDICAL ASSISTANCE','educational'=>'EDUCATIONAL ASSISTANCE','burial'=>'BURIAL ASSISTANCE','financial'=>'FINANCIAL ASSISTANCE','others'=>'OTHERS']; @endphp
          @foreach($checks as $key => $label)
          <label class="check-item">
            @if($editable)
              <input type="checkbox" name="request_data[{{ $key }}]" value="1" {{ !empty($data[$key]) ? 'checked' : '' }}>
            @else
              <span class="check">{{ !empty($data[$key]) ? '✓' : '☐' }}</span>
            @endif
            {{ $label }}@if($key==='others') @if($editable)<input type="text" class="fill-line" name="request_data[others_specify]" value="{{ $data['others_specify'] ?? '' }}" style="width:150px">@else - {{ $data['others_specify'] ?? '' }}@endif @endif
          </label>
          @endforeach
        </div>
        <p style="text-align:justify;text-indent:50px;line-height:1.8;margin-top:40px;font-size:16px;">Issued this
          @if($editable)
            <input type="text" class="fill-line" name="issued_day" value="{{ $issued->format('j') }}" style="width:40px"> day of <input type="text" class="fill-line" name="issued_month" value="{{ $issued->format('F') }}" style="width:120px">, <input type="text" class="fill-line" name="issued_year" value="{{ $issued->format('Y') }}" style="width:50px">
          @else
            {{ $issued->format('j') }} day of {{ $issued->format('F') }}, {{ $issued->format('Y') }}
          @endif
          at Barangay 249 Zone 23 District II, City of Manila.</p>
      </div>
      @include('certificate.chairmansignature')
    </main>
  </div>
  <div class="watermark-arc"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/8e/Barangay.svg/2048px-Barangay.svg.png" alt="" style="width:175px;height:175px;object-fit:contain"></div>
</div>
@if($editable && $req->status === 'approved')
<div class="no-print" style="position:fixed;bottom:20px;right:20px;">
  <button type="submit" form="certEditForm" style="padding:10px 18px;background:#0a3a8a;color:white;border:none;border-radius:4px;font-size:14px;cursor:pointer">Print with current data</button>
</div>
</form>
@endif
@if($forPrint && !$editable)
<div class="no-print" style="position:fixed;bottom:20px;right:20px;">
  <button onclick="window.print()" style="padding:10px 18px;background:#0a3a8a;color:white;border:none;border-radius:4px;font-size:14px;cursor:pointer">Print Certificate</button>
</div>
<script>window.onload=function(){window.print();}</script>
@endif
</body>
</html>
