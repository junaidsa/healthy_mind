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
            <h4 style="margin-bottom: -1px;" class="mt-4">Edit Medicine</h4>
        </div>
    </div>
    <div class="hr-boader mb-2">
    </div>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('medicines.update', $medicine->id) }}" method="post">
                @csrf
                <div class="row mb-3">
                    <div class="col">
                        <label for="name">Medicine Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control"
                            name="name"
                            value="{{$medicine->name }}">
                            @error('name')
                            <div class=" invalid-feedback">{{ $message }}
                                    @enderror
                        </div>
                    <div class="col">
                        <label for="rate">Rate <span class="text-danger">*</span></label>
                        <input type="text" class="form-control"
                            name="rate"
                            value="{{$medicine->rate }}">
                            @error('rate')
                            <div class=" invalid-feedback">{{ $message }}</div>
                                    @enderror

                     </div>
                    <div class="col">
                        <label for="tax">TAX <span class="text-danger">*</span></label>
                        <input type="text" class="form-control " name="tax"
                            placeholder="Enter tax" value="{{$medicine->tax }}">
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
