<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Senior Citizen Certification - OSCA</title>
    <style>
        :root {
            --navy: #0a3a8a;
            --header-blue: #4a7ebb; /* Blue color for 'CERTIFICATION' in image */
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

        @page {
            size: A4;
            margin: 0;
        }

        .page {
            width: 210mm;
            min-height: 297mm;
            padding: 20mm;
            background: white;
            position: relative;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            box-sizing: border-box;
        }

        /* Header Layout matching the 3-logo style in the image */
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            text-align: center;
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
        }

        .header-logo {
            width: 80px;
            height: auto;
        }

        .header-text {
            flex-grow: 1;
        }

        .republic { font-size: 14px; margin-bottom: 2px; }
        
        /* Stylized font for 'Office of the Barangay Chairman' */
        .office-title { 
            font-size: 22px; 
            font-family: 'Goudy Text MT', 'Old English Text MT', serif; 
            font-weight: bold;
            margin: 0;
        }

        .address-line { font-size: 13px; margin-top: 2px; }

        /* Main Certification Title */
        .cert-title {
            text-align: center;
            font-size: 32px;
            font-weight: normal;
            color: var(--header-blue);
            letter-spacing: 12px;
            margin: 60px 0;
            text-transform: uppercase;
        }

        /* Content Body */
        .content-body {
            font-size: 18px;
            line-height: 1.8;
            text-align: justify;
        }

        .paragraph {
            margin-bottom: 30px;
            text-indent: 50px;
        }

        input[type="text"] {
            border: none;
            border-bottom: 1px solid #000;
            font-family: 'Times New Roman', serif;
            font-size: 18px;
            text-align: center;
            background: transparent;
            outline: none;
        }

        /* Signature Section */
        .signature-section {
            margin-top: 80px;
            float: right;
            text-align: center;
            width: 300px;
        }

        .chairman-name {
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 0;
        }

        .chairman-title {
            font-size: 16px;
            margin-top: 2px;
        }

        @media print {
            body { background: white; padding: 0; }
            .page { box-shadow: none; width: 100%; height: 100%; }
            .print-button { display: none; }
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

    <button class="print-button" onclick="window.print()">Print Certificate</button>

    <div class="page">
        <div class="header-container">
            <img src="Brgy-logo-1.png" class="header-logo" alt="Barangay Logo">
            <div class="header-text">
                <div class="republic">Republic of the Philippines</div>
                <h1 class="office-title">Office of the Barangay Chairman</h1>
                <div class="address-line">Barangay 249 Zone 23 District II Tondo Manila</div>
                <div class="address-line">City of Manila</div>
            </div>
            <div style="display: flex; gap: 5px;">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/29/Ph_seal_ncr_manila.svg/250px-Ph_seal_ncr_manila.svg.png" class="header-logo" style="width: 60px;" alt="Manila Seal">
                <img src="https://poropointfreeport.gov.ph/wp-content/uploads/2024/12/Hi-Res-BAGONG-PILIPINAS-LOGO-1474x1536-1.png" class="header-logo" style="width: 60px;" alt="Bagong Pilipinas">
            </div>
        </div>

        <div class="cert-title">CERTIFICATION</div>

        <div class="content-body">
            <div class="paragraph">
                This is to certify that <input type="text" style="width: 300px;">, legal age, and formerly residing at <input type="text" style="width: 250px;"> St., Tondo, Manila has already transfer to Barangay <input type="text" style="width: 200px;">.
            </div>

            <div class="paragraph">
                This certifies further that the above-named person, a Senior Citizen, was already stricken off in the Senior Masterlist Record in our Barangay as per memorandum from MBB and OSCA.
            </div>

            <div class="paragraph">
                This certification is issued upon the request of the aforementioned name for <strong>OSCA Senior Citizen updating record.</strong>
            </div>

            <div class="paragraph" style="margin-top: 50px; text-indent: 0;">
                Issued this <input type="text" style="width: 60px;"> day of <input type="text" style="width: 120px;">, 2025 at Barangay 249 Zone 23 District II hall.
            </div>
        </div>

        <div class="signature-section">
            @include('certificate.chairmansignature')
        </div>
    </div>

</body>
</html>