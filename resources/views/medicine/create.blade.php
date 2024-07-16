@extends('layouts.app');
@section('main')
<style>
    blockquote {
    margin: 0 0 20px;
    padding: 10px 20px;
    font-size: 17.5px;
    border-left: 5px solid #556ee6 !important;
    border: 1px solid rgba(120, 130, 140, .13);
}
.hr-boader{
    margin-bottom: 2px;
    margin-top: 0;

}
</style>
<div class="page-content">
        <div class="container-fluid">
        <div class="row">
<div class="col-lg-12">
    <div class="page-title-box d-sm-flex justify-content-between">
        <div>
            <a href="{{ url('/medicines') }}" class="btn btn-primary"><i
                    class="bx bx-arrow-back align-middle me-2"></i> Back</a>
            <h4 style="margin-bottom: -1px;" class="mt-4">Add Medicine</h4>
        </div>
    </div>
    <div class="hr-boader mb-2">
    </div>
    <div class="card">
        <div class="card-body">
            <form action="{{ url('medicines') }}" id="createForm" method="post">
                @csrf
                <div class="row mb-3">
                    <div class="col">
                        <label for="name">Medicine Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control"
                            name="name"
                            value="">
                            @error('name')
                            <div class=" invalid-feedback">{{ $message }}</div>
                                    @enderror

                        </div>
                    <div class="col">
                        <label for="rate">Rate <span class="text-danger">*</span></label>
                        <input type="text" class="form-control"
                            name="rate"
                            value="">
                            @error('rate')
                            <div class=" invalid-feedback">{{ $message }}</div>
                                    @enderror

                     </div>
                    <div class="col">
                        <label for="tax">TAX <span class="text-danger">*</span></label>
                        <input type="text" class="form-control " name="tax"
                            placeholder="Enter tax" value="">
                            @error('tax')
                            <div class=" invalid-feedback">{{ $message }}</div>
                                    @enderror
                             </div>
                </div>

                <button class="btn btn-success" type="submit">Save</button>
            </form>
        </div>
    </div>
</div>
    </div>
</div>
</div>
@endsection
{{-- @section --}}
@section('customJs')
<script>
$(document).ready(function() {
    $('#createForm').submit(function(event) {
        $(".is-invalid").removeClass('is-invalid');
        $(".invalid-feedback").html('');
        var name = $("#name").val();
        var tax = $("#tax").val();
        var rate = $("#rate").val();
        var isValid = true;
        if (name === '') {
            $("#registration_date").addClass('is-invalid').siblings('.invalid-feedback').html('name is required.');
            isValid = false;
        }

        if (tax === '') {
            $("#first_name").addClass('is-invalid').siblings('.invalid-feedback').html('tax is required.');
            isValid = false;
        }

        if (rate === '') {
            $("#rate").addClass('is-invalid').siblings('.invalid-feedback').html('rate is required.');
            isValid = false;
        }
        if (!isValid) {
            event.preventDefault();
        }
    });
});
</script>
@endsection
