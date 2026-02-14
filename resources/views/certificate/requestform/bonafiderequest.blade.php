<form action="" method="POST" target="_blank" id="certEditForm">
        
        <h3>Personal Information</h3>
        <div style="margin-bottom: 10px;">
            <label for="name">Full Name:</label><br>
            <input type="text" id="name" name="name" placeholder="Enter Full Name" style="width: 100%; max-width: 400px;" required>
        </div>

        <div style="margin-bottom: 10px;">
            <label for="address">Address:</label><br>
            <input type="text" id="address" name="address" placeholder="Enter Address" style="width: 100%; max-width: 400px;" required>
        </div>

        <hr>

        <h3>Purpose / Requirements</h3>
        <p><small>Select applicable requirements:</small></p>

        <div style="margin-bottom: 5px;">
            <input type="checkbox" name="request_data[bonafide]" id="check_bonafide" value="1">
            <label for="check_bonafide">BONAFIDE RESIDENT</label>
        </div>

        <div style="margin-bottom: 5px;">
            <input type="checkbox" name="request_data[medical]" id="check_medical" value="1">
            <label for="check_medical">MEDICAL TREATMENT</label>
        </div>

        <div style="margin-bottom: 5px;">
            <input type="checkbox" name="request_data[hospital]" id="check_hospital" value="1">
            <label for="check_hospital">HOSPITALIZATION</label>
        </div>

        <div style="margin-bottom: 5px;">
            <input type="checkbox" name="request_data[postal]" id="check_postal" value="1">
            <label for="check_postal">APPLICATION FOR POSTAL ID</label>
        </div>

        <div style="margin-bottom: 5px;">
            <input type="checkbox" name="request_data[school]" id="check_school" value="1">
            <label for="check_school">SCHOOL REFERENCE</label>
        </div>

        <div style="margin-bottom: 5px;">
            <input type="checkbox" name="request_data[referral]" id="check_referral" value="1">
            <label for="check_referral">REFERRAL</label>
        </div>

        <div style="margin-bottom: 5px;">
            <input type="checkbox" name="request_data[transaction]" id="check_transaction" value="1">
            <label for="check_transaction">TRANSACTION IN BANK</label>
        </div>

        <div style="margin-bottom: 5px;">
            <input type="checkbox" name="request_data[overseas]" id="check_overseas" value="1">
            <label for="check_overseas">OVERSEAS TRAVEL PAPERS</label>
        </div>

        <div style="margin-bottom: 5px;">
            <input type="checkbox" name="request_data[Ccalamity]" id="check_Ccalamity" value="1">
            <label for="check_Ccalamity">PROCESSING FOR CALAMITY OF DISASTER AID</label>
        </div>

        <div style="margin-bottom: 5px;">
            <input type="checkbox" name="request_data[sss]" id="check_sss" value="1">
            <label for="check_sss">S.S.S. REFERENCE</label>
        </div>

        <div style="margin-bottom: 5px;">
            <input type="checkbox" name="request_data[others]" id="check_others" value="1" onchange="toggleOthers(this)">
            <label for="check_others">OTHERS</label>
            
            <input type="text" 
                   id="others_input" 
                   name="request_data[others_specify]" 
                   placeholder="Specify if others" 
                   style="display: none; margin-left: 10px;">
        </div>

      

       

        <button type="submit" style="padding: 10px 20px;">Print Certificate</button>
    </form>

    <script>
        function toggleOthers(checkbox) {
            const othersInput = document.getElementById('others_input');
            if (checkbox.checked) {
                othersInput.style.display = 'inline-block';
                othersInput.focus();
            } else {
                othersInput.style.display = 'none';
                othersInput.value = ''; 
            }
        }
    </script>