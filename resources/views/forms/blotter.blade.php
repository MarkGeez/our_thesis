<form method="POST" action="{{ route('admin.blotter.store') }}" enctype="multipart/form-data">
    @csrf
  


<h4>Plaintiff Information</h4>
<input name="plaintiffName" placeholder="First Name" required>
<input name="plaintiffMiddleName" placeholder="Middle Name">
<input name="plaintiffLastName" placeholder="Last Name" required>
<input type="number" name="plaintiffAge" placeholder="Age">
<input name="plaintiffAddress" placeholder="Address">
<input name="plaintiffContactNumber" placeholder="Contact Number">

<h4>Defendant Information</h4>
<input name="defendantName" placeholder="First Name">
<input name="defendantMiddleName" placeholder="Middle Name">
<input name="defendantLastName" placeholder="Last Name">
<input type="number" name="defendantAge" placeholder="Age">
<input name="defendantAddress" placeholder="Address">
<input name="defendantContactNumber" placeholder="Contact Number">

<h4>Witness Information</h4>
<input name="witnessName" placeholder="Witness Name">
<input name="witnessContactNumber" placeholder="Contact Number">

<h4>Incident Details</h4>
<textarea name="blotterDescription" placeholder="Incident Description" required></textarea>

<h4>Evidence</h4>
<input type="file" name="proof">

<h4>Schedule</h4>
<input type="date" name="schedule">

<button type="submit">Record Blotter</button>
</form>
