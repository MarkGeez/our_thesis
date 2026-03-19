<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports</title>
    <style>
        :root {
            --navy: #0a3a8a;
            --header-blue: #4a7ebb;
            --text: #111;
            --muted: #666;
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
            padding: 10mm;
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

        .header-logo {
            width: 50px;   /* smaller logo */
            height: auto;  /* keep aspect ratio */
        }

        .header-text {
            flex-grow: 1;
        }

        .republic {
            font-size: 12px;
            margin-bottom: 2px;
        }

        .office-title {
            font-size: 14px;
            font-family: 'Goudy Text MT', 'Old English Text MT', serif;
            font-weight: bold;
            margin: 0;
        }

        .address-line {
            font-size: 9px;
            margin-top: 2px;
        }

        .cert-title {
            text-align: center;
            font-size: 18px;
            font-weight: normal;
            color: var(--header-blue);
            letter-spacing: 4px;
            margin: 20px 0;
            text-transform: uppercase;
        }

        .content-body {
            font-size: 18px;
            line-height: 1.8;
            text-align: justify;
            min-height: 400px; /* Space for report data */
        }

        /* Signature Section */
        .signature-section {
            margin-top: 50px;
            float: right;
            text-align: center;
            width: 300px;
        }

        .chairman-name {
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 0;
            border-bottom: 1px solid #000;
            display: inline-block;
            padding: 0 20px;
        }

        .chairman-title {
            font-size: 16px;
            margin-top: 5px;
        }

        /* --- FOOTER STYLES --- */
        .footer {
            position: absolute;
            bottom: 15mm;
            left: 10mm;
            right: 10mm;
            border-top: 1px solid #ddd;
            padding-top: 6px;
            color: var(--muted);
            font-family: Arial, sans-serif;
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 10px;
            font-size: 9px;
        }

        .footer-column {
            flex: 1;
            min-width: 0;
        }

        .footer-contact {
            max-width: 30%;
        }

        .footer-barangay {
            text-align: right;
        }

        .footer-label {
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 8px;
            color: var(--navy);
            font-weight: bold;
            margin-bottom: 2px;
        }

        .footer-text {
            line-height: 1.3;
        }

        .footer-meta {
            margin-top: 4px;
            display: flex;
            flex-direction: column;
            gap: 2px;
            font-size: 8px;
            color: var(--muted);
        }

        .confidential-notice {
            text-align: center;
            font-size: 8px;
            margin-top: 4px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        /* ------------------------- */

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

    <div class="cert-title">Reports</div>

    <div class="content-body">
        <!-- Your report content goes here -->
    </div>

    <!--
    <div class="signature-section">
        <div class="chairman-name">Rolando O. Del Rosario</div>
        <div class="chairman-title">Barangay Chairman</div>
    </div>
    -->

    <footer class="footer">
        <div class="footer-content">
            <div class="footer-column footer-contact">
                <div class="footer-label">Address</div>
                <div class="footer-text">
                    {{ \App\Models\Setting::get('contact_address', 'JX8H+H57, Yakal St, Tondo, Manila') }}
                </div>
            </div>

            <div class="footer-column footer-contact">
                <div class="footer-label">Contact</div>
                <div class="footer-text">
                {{ \App\Models\Setting::get('contact_number', '09170000000') }} ·
                    {{ \App\Models\Setting::get('contact_email', 'brgy249@email.com') }}
                </div>
            </div>

            <div class="footer-column footer-barangay">
                <div class="footer-label">Barangay Details</div>
                <div class="footer-text">Barangay 249, Zone 23, District II</div>
                <div class="footer-text">City of Manila</div>
                <div class="footer-meta">
                    <span>Date Printed: <span id="print-date"></span></span>
                    <span>Page 1 of 1</span>
                </div>
            </div>
        </div>

        <div class="confidential-notice">
            This document is for official use only. Unauthorized reproduction is strictly prohibited.
        </div>
    </footer>
</div>

<script>
    const now = new Date();
    document.getElementById('print-date').innerText = now.toLocaleString();
</script>

</body>
</html>
