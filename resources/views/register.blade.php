<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Research Forms</title>

    <link rel="stylesheet" href="{{ asset('css/app.min.css') }}">

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        html,
        body {
            height: 100%;
        }

        body {
            display: flex;
            align-items: center;
            background-image: url('/smcc-campus.webp');
            background-size: cover;
            background-position: center;
        }

        .form-register {
            margin: auto;
            width: 100%;
            max-width: 48rem;
        }
    </style>
</head>

<body>
    <form action="{{ route('register') }}" method="post" class="form-register p-3 shadow bg-white">
        @csrf

        <div class="mb-3 text-center">
            <img src="{{ asset('application-logo.webp') }}" alt="Saint Michael College of Caraga" height="64"
                width="64" />
            <h1 class="h4 ml-2 mb-0 d-inline-block font-weight-bold ">Research Forms Submission</h1>
        </div>

        <div class="row my-3">
            <div class="col-12 col-md-4 mb-3 mb-md-0">
                <label for="first_name">First Name</label>
                <input type="text" name="first_name" id="first_name"
                    class="form-control @error('first_name') is-invalid @enderror" autofocus required />

                @error('first_name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-12 col-md-4 mb-3 mb-md-0">
                <label for="middle_name">Middle Name</label>
                <input type="text" name="middle_name" id="middle_name"
                    class="form-control @error('middle_name') is-invalid @enderror" />

                @error('middle_name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-12 col-md-4">
                <label for="last_name">Last Name</label>
                <input type="text" name="last_name" id="last_name"
                    class="form-control @error('last_name') is-invalid @enderror" required />

                @error('last_name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12 col-md-4">
                <label for="student_id">Student ID</label>
                <input type="text" name="student_id" id="student_id"
                    class="form-control @error('student_id') is-invalid @enderror" required />

                @error('student_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-12 col-md-4">
                <label for="adviser">Adviser</label>
                <input type="text" name="adviser" id="adviser"
                    class="form-control @error('adviser') is-invalid @enderror" required>

                @error('adviser')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-12 col-md-4">
                <label for="control_number">Control Number</label>
                <input type="text" name="control_number" id="control_number"
                    class="form-control @error('control_number') is-invalid @enderror" required>

                @error('control_number')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <div x-data="{ department: null, courses: [] }" class="row mb-3">
            <div class="col-12 col-md-4 mb-3 mb-md-0">
                <label for="department">Department</label>
                <select name="department" id="department" class="custom-select" x-model="department"
                    x-on:change="updateCourses">
                    <option value="" selected>Select option</option>
                    @foreach ($departments as $department)
                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                    @endforeach
                </select>

                @error('department')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-12 col-md-4 mb-3 mb-md-0">
                <label for="course">Course / Strand</label>
                <select name="course" id="course" class="custom-select">
                    <option value="" selected>Select option</option>
                    <template x-for="course in courses" :key="course.id">
                        <option x-text="course.name" x-bind:value="course.id"></option>
                    </template>
                </select>

                @error('course')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-12 col-md-4">
                <label for="year_level">Year Level</label>
                <select name="year_level" id="year_level"
                    class="custom-select @error('year_level') is-invalid @enderror">
                    <option selected>Select option</option>
                    @foreach (\App\Enums\YearLevel::cases() as $year_level)
                        <option value="{{ $year_level }}">{{ $year_level }}</option>
                    @endforeach
                </select>

                @error('year_level')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12 col-md-6">
                <label for="school_year">School Year</label>
                <select name="school_year" id="school_year" class="custom-select">
                    <option value="">Choose school year</option>
                    <?php
                    $current_year = date('Y');
                    for ($i = 2018; $i <= $current_year; $i++) {
                        $next_year = $i + 1;
                        $school_year = $i . ' - ' . $next_year;
                        echo '<option value="' . $school_year . '">' . $school_year . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="col-12 col-md-6">
                <label for="semester">Semester</label>
                <select name="semester" id="semester" class="custom-select">
                    <option value="">Choose semester</option>
                    <option value="1st semester">1st semester</option>
                    <option value="2nd semester">2nd semester</option>
                </select>
            </div>
        </div>


        <div class="row mb-3">
            <div class="col-12 col-md-4">
                <label for="members">Members</label>
                <input type="text" name="members" id="members" class="form-control" required />
            </div>

            <div class="col-12 col-md-4">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" required />
            </div>

            <div class="col-12 col-md-4">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                    required />
            </div>
        </div>

        <div class="d-flex align-items-center justify-content-between">
            <span class="small text-secondary">
                Already have an account? <a href="{{ route('welcome') }}">Login here</a>
            </span>

            <button type="submit" class="btn ml-2 px-4 btn-primary">
                Register
            </button>
        </div>
    </form>

    <script>
        function updateCourses() {
            var departmentId = this.department;
            if (departmentId < 0) return;

            fetch(`/api/departments/${departmentId}/courses`)
                .then(response => response.json())
                .then(data => {
                    this.courses = data;
                });
        }
    </script>
</body>

</html>
