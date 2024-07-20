<!-- resources/views/bills/form.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Bill Form</title>
</head>
<body>
    <form action="{{ isset($bill) ? route('bills.update', $bill->id) : route('bills.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($bill))
            @method('PUT')
        @endif

        <div>
            <label for="page_no">Page No:</label>
            <input type="number" name="page_no" id="page_no" value="{{ old('page_no', $bill->page_no ?? '') }}" required>
        </div>

        <div>
            <label for="bill_no">Bill No:</label>
            <input type="text" name="bill_no" id="bill_no" value="{{ old('bill_no', $bill->bill_no ?? '') }}" required>
        </div>

        <div>
            <label for="bill_date">Bill Date:</label>
            <input type="date" name="bill_date" id="bill_date" value="{{ old('bill_date', $bill->bill_date ?? '') }}" required>
        </div>

        <div>
            <label for="patient_id">Patient ID:</label>
            <input type="number" name="patient_id" id="patient_id" value="{{ old('patient_id', $bill->patient_id ?? '') }}" required>
        </div>

        <div>
            <label for="note">Note:</label>
            <textarea name="note" id="note">{{ old('note', $bill->note ?? '') }}</textarea>
        </div>

        <div>
            <label for="totalPrice">Total Price:</label>
            <input type="number" step="0.01" name="totalPrice" id="totalPrice" value="{{ old('totalPrice', $bill->total_amount ?? '') }}" required>
        </div>

        <div>
            <label for="bill_image">Bill Image:</label>
            <input type="file" name="bill_image" id="bill_image" {{ isset($bill) ? '' : 'required' }}>
        </div>

        <button type="submit">{{ isset($bill) ? 'Update Bill' : 'Create Bill' }}</button>
    </form>
</body>
</html>
