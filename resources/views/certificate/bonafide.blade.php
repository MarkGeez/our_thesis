<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Certification</title>
  <style>
    :root{
      --navy:#0a3a8a;
      --gold:#ffd000;
      --red:#d11f2a;
      --text:#111;
    }
    body{margin:0;background:white;font-family:'Times New Roman',serif;color:var(--text)}

    /* Printable A4 layout */
    @page{size:A4;margin:10mm}
.page{width:100%;padding:0;border:none;margin:0}


.header-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 20px;
    border-bottom: 10px solid #180b5f;
    box-shadow: 0 10px 0 yellow; 
}    .logo-small{width:80px;height:auto}

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
    .left .position{text-align:center;font-size:12px;margin:0 0 12px 0; }
.names{font-family: Arial, Helvetica, sans-serif; font-size:13px;line-height:1.6;color:black;text-align:center}    .names strong{display:block;margin-top:0px}
    .footer-note{position:absolute;bottom:10px;left:10px;font-size:10px}

.right {
    flex: 1;
    padding-left: 20px;
    border-bottom: 6px solid yellow;
    min-height: 800px;
}    .cert-title{text-align:center;font-size:20px;font-weight:bold;margin:35px 0 12px 0}

.input-line{border:none;border-bottom:1px solid #222;width:280px;font-size:15px}
    .input-small{border:none;border-bottom:1px solid #222;width:120px;font-size:14px}

    .check-item{display:flex;align-items:center;font-size:14px;margin:6px 0}
    .check-item input{width:16px;height:16px}

    .issued{margin-top:20px;font-size:14px}
    .signature{text-align:right;margin-top:40px}
    .signature-line{border-top:1px solid #222;width:250px;margin-left:auto;padding-top:4px}

    @media print{
      body{background:white}
      .page{margin:0;box-shadow:none}
    }

    .watermark-arc{position:absolute;right:18px;bottom:150px;opacity:0.12;font-size:120px}
    .brgylogo-arc{position:absolute;right:1px;bottom: 375px;;opacity:0.12;font-size:120px}
  </style>
</head>
<body>

<div class="page">

  <div class="header-row" >
    <div style="display:flex;gap:12px;align-items:center">
      <img src="https://poropointfreeport.gov.ph/wp-content/uploads/2024/12/Hi-Res-BAGONG-PILIPINAS-LOGO-1474x1536-1.png" class="logo-small">
      <div>
        <div style="font-size:15px;font-weight:bold">REPUBLIC OF THE PHILIPPINES</div>
        <div style="font-size:13px;margin-top:4px">City of Manila<br>OFFICE OF THE PUNONG BARANGAY<br>Barangay 249 Zone 23 District II</div>
      </div>
    </div>
    <img src="{{ asset('template/img/barangay-logo.png') }}" style="width:80px;height:80px;object-fit:contain">
  </div>

  

  <div class="content">
    @include('certificate.certificateofficials')
    
    <main class="right">

      <div class="cert-title">CERTIFICATION</div>

      <p style="font-size:14px">This is to certify that
        <input class="input-line" name="resident_name"> of legal age is a bonafide resident of BARANGAY 249 ZONE 23 with postal address
        <input class="input-line" name="postal_address">.
      </p>
          <div class="brgylogo-arc"><img src="{{ asset('template/img/barangay-logo.png') }}" alt="Barangay Seal" style="width:350; height: 350px;; object-fit:contain"></div>
      <p style="font-size:14px">It is further certified that the above named person as known to be of good moral character and without any derogatory record in this BARANGAY. </p>
      <div style="font-weight:bold;margin-top:10px">This Certification is being issued upon the request of the bearer for: AS REQUIREMENTS AND/OR TO SUPPORT HIS/HER.</div>
      <div style="margin-top:10px">
          <label class="check-item"><input type="checkbox" name="bonafide"> BONAFIDE RESIDENT</label>
        <label class="check-item"><input type="checkbox" name="medical"> MEDICAL TREATMENT</label>
        <label class="check-item"><input type="checkbox" name="hospital"> HOSPITALIZATION</label>
        <label class="check-item"><input type="checkbox" name="postal"> APPLICATION FOR POSTAL ID</label>
        <label class="check-item"><input type="checkbox" name="school"> SCHOOL REFERENCE <label class="check-item"><input type="checkbox" name="referral"> REFERRAL </label></label>
        <label class="check-item"><input type="checkbox" name="transaction"> TRANSACTION IN BANK</label>
        <label class="check-item"><input type="checkbox" name="overseas"> OVERSEAS TRAVEL PAPERS</label>
        <label class="check-item"><input type="checkbox" name="Ccalamity"> PROCESSING FOR CALAMITY OF DISASTER AID</label>
        <label class="check-item"><input type="checkbox" name="sss"> S.S.S. REFERENCE</label>
        <label class="check-item"><input type="checkbox" name="others"> OTHERS - PLEASE SPECIFY <input class="input-line" name="others_specify" style="width:200px"></label>
      </div>
      <br>
      <div style="font-weight:bold;margin-top:10px">IN WITNESS WHEREOF I have hereunto set my hand and affixed the Official Seal of this office. Done in the Barangay Hall, Barangay 249, Zone 23, District II, City of Manila.</div>
      <div class="issued">
        Given this <input class="input-small" name="issued_day"> day of <input class="input-small" name="issued_month"> 20<input class="input-small" name="issued_year"> at Barangay 249 hall Zone 23 District II, Manila
      </div>

      @include('certificate.chairmansignature')

    </main>
  </div>


  <div class="watermark-arc"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/8e/Barangay.svg/2048px-Barangay.svg.png" alt="Barangay Seal" style="width: 175px;; height: 175px;; object-fit:contain"></div>

</div>

<!--<button onclick="window.print()" style="position:fixed;bottom:20px;right:20px;padding:10px 18px;background:#0a3a8a;color:white;border:none;border-radius:4px;font-size:14px;cursor:pointer">Print Certificate</button>
-->
</body>
</html>