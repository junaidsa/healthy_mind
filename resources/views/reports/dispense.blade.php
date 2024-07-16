@extends('layouts.app');
@section('main')
    <style>
        .table-blue {
            background-color: #2E4661;
            color: #FFFFFF;
        }

        .search-container {
            height: 36;
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
 tbody, td, tfoot, th, thead, tr {
    border-color: #999;
    border-style: solid;
    border-width: 0px;
}
        .search-a {
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
        .page-title-box {
    padding-bottom: 0px;
}
    </style>
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex justify-content-between">
                        <div class="mt-6">

                        </div>

                            <div class="search-container">
                                <button class="search-a">
                                    <i class="fa fa-search" class="search-a"></i>
                                </button>
                                <input type="text" placeholder="Search..." class="search-input" id="searchInput" value="{{Request::get('keywords')}}" >
                            </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->
        <div class="card" style="border-radius: 20px">
            <div class="card-body">
                <div class="row">
                  <div class="col-9 d-flex align-items-center" style="font-size: 16px;">
                  <b class="mr-4 pb-2">Date</b>&nbsp;&nbsp; &nbsp;<span class="pl-4 pb-2"><b>14 July 2024</b></span>
                  </div>
                  <div class="col-3 text-end mb-2">
                          <a href="" class="btn btn btn-success">
                              PDF
                          </a>
                          <a href="javascript: void(0);" class="btn btn btn-success">
                              Excel
                          </a>
                          <a href="javascript: void(0);" class="btn btn btn-success">
                              Print
                          </a>
                  </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table mb-0">

                                <thead class="table-blue">
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Bill No.</th>
                                        <th>File No.</th>
                                        <th>Name</th>
                                        <th>Father's Name</th>
                                        <th>Aadhar Number</th>
                                        <th>Medicine</th>
                                        <th>Options</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tbody>
                                        <tr>
                                            <td class="text-center">1</td>
                                            <td class="text-center">AB-20</td>
                                            <td class="text-center">NPC-06</td>
                                            <td class="text-center">Alex Saif</td>
                                            <td class="text-center">Simon Rey</td>
                                            <td class="text-center">1252 2512 5232</td>
                                            <td class="text-center">5</td>
                                            <td class="text-center"><a href="" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0">View Details</a></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">2</td>
                                            <td class="text-center">AB-19</td>
                                            <td class="text-center">NPC-06</td>
                                            <td class="text-center">Alex Saif</td>
                                            <td class="text-center">Simon Rey</td>
                                            <td class="text-center">1252 2512 5232</td>
                                            <td class="text-center">5</td>
                                            <td class="text-center"><a class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0">View Details</a></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">3</td>
                                            <td class="text-center">AB-18</td>
                                            <td class="text-center">NPC-06</td>
                                            <td class="text-center">Alex Saif</td>
                                            <td class="text-center">Simon Rey</td>
                                            <td class="text-center">1252 2512 5232</td>
                                            <td class="text-center">5</td>
                                            <td class="text-center"><a class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0">View Details</a></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">4</td>
                                            <td class="text-center">AB-17</td>
                                            <td class="text-center">NPC-06</td>
                                            <td class="text-center">Alex Saif</td>
                                            <td class="text-center">Simon Rey</td>
                                            <td class="text-center">1252 2512 5232</td>
                                            <td class="text-center">5</td>
                                            <td class="text-center"><a class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0">View Details</a></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">5</td>
                                            <td class="text-center">AB-16</td>
                                            <td class="text-center">NPC-06</td>
                                            <td class="text-center">Alex Saif</td>
                                            <td class="text-center">Simon Rey</td>
                                            <td class="text-center">1252 2512 5232</td>
                                            <td class="text-center">5</td>
                                            <td class="text-center"><a class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0">View Details</a></td>
                                        </tr>
                                        <tr class="batch-info">
                                            <td class="text-center" colspan="8" class="text-center"><b>Paracetamol Batch Changed: 106505</b></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">6</td>
                                            <td class="text-center">AB-15</td>
                                            <td class="text-center">NPC-06</td>
                                            <td class="text-center">Alex Saif</td>
                                            <td class="text-center">Simon Rey</td>
                                            <td class="text-center">1252 2512 5232</td>
                                            <td class="text-center">5</td>
                                            <td class="text-center"><a class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0">View Details</a></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">7</td>
                                            <td class="text-center">AB-14</td>
                                            <td class="text-center">NPC-06</td>
                                            <td class="text-center">Alex Saif</td>
                                            <td class="text-center">Simon Rey</td>
                                            <td class="text-center">1252 2512 5232</td>
                                            <td class="text-center">5</td>
                                            <td class="text-center"><a class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0">View Details</a></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">8</td>
                                            <td class="text-center">AB-13</td>
                                            <td class="text-center">NPC-06</td>
                                            <td class="text-center">Alex Saif</td>
                                            <td class="text-center">Simon Rey</td>
                                            <td class="text-center">1252 2512 5232</td>
                                            <td class="text-center">5</td>
                                            <td class="text-center"><a class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0">View Details</a></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">9</td>
                                            <td class="text-center">AB-12</td>
                                            <td class="text-center">NPC-06</td>
                                            <td class="text-center">Alex Saif</td>
                                            <td class="text-center">Simon Rey</td>
                                            <td class="text-center">1252 2512 5232</td>
                                            <td class="text-center">5</td>
                                            <td class="text-center"><a href="" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0">View Details</a></td>
                                        </tr>
                                </tbody>

                            </table>
                            {{-- {{ $patients->links('pagination::bootstrap-5') }} --}}
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end row -->
            </div>
        </div>

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
