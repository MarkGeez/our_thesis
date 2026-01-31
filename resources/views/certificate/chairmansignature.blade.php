@php
    $officialsByPosition = $officialsByPosition ?? collect();
    $chairman = $officialsByPosition->get('Barangay Chairman')?->resident;
    $chairmanName = $chairman
        ? ucwords(strtolower(trim($chairman->firstName . ' ' . $chairman->middleName . ' ' . $chairman->lastName)))
        : '';
@endphp
<style>
    .signature{text-align:right;margin-top:40px}
    .signature-line{border-top:1px solid #222;width:250px;margin-left:auto;padding-top:4px}
    @media print{}
</style>
<div class="signature" style="margin-top: 175px;">
    @if($chairmanName)
        <div class="signature-line">{{ $chairmanName }}</div>
    @endif
    <div style="font-size:12px;margin-top:6px">Punong Barangay</div>
</div>
