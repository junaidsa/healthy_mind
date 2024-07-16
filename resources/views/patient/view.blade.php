@extends('layouts.app');
@section('main')
    <style>
        .table-blue {
            background-color: #2E4661;
            color: #FFFFFF;
        }

        .search-container {
            position: relative;
            display: flex;
            align-items: center;
            background: #fff;
            width: 220px;
            border: 1px solid #ccc;
            border-radius: 25px;
            overflow: hidden;
        }

        .search-input {
            width: 100%;
            padding: 10px -18px;
            border: none;
            font-size: 14px;
            outline: none;
            border-radius: 25px 0 0 25px;
        }

        .search-button {
            background-color: #fff;
            padding: 10px 8px;
            border: none;
            cursor: pointer;
            border-radius: 0 25px 25px 0;
            margin-left: 2px;
        }

        .btn-font {
            font-size: 1.2rem;
        }

        .mt-6 {
            margin-top: 3.5rem !important;
        }
    </style>
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex justify-content-between">
                        <div class="mt-6">
                            <a href="{{ url('/patients/create') }}" class="btn btn-primary btn-font">Add Patient</a>
                        </div>
                        <div class="page-title-right">
                            <div class="m-4 mb-2">
                                <button class="btn-sm btn btn-success">
                                    Import
                                </button>

                                <a href="javascript: void(0);" class="btn-sm btn btn-danger has-arrow waves-effect">
                                    Export
                                </a>
                            </div>
                            <div class="search-container">
                                <button class="search-button">
                                    <i class="fa fa-search" class="search-button"></i>
                                </button>
                                <input type="text" placeholder="Search..." class="search-input" id="searchInput" value="{{Request::get('keywords')}}" >
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table mb-0">

                            <thead class="table-blue">
                                <tr>
                                    <th>S.No.</th>
                                    <th>File No.</th>
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Father's Name</th>
                                    <th>Age</th>
                                    <th>Aadhar Number</th>
                                    <th>Mobile No.</th>
                                    <th>Bills</th>
                                    <th>Options</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @foreach ($patients as $patient)
                                        <td>{{ $patient->id }}</td>
                                        <td>{{ $patient->file_no }}</td>
                                        <td>
                                            @if ($patient->Image)
                                                <img src="{{ asset('public/media/photos') . '/' . $patient->Image }}"
                                                    alt="{{ $patient->name }}'s photo" width="50" height="50"
                                                    class="rounded photo-thumbnail">
                                            @else
                                                <img src="{{ asset('public/media/photos') . '/' . 'no-photo.png' }}"
                                                    alt="{{ $patient->name }}'s photo" width="50" height="50"
                                                    class="rounded photo-thumbnail">
                                            @endif
                                        </td>
                                        <td>{{ $patient->first_name }}</td>
                                        <td>{{ $patient->father_name }}</td>
                                        <td>{{ $patient->date_of_birth }}</td>
                                        <td>{{ $patient->alternative_no }}</td>
                                        <td>{{ $patient->mobile_no }}</td>
                                        <td>5</td>
                                        <td>
                                            <button
                                                    class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0"><a href="{{ url('patients') . '/' . $patient->id . '/edit' }}" style="
                                                        color: #fff;
                                                    ">View
                                                    Details</a></button>
                                            <button
                                                class="btn btn-success btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0 "><a href="{{ url('add-bill') . '/'.$patient->id }}" style="
                                                    color: #fff;
                                                ">Add
                                                Bill</a></button>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $patients->links('pagination::bootstrap-5') }}
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div> <!-- container-fluid -->
    </div>
    <!-- end main content-->
    @endsection
    @section('customJs')
    <script>
function parseQueryString(url) {
    var params = {};
    var queryString = url.split('?')[1];
    if (queryString) {
        queryString.split('&').forEach(function (pair) {
            pair = pair.split('=');
            params[pair[0]] = decodeURIComponent(pair[1] || '');
        });
    }
    return params;
}
var baseUrl = "{{ route('patients.index') }}";
var currentUrl = window.location.href;
var parsedParams = parseQueryString(currentUrl);
var url = new URL(baseUrl);
Object.keys(parsedParams).forEach(function(key) {
    url.searchParams.append(key, parsedParams[key]);
});
    const searchInput = document.getElementById('searchInput');
    searchInput.addEventListener('keypress', function(event) {
      if (event.key === 'Enter') {
        var params = url.searchParams;
         var keywords = $("#searchInput").val();
           params.set("keywords", keywords);
         if (keywords) {
} else {
  url.search = '';
}
         url.search = params.toString();
         window.location.href = url.toString();
      }
    });
    </script>
@endsection
