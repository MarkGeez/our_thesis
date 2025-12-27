


<input type="text" name="plaintiffName"
    class="form-control border border-light @error('plaintiffName') is-invalid @enderror"
    value="{{ auth()->user()->firstName }}">

@error('plaintiffName')
    <div class="invalid-feedback">{{ $message }}</div>
@enderror


<input type="text" name="plaintiffLastName"
    class="form-control border border-light @error('plaintiffLastName') is-invalid @enderror"
    value="{{ auth()->user()->lastName }}">

    @error('plaintiffLastName')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    <input type="text" name="plaintiffMiddleName"
    class="form-control border border-light"
    value="{{ auth()->user()->middleName }}">

     @error('plaintiffMiddleName')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

<input type="text" name="plaintiffAddress"
    class="form-control border border-light @error('plaintiffAddress') is-invalid @enderror"
    value="{{ auth()->user()->address }}">

     @error('plaintiffAddress')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

<input type="text" name="plaintiffContactNumber"
    class="form-control border border-light @error('plaintiffContactNumber') is-invalid @enderror"
    value="{{ auth()->user()->contactNumber }}">

      @error('plaintiffContactNumber')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
<input type="text" name="plaintiffAge"
    class="form-control border border-light @error('plaintiffAge') is-invalid @enderror"
    value="{{ auth()->user()->age }}">

     @error('plaintiffAge')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
