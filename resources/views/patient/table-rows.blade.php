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
                                        <tbody id="patientTableBody">
                                            @foreach ($patients as $patient)
                                            <tr>
                                                    <td>{{ $patient->id }}</td>
                                                    <td>{{ $patient->file_no }}</td>
                                                    <td>
                                                        @if ($patient->Image)
                                                            <img src="{{ asset('public/media/photos') . '/' . $patient->Image }}"
                                                                 alt="{{ $patient->name }}'s photo" width="50" height="50"
                                                                 class="rounded photo-thumbnail" data-toggle="modal" data-target="#imageModal"
                                                                 onclick="showImageModal('{{ asset('public/media/photos') . '/' . $patient->Image }}')">
                                                        @else
                                                            <img src="{{ asset('public/media/photos') . '/'.'no-photo.png' }}"
                                                                 alt="{{ $patient->name }}'s photo" width="50" height="50"
                                                                 class="rounded photo-thumbnail" data-toggle="modal" data-target="#imageModal"
                                                                 onclick="showImageModal('{{ asset('public/media/photos') . '/' . 'no-photo.png' }}')">
                                                        @endif
                                                    </td>
                                                    <td>{{ $patient->first_name }}</td>
                                                    <td>{{ $patient->father_name }}</td>
                                                    <td>{{ $patient->date_of_birth }}</td>
                                                    <td>{{ $patient->alternative_no }}</td>
                                                    <td>{{ $patient->mobile_no }}</td>
                                                     <td>{{
                                                        $totalbills = DB::table('patient_bills')
                                                        ->where('patient_id', $patient->id)
                                                        ->count();
                                                        }}</td>
                                                    <td>
                                                        <a href="{{ url('patients') . '/' . $patient->id}}" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0">View Details</a>
                                                        <a href="{{ url('add-bill') . '/'.$patient->id }}" class="btn btn-success btn-sm btn-rounded waves-effect waves-light mb-2 mb-md-0">Add Bill</a>
                                                    </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                </table>
                                {{ $patients->links('pagination::bootstrap-5') }}
                            </div>
