<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Encode Resident</title>
</head>
<body>
    <h1>Resident List</h1>
    @foreach ($residents as $resident)
        {{ $resident->firstName }}
    @endforeach

    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route($user->role . '.encode.residents') }}" method="post">
            @csrf

            <div class="form-group">
                <label for="firstName">First Name</label>
                <input type="text" id="firstName" name="firstName" class="form-control @error('firstName') is-invalid @enderror" value="{{ old('firstName') }}" required>
                @error('firstName')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="middleName">Middle Name</label>
                <input type="text" id="middleName" name="middleName" class="form-control @error('middleName') is-invalid @enderror" value="{{ old('middleName') }}" required>
                @error('middleName')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="lastName">Last Name</label>
                <input type="text" id="lastName" name="lastName" class="form-control @error('lastName') is-invalid @enderror" value="{{ old('lastName') }}" required>
                @error('lastName')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="houseNo">House No.</label>
                <input type="text" id="houseNo" name="houseNo" class="form-control @error('houseNo') is-invalid @enderror" value="{{ old('houseNo') }}" required>
                @error('houseNo')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="street">Street</label>
                <input type="text" id="street" name="street" class="form-control @error('street') is-invalid @enderror" value="{{ old('street') }}" required>
                @error('street')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="contactNo">Contact No.</label>
                <input type="text" id="contactNo" name="contactNo" class="form-control @error('contactNo') is-invalid @enderror" value="{{ old('contactNo') }}" required>
                @error('contactNo')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="birthday">Birthday</label>
                <input type="date" id="birthday" name="birthday" class="form-control @error('birthday') is-invalid @enderror" value="{{ old('birthday') }}" required>
                @error('birthday')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="age">Age</label>
                <input type="number" id="age" name="age" class="form-control @error('age') is-invalid @enderror" value="{{ old('age') }}" min="0" max="255" required>
                @error('age')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="sex">Sex</label>
                <select id="sex" name="sex" class="form-control @error('sex') is-invalid @enderror" required>
                    <option value="">Select Sex</option>
                    <option value="male" {{ old('sex') === 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ old('sex') === 'female' ? 'selected' : '' }}>Female</option>
                </select>
                @error('sex')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="emergencyContactNo">Emergency Contact No.</label>
                <input type="text" id="emergencyContactNo" name="emergencyContactNo" class="form-control @error('emergencyContactNo') is-invalid @enderror" value="{{ old('emergencyContactNo') }}" required>
                @error('emergencyContactNo')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="emergencyContactName">Emergency Contact Name</label>
                <input type="text" id="emergencyContactName" name="emergencyContactName" class="form-control @error('emergencyContactName') is-invalid @enderror" value="{{ old('emergencyContactName') }}" required>
                @error('emergencyContactName')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="parent">Parent</label>
                <select id="parent" name="parent" class="form-control @error('parent') is-invalid @enderror" required>
                    <option value="">Select Option</option>
                    <option value="yes" {{ old('parent') === 'yes' ? 'selected' : '' }}>Yes</option>
                    <option value="no" {{ old('parent') === 'no' ? 'selected' : '' }}>No</option>
                    <option value="single" {{ old('parent') === 'single' ? 'selected' : '' }}>Single</option>
                </select>
                @error('parent')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="enrolled">Enrolled</label>
                <select id="enrolled" name="enrolled" class="form-control @error('enrolled') is-invalid @enderror" required>
                    <option value="">Select Option</option>
                    <option value="yes" {{ old('enrolled') === 'yes' ? 'selected' : '' }}>Yes</option>
                    <option value="no" {{ old('enrolled') === 'no' ? 'selected' : '' }}>No</option>
                </select>
                @error('enrolled')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="educationalAttainment">Educational Attainment</label>
                <input type="text" id="educationalAttainment" name="educationalAttainment" class="form-control @error('educationalAttainment') is-invalid @enderror" value="{{ old('educationalAttainment') }}">
                @error('educationalAttainment')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="religionId">Religion</label>
                <select id="religionId" name="religionId" class="form-control @error('religionId') is-invalid @enderror" >
                    <option value="">Select Religion</option>
                </select>
                @error('religionId')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="headOfFamily">Head of Family</label>
                <select id="headOfFamily" name="headOfFamily" class="form-control @error('headOfFamily') is-invalid @enderror" required>
                    <option value="">Select Option</option>
                    <option value="yes" {{ old('headOfFamily') === 'yes' ? 'selected' : '' }}>Yes</option>
                    <option value="no" {{ old('headOfFamily') === 'no' ? 'selected' : '' }}>No</option>
                </select>
                @error('headOfFamily')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>
</html>