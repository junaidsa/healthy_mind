@extends('layouts.app');
@section('title', 'Patients')
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
        td{
            border-bottom: 2px solid;
        }
    </style>
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex justify-content-between">
                        <div class="mt-6">
                            <a href="{{ url('/patients/create') }}" class="btn btn-primary btn-font px-3">Add Patient</a>
                            &nbsp;&nbsp;&nbsp;
                            <a href="{{ url('add-bill') }}" class="btn btn-success btn-font">Add Bill</a>
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
                                <input type="text" placeholder="Search..." class="search-input" id="search-input">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table mb-0" id="patients-table">

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

                            </tbody>
                        </table>
      <nav aria-label="Page navigation" class="mt-2 text-end">
    <ul class="pagination" id="pagination-links" style="
    float: right;
    text-align: right !imprtant;
">
      </ul>
    </nav>
                    </div>
                </div>


            </div>

        </div>
    </div>
    <div class="modal fade" id="modalImg" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="imageModalLabel">Image</h5>
            </div>
            <div class="modal-body">
              <img id="modalImage" src="" alt="Patient Image" class="img-fluid">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary close-model" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
    @endsection
    @section('customJs')
    <script>
    $(document).ready(function() {
    function fetchPatients(page = 1, search = '') {
        $.ajax({
            url: '{{ route("patients.getPatients") }}',
            method: 'GET',
            data: {
                page: page,
                search: search
            },
            success: function(response) {
                let output = '';
                $.each(response.data, function(index, patient) {
                    output += '<tr>';
                    output += '<td>' + patient.id + '</td>';
                    output += '<td>' + patient.file_no + '</td>';
                    output += '<td>';
                    if (patient.Image) {
                        output += '<img src="{{ asset('public/media/photos') }}/' + patient.Image + '" alt="' + patient.name + '\'s photo" width="50" height="50" class="rounded photo-thumbnail photoClick" data="{{ asset('public/media/photos') }}/' + patient.Image + '">';
                    } else {
                        output += '<img src="{{ asset('public/media/photos/no-photo.png') }}" alt="' + patient.name + '\'s photo" width="50" height="50" class="rounded photo-thumbnail photoClick" data""">';
                    }
                    output += '</td>';
                    output += '<td>' + patient.first_name + '</td>';
                    output += '<td>' + patient.father_name + '</td>';
                    output += '<td>' + patient.date_of_birth + '</td>';
                    output += '<td>' + patient.uid_number + '</td>';
                    output += '<td>' + patient.mobile_no + '</td>';
                    output += '<td>' + patient.totalbills + '</td>';
                    output += '<td>';
                    output += '<a href="{{ url('patients') }}/' + patient.id + '" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0">View Details</a>';
                    output += '<a href="{{ url('add-bill') }}/' + patient.id + '" class="btn btn-success btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0">Add Bill</a>';
                    output += '</td>';
                    output += '</tr>';
                });
                $('#patients-table tbody').html(output);
                // Update pagination links
                let paginationLinks = '';
                $.each(response.links, function(index, link) {
                    if (link.url) {
                    paginationLinks += '<li class="page-item"><a href="' + link.url + '" class="page-link" data-page="' + link.label + '">' + link.label + '</a></li> ';
                } else {
                    paginationLinks += '<li class="page-item disabled"><span class="page-link">' + link.label + '</span></li> ';
                }
                });
                $('#pagination-links').html(paginationLinks);
            },
            error: function(error) {
                console.log(error);
            }
        });
    }
        fetchPatients();

        $(document).on('keyup','.search-input', function() {
    let search = $(this).val();
    fetchPatients(1, search);
});
    $(document).on('click', '.page-link', function(e) {
        e.preventDefault();
        let page = $(this).data('page');
        let search = $('#search-input').val();
        fetchPatients(page, search);
    });
        $(document).on('click','.photoClick',function(){
            var data=$(this).attr('data');
            $('#modalImage').attr('src',data);
            $('#modalImg').modal('show')
        })
        $(document).on('click','.close-model',function(){
            $('#modalImg').modal('hide')
        })
    });
</script>

    </script>
@endsection
