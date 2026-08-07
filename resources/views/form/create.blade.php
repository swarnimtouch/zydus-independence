<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Details Form</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <div class="form-wrapper">
        <h1>Fill Your Details</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="detailsForm" action="{{ route('form.store') }}" method="POST" novalidate>
            @csrf

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Enter your name">
                <span class="error-text" id="nameError"></span>
            </div>

            <div class="form-group">
                <label for="city">City</label>
                <input type="text" id="city" name="city" value="{{ old('city') }}" placeholder="Enter your city">
                <span class="error-text" id="cityError"></span>
            </div>

            <div class="form-group">
                <label for="speciality">Speciality</label>
                <input type="text" id="speciality" name="speciality" value="{{ old('speciality') }}" placeholder="Enter your speciality">
                <span class="error-text" id="specialityError"></span>
            </div>

            <button type="submit" class="btn-submit">Submit</button>
        </form>
    </div>

    <script src="{{ asset('js/style.js') }}"></script>
</body>
</html>
