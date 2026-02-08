<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Senior Citizen Certification - OSCA</title>
    <style>
        :root {
            --navy: #0a3a8a;
            --header-blue: #4a7ebb;
            --text: #111;
        }
        body {
            margin: 0;
            background: #f0f0f0;
            font-family: 'Times New Roman', serif;
            color: var(--text);
            display: flex;
            justify-content: center;
            padding: 20px;
        }
        @page { size: A4; margin: 0; }
        .page {
            width: 210mm;
            min-height: 297mm;
            padding: 20mm;
            background: white;
            position: relative;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            box-sizing: border-box;
        }
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            text-align: center;
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
        }
        .header-logo { width: 80px; height: auto; }
        .header-text { flex-grow: 1; }
        .republic { font-size: 14px; margin-bottom: 2px; }
        .office-title {
            font-size: 22px;
            font-family: 'Goudy Text MT', 'Old English Text MT', serif;
            font-weight: bold;
            margin: 0;
        }
        .address-line { font-size: 13px; margin-top: 2px; }
        .cert-title {
            text-align: center;
            font-size: 32px;
            font-weight: normal;
            color: var(--header-blue);
            letter-spacing: 12px;
            margin: 60px 0;
            text-transform: uppercase;
        }
        .content-body {
            font-size: 18px;
            line-height: 1.8;
            text-align: justify;
        }
        .paragraph { margin-bottom: 30px; text-indent: 50px; }
        .fill-line {
            display: inline;
            border: none;
            border-bottom: 1px solid #000;
            padding: 0 4px;
            font-size: 18px;
            background: transparent;
        }
        .fill-line:focus { outline: none; }
        .signature-section {
            margin-top: 80px;
            float: right;
            text-align: center;
            width: 300px;
        }
        @media print {
            body { background: white; padding: 0; }
            .page { box-shadow: none; width: 100%; height: 100%; }
            .no-print { display: none !important; }
        }
        .print-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            padding: 10px 18px;
            background: var(--navy);
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            z-index: 100;
        }
    </style>
</head>
<body>
@php $editable = $editable ?? false; @endphp
@if($editable)
<form id="certEditForm" method="POST" action="{{ route('admin.certificate.printWithData') }}" target="_blank">
  @csrf
  <input type="hidden" name="certificate_id" value="{{ $req->id }}">
@endif

@if($forPrint && !$editable)
<button class="print-button no-print" onclick="window.print()">Print Certificate</button>
@endif

<div class="page">
    <div class="header-container">
        <img src="{{ asset('images/Brgy-logo-1.png') }}" class="header-logo" alt="Barangay Logo">
        <div class="header-text">
            <div class="republic">Republic of the Philippines</div>
            <h1 class="office-title">Office of the Barangay Chairman</h1>
            <div class="address-line">Barangay 249 Zone 23 District II Tondo Manila</div>
            <div class="address-line">City of Manila</div>
        </div>
        <div style="display: flex; gap: 5px;">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/29/Ph_seal_ncr_manila.svg/250px-Ph_seal_ncr_manila.svg.png" class="header-logo" style="width: 60px;" alt="Manila Seal">
            <img src="{{ asset('images/Bagong_Pilipinas_logo.png') }}" class="header-logo" style="width: 60px;" alt="Bagong Pilipinas">
        </div>
    </div>

    <div class="cert-title">CERTIFICATION</div>

    <div class="content-body">
        <div class="paragraph">
            This is to certify that
            @if($editable)
    <input type="text" class="fill-line" name="name" value="{{ $name }}" style="width:300px">,
    legal age, and formerly residing at 
    <input type="text" class="fill-line" name="former_address" value="{{ $address }}" style="width:250px"> 
    has already transferred to Barangay 249 Zone 23 District II Tondo, Manila.
@else
    <span class="fill-line">{{ $name }}</span>,
    legal age, and formerly residing at 
    <span class="fill-line">{{ $address }}</span> 
    has already transferred to Barangay 249 Zone 23 District II Tondo, Manila.
@endif

        </div>
        <div class="paragraph">
            This certifies further that the above-named person, a Senior Citizen, was already stricken off in the Senior Masterlist Record in our Barangay as per memorandum from MBB and OSCA.
        </div>
        <div class="paragraph">
            This certification is issued upon the request of the aforementioned name for <strong>OSCA Senior Citizen updating record.</strong>
        </div>
        <div class="paragraph" style="margin-top: 50px; text-indent: 0;">
            Issued this
            @if($editable)
              <input type="text" class="fill-line" name="issued_day" value="{{ $issued->format('j') }}" style="width:60px"> day of <input type="text" class="fill-line" name="issued_month" value="{{ $issued->format('F') }}" style="width:120px">, <input type="text" class="fill-line" name="issued_year" value="{{ $issued->format('Y') }}" style="width:60px">
            @else
              {{ $issued->format('j') }} day of {{ $issued->format('F') }}, {{ $issued->format('Y') }}
            @endif
            at Barangay 249 Zone 23 District II hall.
        </div>
    </div>

    <div class="signature-section">
        @include('certificate.chairmansignature')
    </div>
</div>

@if($editable)
<div class="no-print" style="position:fixed;bottom:20px;right:20px;">
  <button type="submit" form="certEditForm" style="padding:10px 18px;background:var(--navy);color:white;border:none;border-radius:4px;font-size:14px;cursor:pointer">Print with current data</button>
</div>
</form>
@endif
@if($forPrint && !$editable)
<script>window.onload=function(){window.print();}</script>
@endif
</body>
</html>
