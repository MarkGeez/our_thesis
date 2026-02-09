<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Affidavit from Barangay of Solo Parent</title>
    <style>
        :root {
            --navy: #0a3a8a;
            --gold: #ffd000;
            --red: #d11f2a;
            --text: #111;
        }
        body {
            margin: 0;
            background: white;
            font-family: 'Times New Roman', serif;
            color: var(--text);
        }
        @page { size: A4; margin: 10mm; }
        .page {
            width: 100%;
            padding: 0;
            border: none;
            margin: 0;
        }
        .header-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            border-bottom: 10px solid #180b5f;
            box-shadow: 0 10px 0 yellow;
        }
        .logo-small { width: 80px; height: auto; }
        .content { padding: 15px; }
        .right {
            width: 100%;
            padding: 20px 40px;
            border-bottom: 6px solid yellow;
            min-height: 800px;
        }
        .cert-title {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            margin: 35px 0 5px 0;
        }
        .cert-subtitle {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin: 0 0 30px 0;
        }
        .intro {
            text-indent: 50px;
            margin-bottom: 20px;
            font-size: 14px;
            text-align: justify;
        }
        .checkbox-section {
            margin: 15px 0;
            display: flex;
            align-items: flex-start;
        }
        .checkbox {
            width: 15px;
            height: 15px;
            border: 1px solid #000;
            margin-right: 10px;
            flex-shrink: 0;
            margin-top: 2px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
        .checkbox-input {
            width: 15px;
            height: 15px;
            border: 1px solid #000;
            margin-right: 10px;
            flex-shrink: 0;
            margin-top: 2px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            background: transparent;
            cursor: pointer;
            -webkit-appearance: none;
            appearance: none;
        }
        .checkbox-input:checked::after {
            content: '✓';
            font-size: 12px;
            line-height: 1;
        }
        .checkbox-text { flex: 1; font-size: 14px; text-align: justify; }
        .children-table { margin: 10px 0 10px 25px; width: calc(100% - 25px); }
        .children-row { display: flex; margin: 8px 0; }
        .child-number { width: 20px; }
        .child-name { flex: 1; margin-right: 20px; }
        .child-dob { width: 150px; }
        .table-header {
            display: flex;
            margin: 10px 0 5px 25px;
            font-weight: bold;
            font-size: 13px;
        }
        .header-name { flex: 1; margin-right: 20px; padding-left: 20px; }
        .header-dob { width: 150px; }
        .fill-line {
            display: inline;
            border: none;
            border-bottom: 1px solid #222;
            padding: 0 4px;
            font-size: 14px;
            background: transparent;
        }
        .fill-line:focus { outline: none; }
        .brgylogo-arc {
            position: absolute;
            right: 1px;
            bottom: 375px;
            opacity: 0.12;
            font-size: 120px;
        }
        .watermark-arc {
            position: absolute;
            right: 18px;
            bottom: 150px;
            opacity: 0.12;
            font-size: 120px;
        }
        .signature-block { margin-top: 50px; text-align: right; }
        .signature-line { border-top: 1px solid #222; width: 250px; margin-left: auto; padding-top: 4px; display: inline-block; }
        @media print {
            body { background: white; }
            .page { margin: 0; box-shadow: none; }
            .no-print { display: none !important; }
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
        <main class="right">
            <div class="cert-title">AFFIDAVIT FROM BARANGAY OF</div>
            <div class="cert-subtitle">SOLO PARENT</div>

            <p class="intro" style="line-height: 35px;">
                I,
                @if($editable)
                  <input type="text" class="fill-line" name="name" value="{{ $name }}" style="width:280px">, <input type="text" class="fill-line" name="request_data[age]" value="{{ $data['age'] ?? $req->resident?->age ?? '' }}" style="width:50px"> years old, Filipino, and
                  single, and a bona fide resident of Barangay 249 Zone 23 District II Tondo,
                  Manila, with postal address at 1013, after having duly sworn to in accordance with law, hereby depose and state:
                @else
                  <span class="fill-line">{{ $name }}</span>, <span class="fill-line">{{ $data['age'] ?? $req->resident?->age ?? '______' }}</span> years old, Filipino, and
                  single, and a bona fide resident of Barangay 249 Zone 23 District II Tondo,
                  Manila, with postal address at 1013{{-- <span class="fill-line">{{ $address }}</span> --}}, after having duly sworn to in accordance with law, hereby depose and state:
                @endif
            </p>

            <div class="brgylogo-arc"><img src="{{ asset('images/Brgy-logo-1.png') }}" alt="Barangay Seal" style="width:350px; height: 350px; object-fit:contain"></div>

            <div class="checkbox-section">
                @if($editable)
                    <input type="checkbox" class="checkbox-input" name="request_data[separated_from]" value="1" checked>
                @else
                    <div class="checkbox">✓</div>
                @endif
                
                <div class="checkbox-text">
                    That I was married/unmarried to
                    @if($editable)
                        <input type="text" class="fill-line" name="request_data[separated_from]" value="{{ $data['separated_from'] ?? '' }}" style="width:240px">
                    @else
                        <span class="fill-line">{{ $data['separated_from'] ?? '________________________' }}</span>
                    @endif
                    and during our relationship we begot with
                    @php
                        $childrenList = array_values($data['children'] ?? []);
                    @endphp
                    
                    @if($editable)
                        <input type="text" class="fill-line" name="request_data[num_children]" value="{{ count($childrenList) }}" style="width:60px">
                    @else
                        <span class="fill-line">{{ count($childrenList) }}</span>
                    @endif
                    child/ children named:




                    <div class="table-header">
                        <div class="header-name">Name of Child/ Children</div>
                        <div class="header-dob">Date of Birth</div>
                    </div>

                    <div class="children-table">
                        @php
                            $childrenList = array_values($data['children'] ?? []);
                            $numChildren = intval($data['num_children'] ?? 0);
                            $displayCount = max(count($childrenList), $numChildren, 1);
                        @endphp
                        @for($i = 0; $i < $displayCount; $i++)

<div class="children-row"> <div class="child-number">{{ $i + 1 }}.</div>
<div class="child-name">
    @if($editable)
        <input type="text"
               class="fill-line"
               name="request_data[children][{{ $i }}][name]"
               value="{{ $childrenList[$i]['name'] ?? '' }}"
               style="display:block;min-width:200px">
    @else
        <span class="fill-line" style="display:block;min-width:200px">
            {{ $childrenList[$i]['name'] ?? '' }}
        </span>
    @endif
</div>

<div class="child-dob">
    @if($editable)
        <input type="text"
               class="fill-line"
               name="request_data[children][{{ $i }}][dob]"
               value="{{ $childrenList[$i]['dob'] ?? '' }}"
               style="display:block;min-width:120px">
    @else
        <span class="fill-line" style="display:block;min-width:120px">
            {{ $childrenList[$i]['dob'] ?? '' }}
        </span>
    @endif
</div>

</div> @endfor
                    </div>
                </div>
            </div>

            <div class="checkbox-section">
                @if($editable)
<input type="checkbox" class="checkbox-input"
       name="request_data[whereabouts]" value="1"
       {{ !empty($data['whereabouts']) ? 'checked' : '' }}>
@else
<div class="checkbox">{{ !empty($data['whereabouts']) ? '✓' : '☐' }}</div>
@endif

                <div class="checkbox-text" style="line-height: 28px;">
                    That I have no knowledge of the whereabouts of the father of my child/ children.
                </div>
            </div>

            <div class="checkbox-section">
                @if($editable)
<input type="checkbox" class="checkbox-input"
       name="request_data[separated]" value="1"
       {{ !empty($data['separated']) ? 'checked' : '' }}>
@else
<div class="checkbox">{{ !empty($data['separated']) ? '✓' : '☐' }}</div>
@endif

                <div class="checkbox-text" style="line-height: 28px;">
                    That I had separated from
                    @if($editable)
                        <input type="text" class="fill-line" name="request_data[separated_from]" value="{{ $data['separated_from'] ?? '' }}" style="width:220px">
                    @else
                        <span class="fill-line">{{ $data['separated_from'] ?? '________________________' }}</span>
                    @endif
                    
                    since
                    @if($editable)
                        <input type="text" class="fill-line" name="request_data[since]" value="{{ $data['since'] ?? '' }}" style="width:220px">
                    @else
                        <span class="fill-line">{{ $data['since'] ?? '________________________' }}</span>
                    @endif
                    and at the present time, I have no husband/ partner and as a Solo Parent, I am
                    taking full custody and care of my child/ children mentioned in this affidavit.
                </div>
            </div>

            <div class="checkbox-section">
                @if($editable)
                    <input type="checkbox" class="checkbox-input" name="request_data[attest_truth]" value="1" {{ !empty($data['attest_truth']) ? 'checked' : '' }}>
                @else
                    <div class="checkbox">{{ !empty($data['attest_truth']) ? '✓' : '☐' }}</div>
                @endif
                <div class="checkbox-text" style="line-height: 28px;">
                    That this is being executed to attest to the truth of the foregoing facts
                    and circumstances and for whatever legal intents and purpose this instrument may serve.
                </div>
            </div>

            <div style="margin-top: 60px;">
                @include('certificate.chairmansignature')
            </div>
        </main>
    </div>

    <div class="watermark-arc">
        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/8e/Barangay.svg/2048px-Barangay.svg.png" alt="Barangay Seal" style="width: 175px; height: 175px; object-fit:contain">
    </div>
</div>

@if($editable)
<div class="no-print" style="position:fixed;bottom:20px;right:20px;">
  <button type="submit" form="certEditForm" style="padding:10px 18px;background:#0a3a8a;color:white;border:none;border-radius:4px;font-size:14px;cursor:pointer">Print with current data</button>
</div>
</form>
@endif
@if($forPrint && !$editable)
<button class="no-print" onclick="window.print()" style="position:fixed;bottom:20px;right:20px;padding:10px 18px;background:#0a3a8a;color:white;border:none;border-radius:4px;font-size:14px;cursor:pointer">Print Certificate</button>
<script>window.onload=function(){window.print();}</script>
@endif

</body>
</html>
