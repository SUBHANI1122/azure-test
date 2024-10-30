@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row pb-2">
        <div class="col-md-12 px-0">
            <div class="card border-0 rounded-0">
                <div class="card-header bg-success text-white rounded-0 py-3 d-flex justify-content-between">
                    {{ __('Labs') }}
                    <button type="button" id="newMedicineBtn" class="btn btn-light btn-sm">
                        Add New Lab
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center px-5 py-5">
        <div class="table-responsive">
            <table class="table table-bordered" id="labs-table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Lab Name</th>
                        <th scope="col">Added By</th>
                        <th scope="col">Created At</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- DataTable will populate this section -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal for adding/editing medicines -->
<div class="modal fade" id="labModal" tabindex="-1" aria-labelledby="labModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="labModalTitle">Add New Lab</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="labForm">
                    <input type="hidden" id="labId" name="lab_id">

                    <!-- Medicine Name and Size Fields -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="name" class="form-label fw-semibold">Lab Name</label>
                            <input type="text" class="form-control" id="name" name="name" required placeholder="Enter lab name" required>
                        </div>
                    </div>
                    <!-- Save Button -->
                    <div class="d-flex justify-content-center">
                        <button type="button" id="saveMedicine" class="btn btn-primary btn-lg px-5">Save Lab</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Initialize DataTable
        var table = $('#labs-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('labs.fetch') }}",
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: null,
                    name: 'name',
                    render: function(data, type, row) {
                        return `${data.name}`;
                    }
                },
                {
                    data: 'user.name', // If using Eloquent's relationship
                    name: 'user.name',
                    render: function(data, type, row) {
                        return data ? data : 'N/A'; // Displays user name or 'N/A' if null
                    }
                },
                {
                    data: null,
                    name: 'created_at',
                    render: function(data, type, row) {
                        return `${data.created_at}`;
                    }
                },
                {
                    data: 'id',
                    render: function(data, type, row) {
                        return `
                            <button class="btn btn-info btn-sm editMedicine" data-id="${data}" data-name="${row.name}">Edit</button>
                            <button class="btn btn-danger btn-sm deleteLab" data-id="${data}">Delete</button>
                        `;
                    },
                    orderable: false,
                    searchable: false
                }
            ]
        });

        // Show modal for adding new medicine
        $('#newMedicineBtn').on('click', function() {
            $('#labModal').modal('show');
            $('#labModalTitle').text('Add New Lab');
            $('#labForm')[0].reset();
            $('#labId').val('');
        });

        // Edit medicine button click
        $(document).on('click', '.editMedicine', function() {
            $('#labModal').modal('show');
            $('#labModalTitle').text('Edit Medicine');
            $('#labId').val($(this).data('id'));
            $('#name').val($(this).data('name'));
        });

        // Save or update medicine via AJAX
        $('#saveMedicine').on('click', function() {
            const formData = {
                id: $('#labId').val(),
                name: $('#name').val(),
                _token: "{{ csrf_token() }}"
            };

            const url = formData.id ? `/labs/${formData.id}` : "{{ route('labs.store') }}";
            const method = formData.id ? 'PUT' : 'POST';

            $.ajax({
                url: url,
                method: method,
                data: formData,
                success: function(response) {
                    if (response.success) {
                        $('#labModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: `Lab`,
                            text: `Lab Added Succefully !.`,
                            customClass: {
                                confirmButton: 'btn btn-success'
                            }
                        });
                        table.ajax.reload();
                        $('#labForm')[0].reset();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: `Lab`,
                            text: `Failed to save lab !.`,
                            customClass: {
                                confirmButton: 'btn btn-success'
                            }
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: `Lab`,
                        text: `An error occurred. Please try again..`,
                        customClass: {
                            confirmButton: 'btn btn-success'
                        }
                    });
                }
            });
        });

        // Delete medicine
        $(document).on('click', '.deleteLab', function() {
            const id = $(this).data('id');

            if (confirm('Are you sure you want to delete this lab?')) {
                $.ajax({
                    url: `/labs/${id}`,
                    method: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: `Lab`,
                                text: `Lab Deleted.`,
                                customClass: {
                                    confirmButton: 'btn btn-success'
                                }
                            });
                            table.ajax.reload();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: `Lab`,
                                text: `An error occurred. Please try again..`,
                                customClass: {
                                    confirmButton: 'btn btn-success'
                                }
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: `Lab`,
                            text: `An error occurred. Please try again..`,
                            customClass: {
                                confirmButton: 'btn btn-success'
                            }
                        });
                    }
                });
            }
        });
    });
</script>
@endsection