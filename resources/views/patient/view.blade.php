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

                            </tbody>
                        </table>
                        <div class="pagination float-end"></div>
                        {{-- {{ $patients->links('pagination::bootstrap-5') }} --}}
                    </div>
                </div> <!-- end col -->
                <!-- Modal -->


            </div> <!-- end row -->

        </div> <!-- container-fluid -->
    </div>
    <!-- end main content-->

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


   document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');

        // Function to fetch and update patient list
        function fetchPatients(keywords = '') {
            fetch(`{{ route('search.patients') }}?keywords=${keywords}`)
                .then(response => response.json())
                .then(data => {
                    updatePatientTable(data.patients.data);
                    document.querySelector('.pagination').innerHTML = data.links;
                })
                .catch(error => console.error('Error:', error));
        }

        // Event listener for search input
        searchInput.addEventListener('keyup', function() {
            const keywords = searchInput.value;
            fetchPatients(keywords);
        });

        $(document).on('click','.photoClick',function(){
            var data=$(this).attr('data');
            $('#modalImage').attr('src',data);
            $('#modalImg').modal('show')
        })
        $(document).on('click','.close-model',function(){
            $('#modalImg').modal('hide')
        })

        // Function to update patient table
        function updatePatientTable(patients) {
            const tbody = document.querySelector('tbody');
            tbody.innerHTML = '';

            patients.forEach(patient => {
                const row = document.createElement('tr');

                row.innerHTML = `
                    <td>${patient.id}</td>
                    <td>${patient.file_no}</td>
                    <td>
                        <img src="${patient.Image ? '{{ asset('public/media/photos') }}/' + patient.Image : '{{ asset('public/media/photos/no-photo.png') }}'}"
                             alt="${patient.first_name}'s photo" width="50" height="50"
                             class="rounded photo-thumbnail photoClick"
                             data="${patient.Image ? '{{ asset('public/media/photos') }}/' + patient.Image : '{{ asset('public/media/photos/no-photo.png') }}'}">
                    </td>
                    <td>${patient.first_name}</td>
                    <td>${patient.father_name}</td>
                    <td>${patient.date_of_birth}</td>
                    <td>${patient.uid_number}</td>
                    <td>${patient.mobile_no}</td>
                    <td>${patient.total_bills}</td>
                    <td>
                        <a href="{{ url('patients') }}/${patient.id}" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0">View Details</a>
                        <a href="{{ url('add-bill') }}/${patient.id}" class="btn btn-success btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0">Add Bill</a>
                    </td>
                `;

                tbody.appendChild(row);
            });
        }

        // Fetch patients on page load
        fetchPatients();
    });
</script>

    </script>
@endsection
