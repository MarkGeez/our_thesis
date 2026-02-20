<form action="" method="POST" target="_blank" id="certEditForm">
        
        <h3>1. Affiant Information</h3>
        <div style="margin-bottom: 10px;">
            <label>Full Name:</label><br>
            <input type="text" name="name" placeholder="Enter Full Name" style="width: 100%; max-width: 400px;" required>
        </div>

        <div style="margin-bottom: 10px;">
            <label>Age:</label><br>
            <input type="text" name="request_data[age]" placeholder="Years old" size="5">
        </div>

        <div style="margin-bottom: 10px;">
            <label>Postal Address:</label><br>
            <input type="text" name="address" placeholder="Enter Address" style="width: 100%; max-width: 400px;" required>
        </div>

        <hr>

        <h3>2. Marital & Family Status</h3>
        <div style="margin-bottom: 10px;">
            <input type="checkbox" name="request_data[married_to]" id="married_to" value="1">
            <label for="married_to">Check if Married/Unmarried to a specific person:</label>
            <br>
            <input type="text" name="request_data[spouse_name]" placeholder="Spouse/Partner Name" style="width: 100%; max-width: 300px; margin-top: 5px;">
        </div>

        <div style="margin-bottom: 10px;">
            <label>Number of Children:</label>
            <input type="text" name="request_data[num_children]" placeholder="0" size="5">
        </div>

        <h4>Children List</h4>
        <table border="0" style="width: 100%; max-width: 600px;">
            <thead>
                <tr style="text-align: left;">
                    <th>#</th>
                    <th>Name of Child</th>
                    <th>Date of Birth</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1.</td>
                    <td><input type="text" name="request_data[children][0][name]" style="width: 90%;"></td>
                    <td><input type="text" name="request_data[children][0][dob]" placeholder="MM/DD/YYYY"></td>
                </tr>
                <tr>
                    <td>2.</td>
                    <td><input type="text" name="request_data[children][1][name]" style="width: 90%;"></td>
                    <td><input type="text" name="request_data[children][1][dob]" placeholder="MM/DD/YYYY"></td>
                </tr>
                <tr>
                    <td>3.</td>
                    <td><input type="text" name="request_data[children][2][name]" style="width: 90%;"></td>
                    <td><input type="text" name="request_data[children][2][dob]" placeholder="MM/DD/YYYY"></td>
                </tr>
                <tr>
                    <td>4.</td>
                    <td><input type="text" name="request_data[children][3][name]" style="width: 90%;"></td>
                    <td><input type="text" name="request_data[children][3][dob]" placeholder="MM/DD/YYYY"></td>
                </tr>
                <tr>
                    <td>5.</td>
                    <td><input type="text" name="request_data[children][4][name]" style="width: 90%;"></td>
                    <td><input type="text" name="request_data[children][4][dob]" placeholder="MM/DD/YYYY"></td>
                </tr>
            </tbody>
        </table>

        <hr>

        <h3>3. Legal Statements</h3>
        <div style="margin-bottom: 10px;">
            <input type="checkbox" name="request_data[no_knowledge_whereabouts]" id="whereabouts" value="1">
            <label for="whereabouts">I have no knowledge of the father's whereabouts.</label>
        </div>

        <div style="margin-bottom: 10px;">
            <input type="checkbox" name="request_data[separated]" id="separated" value="1">
            <label for="separated">Check if Separated:</label><br>
            <div style="margin-left: 25px; margin-top: 5px;">
                Separated from: <input type="text" name="request_data[separated_from]" placeholder="Partner's Name"><br>
                Since: <input type="text" name="request_data[separated_since]" placeholder="Date/Year">
            </div>
        </div>

        <div style="margin-bottom: 10px;">
            <input type="checkbox" name="request_data[attest_truth]" id="attest" value="1" required>
            <label for="attest">I attest to the truth of the foregoing facts.</label>
        </div>

        <hr>

        

    </form>