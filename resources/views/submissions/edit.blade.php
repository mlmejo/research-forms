@extends('layouts.app')

@section('content')
    <div class="p-3 shadow-sm bg-white">
        <h2 class="h4 mb-4 font-weight-bold">Update Submission: {{ $researchForm->title }}</h2>

        <form action="{{ route('research-forms.submissions.update', $researchForm) }}" method="post" enctype="multipart/form-data" class="col-md-5 p-0">
            @csrf
            @method('PATCH')

            <div class="custom-file">
                <input type="file" class="custom-file-input @error('document') is-invalid @enderror" name="document"
                    id="document" aria-describedby="Upload PDF document" required>
                <label class="custom-file-label" for="document">Choose file</label>

                @error('document')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group mt-3 p-0">
                <label for="school_year">School Year</label>
                <select name="school_year" id="school_year" class="custom-select">
                    <option value="">Choose school year</option>
                    <?php
                        $current_year = date("Y");
                        for ($i = 2018; $i <= $current_year; $i++) {
                            $next_year = $i + 1;
                            $school_year = $i . " - " . $next_year;
                            echo '<option value="' . $school_year . '">' . $school_year . '</option>';
                        }
                    ?>
                </select>
            </div>

            <div class="form-group mt-3 p-0">
                <label for="semester">Semester</label>
                <select name="semester" id="semester" class="custom-select">
                    <option value="" selected>Choose semester</option>
                    <option value="1st semester">1st semester</option>
                    <option value="2nd semester">2nd semester</option>
                    <option value="Summer class">Summer class</option>
                </select>
            </div>

            <div class="mt-3 p-0">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
@endsection
