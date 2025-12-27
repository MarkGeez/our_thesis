<input type="hidden" name="plaintiffName" value="{{ auth()->user()->firstName ?? auth()->user()->name }}">
<input type="hidden" name="plaintiffLastName" value="{{ auth()->user()->lastName ?? '' }}">
<input type="hidden" name="plaintiffMiddleName" value="{{ auth()->user()->middleName ?? '' }}">
<input type="hidden" name="plaintiffAddress" value="{{ auth()->user()->address ?? '' }}">
<input type="hidden" name="plaintiffContactNumber" value="{{ auth()->user()->contactNumber ?? '' }}">
<input type="hidden" name="plaintiffAge" value="{{ auth()->user()->age ?? '' }}">