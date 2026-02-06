<form action="" method="POST" target="_blank" id="certEditForm">
        <h3>Resident Information</h3>
        
        

        <div style="margin-bottom: 10px;">
            <label for="address">Postal Address:</label><br>
            <input type="text" id="address" name="address" placeholder="Enter Address" style="width: 100%; max-width: 400px;" required>
        </div>

        <hr>

        <h3>Purpose of Indigency</h3>
        <p><small>Select the reason for this certification:</small></p>

        <div style="margin-bottom: 5px;">
            <input type="checkbox" name="request_data[medical]" id="indigency_medical" value="1">
            <label for="indigency_medical">MEDICAL ASSISTANCE</label>
        </div>

        <div style="margin-bottom: 5px;">
            <input type="checkbox" name="request_data[educational]" id="indigency_educational" value="1">
            <label for="indigency_educational">EDUCATIONAL ASSISTANCE</label>
        </div>

        <div style="margin-bottom: 5px;">
            <input type="checkbox" name="request_data[burial]" id="indigency_burial" value="1">
            <label for="indigency_burial">BURIAL ASSISTANCE</label>
        </div>

        <div style="margin-bottom: 5px;">
            <input type="checkbox" name="request_data[financial]" id="indigency_financial" value="1">
            <label for="indigency_financial">FINANCIAL ASSISTANCE</label>
        </div>

        <div style="margin-bottom: 5px;">
            <input type="checkbox" name="request_data[others]" id="indigency_others" value="1" onchange="toggleOthers(this)">
            <label for="indigency_others">OTHERS</label>
            
            <input type="text" 
                   id="others_input" 
                   name="request_data[others_specify]" 
                   placeholder="Please specify..." 
                   style="display: none; margin-left: 10px;">
        </div>

        <hr>

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