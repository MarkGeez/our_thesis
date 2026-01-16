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

        @page {
            size: A4;
            margin: 10mm;
        }

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

        .logo-small {
            width: 80px;
            height: auto;
        }

        .content {
            padding: 15px;
        }

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
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .checkbox-text {
            flex: 1;
            font-size: 14px;
            text-align: justify;
        }

        .children-table {
            margin: 10px 0 10px 25px;
            width: calc(100% - 25px);
        }

        .children-row {
            display: flex;
            margin: 8px 0;
        }

        .child-number {
            width: 20px;
        }

        .child-name {
            flex: 1;
            margin-right: 20px;
        }

        .child-dob {
            width: 150px;
        }

        .table-header {
            display: flex;
            margin: 10px 0 5px 25px;
            font-weight: bold;
            font-size: 13px;
        }

        .header-name {
            flex: 1;
            margin-right: 20px;
            padding-left: 20px;
        }

        .header-dob {
            width: 150px;
        }

        input[type="text"] {
            border: none;
            border-bottom: 1px solid #222;
            outline: none;
            background: transparent;
            font-family: 'Times New Roman', serif;
            font-size: 14px;
        }

        .inline-input {
            width: 300px;
        }

        .short-input {
            width: 80px;
        }

        .medium-input {
            width: 150px;
        }

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

        @media print {
            body {
                background: white;
            }
            .page {
                margin: 0;
                box-shadow: none;
            }
            .print-button {
                display: none;
            }
        }
    </style>
    <script>
        function toggleCheckbox(element) {
            if (element.textContent === '✓') {
                element.textContent = '';
            } else {
                element.textContent = '✓';
            }
        }
    </script>
</head>
<body>

<div class="page">
    <div class="header-row">
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
        <main class="right">
            <div class="cert-title">AFFIDAVIT FROM BARANGAY OF</div>
            <div class="cert-subtitle">SOLO PARENT</div>

            <p class="intro" style="line-height: 35px;">
                I, <!--papalitan nalang ng name--><input type="text" class="inline-input">, <input type="text" class="short-input"> years old, Filipino, and 
                single, and a bona fide resident of Barangay 249 Zone 23 District II Tondo, 
                Manila, after having duly sworn to in accordance with law, hereby depose and state:
            </p>

            <div class="brgylogo-arc"><img src="Brgy-logo-1.png" alt="Barangay Seal" style="width:350px; height: 350px; object-fit:contain"></div>

            <div class="checkbox-section">
                <div class="checkbox" onclick="toggleCheckbox(this)"></div>
                <div class="checkbox-text">
                    That I was married/unmarried to <input type="text" class="inline-input"> and 
                    during our relationship we begot with <input type="text" class="short-input"> child/ children named:
                    
                    <div class="table-header">
                        <div class="header-name">Name of Child/ Children</div>
                        <div class="header-dob">Date of Birth</div>
                    </div>
                    
                    <div class="children-table">
                        <div class="children-row">
                            <div class="child-number">1.</div>
                            <div class="child-name"><input type="text" style="width: 100%; border: none; border-bottom: 1px solid #000;"></div>
                            <div class="child-dob"><input type="text" style="width: 100%; border: none; border-bottom: 1px solid #000;"></div>
                        </div>
                        <div class="children-row">
                            <div class="child-number">2.</div>
                            <div class="child-name"><input type="text" style="width: 100%; border: none; border-bottom: 1px solid #000;"></div>
                            <div class="child-dob"><input type="text" style="width: 100%; border: none; border-bottom: 1px solid #000;"></div>
                        </div>
                        <div class="children-row">
                            <div class="child-number">3.</div>
                            <div class="child-name"><input type="text" style="width: 100%; border: none; border-bottom: 1px solid #000;"></div>
                            <div class="child-dob"><input type="text" style="width: 100%; border: none; border-bottom: 1px solid #000;"></div>
                        </div>
                        <div class="children-row">
                            <div class="child-number">4.</div>
                            <div class="child-name"><input type="text" style="width: 100%; border: none; border-bottom: 1px solid #000;"></div>
                            <div class="child-dob"><input type="text" style="width: 100%; border: none; border-bottom: 1px solid #000;"></div>
                        </div>
                        <div class="children-row">
                            <div class="child-number">5.</div>
                            <div class="child-name"><input type="text" style="width: 100%; border: none; border-bottom: 1px solid #000;"></div>
                            <div class="child-dob"><input type="text" style="width: 100%; border: none; border-bottom: 1px solid #000;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="checkbox-section" >
                <div class="checkbox" onclick="toggleCheckbox(this)"></div>
                <div class="checkbox-text" style="line-height: 28px;">
                    That I have no knowledge of the whereabouts of the father of my child/ children.
                </div>
            </div>

            <div class="checkbox-section">
                <div class="checkbox" onclick="toggleCheckbox(this)"></div>
                <div class="checkbox-text" style="line-height: 28px;">
                    That I had separated from <input type="text" class="medium-input"> since <input type="text" class="medium-input"> and at the 
                    present time, I have no husband/ partner and as a Solo Parent, I am 
                    taking full custody and care of my child/ children mentioned in this affidavit.
                </div>
            </div>

            <div class="checkbox-section">
                <div class="checkbox" onclick="toggleCheckbox(this)"></div>
                <div class="checkbox-text" style="line-height: 28px;">
                    That this is being executed to attest to the truth of the foregoing facts 
                    and circumstances and for whatever legal intents and purpose this instrument may serve.
                </div>
            </div>

        </main>
    </div>

    <div class="watermark-arc">
        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/8e/Barangay.svg/2048px-Barangay.svg.png" alt="Barangay Seal" style="width: 175px; height: 175px; object-fit:contain">
    </div>
</div>

<button class="print-button" onclick="window.print()" style="position:fixed;bottom:20px;right:20px;padding:10px 18px;background:#0a3a8a;color:white;border:none;border-radius:4px;font-size:14px;cursor:pointer">Print Certificate</button>

</body>
</html>