@php
    $officialsByPosition = $officialsByPosition ?? collect();
    $chairman = $officialsByPosition->get('Barangay Chairman');
    $chairmanResident = $chairman?->resident;
    $chairmanPhoto = $chairmanResident && $chairmanResident->image_path
        ? asset('storage/' . $chairmanResident->image_path)
        : (asset('template/img/barangay-logo.png'));
    $chairmanName = $chairmanResident
        ? ucwords(strtolower(trim($chairmanResident->firstName . ' ' . $chairmanResident->middleName . ' ' . $chairmanResident->lastName)))
        : '';
    $secretary = $officialsByPosition->get('Barangay Secretary')?->resident;
    $treasurer = $officialsByPosition->get('Barangay Treasurer')?->resident;
    $skChairman = $officialsByPosition->get('SK Chairman')?->resident;
    $kagawadNames = [];
    for ($i = 1; $i <= 7; $i++) {
        $k = $officialsByPosition->get('Kagawad ' . $i)?->resident;
        $kagawadNames[] = $k ? ucwords(strtolower(trim($k->firstName . ' ' . $k->lastName))) : null;
    }
@endphp
<aside class="left" style="font-family: Arial, Helvetica, sans-serif;">
    <div class="circle-photo">
        <img src="{{ $chairmanPhoto }}" alt="Chairman">
    </div>
    @if($chairmanName)
        <h3>{{ $chairmanName }}</h3>
    @endif
    <p class="position">BARANGAY CHAIRMAN</p>

    <div class="names">
        <strong>KAGAWAD</strong>
        @foreach($kagawadNames as $kName)
            @if($kName)
                {{ $kName }}<br>
            @endif
        @endforeach
        <div style="margin-top:15px">
            <strong>SECRETARY</strong>
            @if($secretary)
                <div>{{ ucwords(strtolower(trim($secretary->firstName . ' ' . $secretary->lastName))) }}</div>
            @endif
        </div>
        <div style="margin-top:10px">
            <strong>TREASURER</strong>
            @if($treasurer)
                <div>{{ ucwords(strtolower(trim($treasurer->firstName . ' ' . $treasurer->lastName))) }}</div>
            @endif
        </div>
        <div style="margin-top:10px">
            <strong>SK CHAIRMAN</strong>
            @if($skChairman)
                <div>{{ ucwords(strtolower(trim($skChairman->firstName . ' ' . $skChairman->lastName))) }}</div>
            @endif
        </div>
    </div>

    <div class="footer-note">Not valid without Official Barangay Seal</div>
</aside>
