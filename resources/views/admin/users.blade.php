@extends('layouts.master')
@section('title')
    User List
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/swiper/swiper.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .swiper-slide {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .swiper-image {
            max-width: 50%;
            height: auto;
            margin-bottom: 10px;
        }

        .ribbon-two {
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 10;
            padding: 5px 10px;
            font-size: 12px;
            font-weight: bold;
            color: #fff;
        }
    </style>
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Dashboards
        @endslot
        @slot('title')
            Users
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">User List</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="userList" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>User ID</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Registered Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Table rows will be dynamically populated -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- View User Modal -->
    <div class="modal fade" id="viewUserModal" tabindex="-1" aria-labelledby="viewUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewUserModalLabel">View User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- User details will be loaded here dynamically -->
                    <div id="user-details"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- <!-- Delete User Modal -->
    <div class="modal fade" id="deleteAdminModal" tabindex="-1" aria-labelledby="deleteAdminModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteAdminModalLabel">Delete Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="deleteAdminForm">
                        @csrf
                        <input type="hidden" id="delete_admin_id" name="admin_id">
                        Are you sure you want to delete this admin?
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}
@endsection

@section('script')
    <script src="{{ URL::asset('/assets/libs/swiper/swiper.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/swiper.init.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            var table = $('#userList').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.getUsers') }}",
                columns: [{
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name',
                    },
                    {
                        data: 'email',
                        name: 'email',
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        render: function(data, type, row) {
                            return data ? new Date(data).toLocaleString('en-GB', {
                                day: '2-digit',
                                month: '2-digit',
                                year: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit',
                                second: '2-digit'
                            }) : '';
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                // Handle Ajax errors
                error: function(xhr, errorType, exception) {
                    console.log('Ajax error:', xhr, errorType, exception);
                }
            });

            $('#userList').on('click', '.view-user', function(e) {
                e.preventDefault();
                var userId = $(this).data('id');
                axios.get("admin/users/" + userId)
                    .then(function(response) {
                        var user = response.data;
                        console.log(user);
                        if (user.error) {
                            alert(user.error);
                        } else {
                            var userDetails = '<div><h4 class="mb-4">User Profile</h4>';
                            if (user.profile) {
                                userDetails += '<p><strong>Full Name:</strong> ' + (user.profile
                                    .fullname ? user.profile.fullname : 'Not provided') + '</p>';
                                userDetails += '<p><strong>Address:</strong> ' + (user.profile
                                        .address ? user.profile.address : 'Not provided') +
                                    '</p>';
                                if (user.profile.avatar) {
                                    userDetails += '<p><strong>Avatar:</strong></p>';
                                    userDetails +=
                                        '<div class="swiper pagination-fraction-swiper rounded">' +
                                        '<div class="swiper-wrapper">';
                                    userDetails += '<div class="swiper-slide">' +
                                        '<img src="images/' + user.profile.avatar + '" alt="' + user
                                        .profile.fullname +
                                        '" class="swiper-image" />' +
                                        '</div>';
                                    userDetails += '</div>' +
                                        '<div class="swiper-button-next bg-white shadow"></div>' +
                                        '<div class="swiper-button-prev bg-white shadow"></div>' +
                                        '<div class="swiper-pagination"></div>' +
                                        '</div>';
                                }
                                userDetails += '<p><strong> Registered Date:</strong> ' + (user
                                    .created_at ? new Date(
                                        user.created_at).toLocaleString('en-GB', {
                                        day: '2-digit',
                                        month: '2-digit',
                                        year: 'numeric',
                                        hour: '2-digit',
                                        minute: '2-digit',
                                        second: '2-digit'
                                    }) : 'Not provided') + '</p>';
                                userDetails += '<p><strong>Email:</strong> ' + (user.email ? user
                                    .email : 'Not provided') + '</p>';
                                userDetails += '<p><strong>Phone Number:</strong> ' + (user.profile
                                        .phone_number ? user.profile.phone_number : 'Not provided') +
                                    '</p>';
                                if (user.profile.social_media) {
                                    var socialMedia = JSON.parse(user.profile.social_media);
                                    if (socialMedia.ig_username) {
                                        userDetails +=
                                            '<p><strong>Instagram:</strong> <a href="https://www.instagram.com/' +
                                            socialMedia.ig_username + '" target="_blank">' + socialMedia
                                            .ig_username + '</a></p>';
                                    }
                                    if (socialMedia.twitter_username) {
                                        userDetails +=
                                            '<p><strong>Twitter:</strong> <a href="https://twitter.com/' +
                                            socialMedia.twitter_username + '" target="_blank">' +
                                            socialMedia.twitter_username + '</a></p>';
                                    }
                                    if (socialMedia.tiktok_username) {
                                        userDetails +=
                                            '<p><strong>TikTok:</strong> <a href="https://www.tiktok.com/' +
                                            socialMedia.tiktok_username + '" target="_blank">' +
                                            socialMedia.tiktok_username + '</a></p>';
                                    }
                                }
                            } else {
                                userDetails += '<p>No profile information available.</p>';
                            }
                            userDetails += '</div>';

                            $('#user-details').html(userDetails);
                            $('#viewUserModal').modal('show');
                            $('#viewUserModal').on('shown.bs.modal', function() {
                                var mySwiper = new Swiper('.pagination-fraction-swiper', {
                                    navigation: {
                                        nextEl: '.swiper-button-next',
                                        prevEl: '.swiper-button-prev',
                                    },
                                    pagination: {
                                        el: '.swiper-pagination',
                                        type: 'fraction',
                                    },
                                });
                            });
                        }
                    })
                    .catch(function(error) {
                        alert('Error fetching user details: ' + error.message);
                    });
            });

            // // Delete Report
            // $('#adminList').on('click', '.delete-admin', function(e) {
            //     e.preventDefault();
            //     var adminId = $(this).data('id');

            //     // Set report id in the modal form
            //     $('#delete_admin_id').val(adminId);

            //     // Open confirmation modal
            //     $('#deleteAdminModal').modal('show');
            // });

            // // Handle form submission for delete confirmation
            // $('#deleteAdminForm').submit(function(e) {
            //     e.preventDefault();

            //     var adminId = $('#delete_admin_id').val();
            //     // Perform delete action
            //     axios.delete("{{ url('admin/admins') }}/" + adminId, {
            //             data: {
            //                 '_token': '{{ csrf_token() }}',
            //             }
            //         })
            //         .then(function(response) {
            //             alert(response.data.success);
            //             $('#deleteAdminModal').modal('hide');
            //             table.ajax.reload();
            //         })
            //         .catch(function(error) {
            //             if (error.response) {
            //                 if (error.response.status === 403) {
            //                     alert(error.response.data
            //                     .error); 
            //                 } else {
            //                     alert('Error deleting admin: ' + error
            //                     .message); // Display generic error message
            //                 }
            //             } else if (error.request) {
            //                 // The request was made but no response was received
            //                 console.error(error.request);
            //                 alert('Error deleting admin: No response received');
            //             } else {
            //                 // Something happened in setting up the request that triggered an error
            //                 console.error('Error deleting admin:', error.message);
            //                 alert('Error deleting admin: ' + error.message);
            //             }
            //         });
            // });

        });
    </script>
@endsection
