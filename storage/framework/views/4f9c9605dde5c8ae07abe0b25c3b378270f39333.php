
<?php $__env->startSection('title'); ?>
    Report List
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?>
            Dashboards
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            Reports
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Report List</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="reportList" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th>No.</th> <!-- Index column -->
                                    <th>Report ID</th>
                                    <th>Report Type</th>
                                    <th>Found/Lost Date</th>
                                    <th>Report Date</th>
                                    <th>Status</th>
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

    <!-- View Report Modal -->
    <div class="modal fade" id="viewReportModal" tabindex="-1" aria-labelledby="viewReportModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewReportModalLabel">View Report</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Report details will be loaded here dynamically -->
                    <div id="report-details"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Report Modal -->
    <div class="modal fade" id="deleteReportModal" tabindex="-1" aria-labelledby="deleteReportModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteReportModalLabel">Delete Report</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="deleteReportForm">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" id="delete_report_id" name="report_id">
                        <div class="mb-3">
                            <label for="deleted_type" class="form-label">Reason for Deletion</label>
                            <select class="form-select" id="deleted_type" name="deleted_type" required>
                                <option value="duplicate">Duplicate</option>
                                <option value="irrelevant">Irrelevant</option>
                                <option value="malicious">Malicious</option>
                                <option value="fraudulent">Fraudulent</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="remarks" class="form-label">Remarks</label>
                            <textarea class="form-control" id="remarks" name="remarks" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(URL::asset('/assets/js/app.min.js')); ?>"></script>
    <script>
        $(document).ready(function() {
            var table = $('#reportList').DataTable({
                processing: true,
                serverSide: true,
                ajax: "<?php echo e(route('admin.getReports')); ?>",
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        data: 'id',
                        name: 'report_id'
                    },
                    {
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'item.date',
                        name: 'item.date',
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
                        data: 'isResolved',
                        name: 'isResolved',
                        render: function(data, type, row) {
                            var badgeClass = data == 'resolved' ? 'badge bg-success' :
                                'badge bg-danger';
                            var statusText = data == 'resolved' ? 'Resolved' : 'Unresolved';
                            return '<span class="' + badgeClass + '">' + statusText + '</span>';
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

           // View Report
           $('#reportList').on('click', '.view-report', function(e) {
                e.preventDefault();
                var reportId = $(this).data('id');
                axios.get("<?php echo e(url('admin/reports')); ?>/" + reportId)
                .then(function(response) {
                        var report = response.data;
                        if (report.error) {
                            alert(report.error);
                        } else {
                            // Populate modal with specific sections of report details
                            var itemDetails = '<div><h5>Item Details</h5><p>Description: ' + report.item.description + '</p><p>Date: ' + (report.item.date ? new Date(report.item.date).toLocaleString('en-GB', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' }) : '') + '</p></div>';
                            var userDetails = '<div><h5>User Profile</h5><p>Name: ' + report.user.profile.name + '</p><p>Email: ' + report.user.email + '</p></div>';
                            $('#report-details').html(itemDetails + userDetails);
                            $('#viewReportModal').modal('show');
                        }
                    })
                    .catch(function(error) {
                        alert('Error fetching report details: ' + error.message);
                    });
            });

            // Delete Report
            $('#reportList').on('click', '.delete-report', function(e) {
                e.preventDefault();
                var reportId = $(this).data('id');
                if (confirm('Are you sure you want to delete this report?')) {
                    axios.delete("<?php echo e(url('admin/reports')); ?>/" + reportId, {
                        data: {
                            '_token': '<?php echo e(csrf_token()); ?>',
                            'deleted_type': $('#deleted_type').val(),
                            'remarks': $('#remarks').val()
                        }
                    })
                    .then(function(response) {
                        alert(response.data.success);
                        table.ajax.reload();
                    })
                    .catch(function(error) {
                        alert('Error deleting report: ' + error.message);
                    });
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\FYP-TESTING\resources\views\admin\reports.blade.php ENDPATH**/ ?>