@extends('layouts.app')

@section('content')
    <div class="p-3 bg-white">
        <div class="d-flex flex-column flex-md-row align-md-items-center justify-content-md-between">
            <div>
                <h2 class="h4 mb-2 font-weight-bold">
                    {{ $researchForm->title }}
                </h2>
                <p class="text-muted mb-1">
                    Leader: {{ $student->user->full_name }}
                </p>
                <p class="text-muted mb-1">
                    <span>Status:</span>
                    @if (isset($submission))
                        @switch ($submission->status)
                            @case ('pending')
                                <span class="text-warning">Pending</span>
                            @break

                            @case ('approved')
                                <span class="text-success">Approved</span>
                            @break

                            @case ('rejected')
                                <span class="text-danger">Rejected</span>
                            @break
                        @endswitch
                    @else
                        <span class="text-danger">Missing</span>
                    @endif
                </p>
                <p class="text-muted mb-4">
                    Adviser: {{ $student->adviser }}
                </p>
                @isset($submission->remark)
                    <h2 class="h6 mb-0 font-weight-bold">Remarks:</h2>
                    <p class="mb-2">
                        {{ $submission->remark }}
                    </p>
                @endisset
            </div>

            @if (isset($submission) && Auth::user()->hasRole('admin'))
                <form action="{{ route('submissions.change-status', $submission->id) }}" method="post">
                    @csrf

                    <label for="status">Status</label>
                    <select name="status" id="status" class="custom-select">
                        <option value="" selected>Select option</option>
                        <option value="approved" {{ $submission->status !== 'approved' ?: 'selected' }}>
                            Approve
                        </option>

                        <option value="rejected" {{ $submission->status !== 'rejected' ?: 'selected' }}>
                            Reject
                        </option>
                    </select>
                    <div>
                        <button type="submit" class="btn btn-sm mt-2 btn-primary">Submit</button>
                        <button type="button" id="remark" class="btn d-none btn-sm mt-2 btn-secondary"
                            data-toggle="modal" data-target="#remark-modal">Add
                            remark</button>

                        <div class="modal fade" id="remark-modal" tabindex="-1" aria-labelledby="remark-modalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="remark-modalLabel">Submission Remark</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <textarea name="remark" id="remark" cols="30" rows="10" class="form-control"></textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-sm btn-secondary"
                                            data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Save
                                            changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            @endif
        </div>

        @if (isset($submission))
            <a href="{{ $uri }}" class="btn mt-3 btn-primary">
                Download Document
            </a>
            <iframe src="{{ $uri }}" width="100%" height="600" class="mt-2"></iframe>
        @else
            <p>This student has not yet made any submissions.</p>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            if ($("#status").val() === "rejected") {
                $("#remark").toggleClass("d-none");
            }

            $("#status").on("change", function() {
                if ($(this).val() === "rejected") {
                    $("#remark").removeClass("d-none");
                } else {
                    $("#remark").addClass("d-none");
                }
            });
        });
    </script>
@endpush
