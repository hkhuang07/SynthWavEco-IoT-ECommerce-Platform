<div class="modal fade" id="updateDeviceModal" tabindex="-1" aria-labelledby="updateDeviceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content item-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="updateDeviceModalLabel">
                    <i class="fa-light fa-edit"></i>
                    Edit IoT Device #<span id="updateDeviceId"></span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="updateDeviceForm" action="" method="post">
                    @csrf

                    <!-- Device Info -->
                    <h6 class="mb-3 text-muted"><i class="fas fa-info-circle"></i> Device Information</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="form-label" for="update_device_id">
                                    <i class="fa-light fa-fingerprint"></i> Device ID <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control item-input" id="update_device_id" name="device_id" maxlength="50" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="form-label" for="update_product_id">
                                    <i class="fa-light fa-box"></i> Product <span class="text-danger">*</span>
                                </label>
                                <select class="form-select item-input" id="update_product_id" name="product_id" required>
                                    @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group mb-4">
                                <label class="form-label" for="update_location">
                                    <i class="fa-light fa-map-marker-alt"></i> Location
                                </label>
                                <input type="text" class="form-control item-input" id="update_location" name="location" maxlength="100" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-4">
                                <label class="form-label">&nbsp;</label>
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" id="update_is_active" name="is_active" value="1">
                                    <label class="form-check-label" for="update_is_active">
                                        <i class="fa-light fa-toggle-on"></i> Active Device
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Device Metrics -->
                    <h6 class="mb-3 text-muted"><i class="fas fa-chart-line"></i> Device Metrics</h6>
                    <div id="updateMetricsContainer"></div>
                    <button type="button" class="btn btn-secondary btn-sm mb-4" onclick="addUpdateMetricRow()">
                        <i class="fas fa-plus"></i> Add Metric
                    </button>

                    <hr class="my-4">

                    <!-- Alert Thresholds -->
                    <h6 class="mb-3 text-muted"><i class="fas fa-bell"></i> Alert Thresholds</h6>
                    <div id="updateThresholdsContainer"></div>
                    <button type="button" class="btn btn-secondary btn-sm" onclick="addUpdateThresholdRow()">
                        <i class="fas fa-plus"></i> Add Threshold
                    </button>
                </form>
            </div>

            <div class="modal-footer item-modal-footer">
                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">
                    <i class="fa-light fa-times"></i> Cancel
                </button>
                <button type="submit" form="updateDeviceForm" class="btn btn-action" id="updateSubmitBtn">
                    <i class="fa-light fa-save"></i>
                    <span class="btn-text">Update Device</span>
                    <span class="btn-loading" style="display: none;">
                        <i class="fa-light fa-spinner fa-spin"></i> Updating...
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let updateMetricIndex = 0;
let updateThresholdIndex = 0;

function addUpdateMetricRow(metricKey = '', description = '', unit = '') {
    const container = document.getElementById('updateMetricsContainer');
    const newRow = document.createElement('div');
    newRow.className = 'metric-row mb-3 p-3 border rounded';
    newRow.innerHTML = `
        <div class="row align-items-end">
            <div class="col-md-3">
                <label class="form-label small">Metric Key</label>
                <input type="text" class="form-control item-input" name="metrics[${updateMetricIndex}][metric_key]" maxlength="20" placeholder="e.g. t, h, m" value="${metricKey}" />
            </div>
            <div class="col-md-4">
                <label class="form-label small">Description</label>
                <input type="text" class="form-control item-input" name="metrics[${updateMetricIndex}][description]" maxlength="100" placeholder="e.g. Temperature" value="${description}" />
            </div>
            <div class="col-md-3">
                <label class="form-label small">Unit</label>
                <input type="text" class="form-control item-input" name="metrics[${updateMetricIndex}][unit]" maxlength="20" placeholder="e.g. C, %, lux" value="${unit}" />
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger btn-sm" onclick="removeUpdateMetricRow(this)">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
    `;
    container.appendChild(newRow);
    updateMetricIndex++;
    updateUpdateMetricRemoveButtons();
}

function removeUpdateMetricRow(btn) {
    btn.closest('.metric-row').remove();
    updateUpdateMetricRemoveButtons();
}

function updateUpdateMetricRemoveButtons() {
    const rows = document.querySelectorAll('#updateMetricsContainer .metric-row');
    rows.forEach(row => {
        const btn = row.querySelector('.btn-danger');
        btn.disabled = rows.length <= 1;
    });
}

function addUpdateThresholdRow(metricKey = '', minValue = '', maxValue = '') {
    const container = document.getElementById('updateThresholdsContainer');
    const newRow = document.createElement('div');
    newRow.className = 'threshold-row mb-3 p-3 border rounded';
    newRow.innerHTML = `
        <div class="row align-items-end">
            <div class="col-md-4">
                <label class="form-label small">Metric Key</label>
                <input type="text" class="form-control item-input" name="thresholds[${updateThresholdIndex}][metric_key]" maxlength="20" placeholder="e.g. t" value="${metricKey}" />
            </div>
            <div class="col-md-3">
                <label class="form-label small">Min Value</label>
                <input type="number" step="0.01" class="form-control item-input" name="thresholds[${updateThresholdIndex}][min_value]" placeholder="Min" value="${minValue}" />
            </div>
            <div class="col-md-3">
                <label class="form-label small">Max Value</label>
                <input type="number" step="0.01" class="form-control item-input" name="thresholds[${updateThresholdIndex}][max_value]" placeholder="Max" value="${maxValue}" />
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger btn-sm" onclick="removeUpdateThresholdRow(this)">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
    `;
    container.appendChild(newRow);
    updateThresholdIndex++;
    updateUpdateThresholdRemoveButtons();
}

function removeUpdateThresholdRow(btn) {
    btn.closest('.threshold-row').remove();
    updateUpdateThresholdRemoveButtons();
}

function updateUpdateThresholdRemoveButtons() {
    const rows = document.querySelectorAll('#updateThresholdsContainer .threshold-row');
    rows.forEach(row => {
        const btn = row.querySelector('.btn-danger');
        btn.disabled = rows.length <= 1;
    });
}

function openUpdateModal(deviceId, deviceData) {
    const updateForm = document.getElementById('updateDeviceForm');
    //updateForm.action = `{{ url('iot-devices/update') }}/${deviceId}`;
    updateForm.action = `{{ route('administrator.iot_devices.update', ['id' => '__ID__']) }}`.replace('__ID__', deviceId);
    
    document.getElementById('updateDeviceId').textContent = deviceId;
    document.getElementById('update_device_id').value = deviceData.device_id || '';
    document.getElementById('update_product_id').value = deviceData.product_id || '';
    document.getElementById('update_location').value = deviceData.location || '';
    document.getElementById('update_is_active').checked = deviceData.is_active;
    
    // Clear and populate metrics
    const metricsContainer = document.getElementById('updateMetricsContainer');
    metricsContainer.innerHTML = '';
    updateMetricIndex = 0;
    
    if (deviceData.metrics && deviceData.metrics.length > 0) {
        deviceData.metrics.forEach(metric => {
            addUpdateMetricRow(metric.metric_key, metric.description, metric.unit);
        });
    } else {
        addUpdateMetricRow();
    }
    
    // Clear and populate thresholds
    const thresholdsContainer = document.getElementById('updateThresholdsContainer');
    thresholdsContainer.innerHTML = '';
    updateThresholdIndex = 0;
    
    if (deviceData.thresholds && deviceData.thresholds.length > 0) {
        deviceData.thresholds.forEach(threshold => {
            addUpdateThresholdRow(threshold.metric_key, threshold.min_value || '', threshold.max_value || '');
        });
    } else {
        addUpdateThresholdRow();
    }
    
    const updateModal = new bootstrap.Modal(document.getElementById('updateDeviceModal'));
    updateModal.show();
}

document.addEventListener('DOMContentLoaded', function() {
    const updateDeviceModal = document.getElementById('updateDeviceModal');
    const updateDeviceForm = document.getElementById('updateDeviceForm');
    const updateSubmitBtn = document.getElementById('updateSubmitBtn');
    const btnText = updateSubmitBtn.querySelector('.btn-text');
    const btnLoading = updateSubmitBtn.querySelector('.btn-loading');

    updateDeviceModal.addEventListener('hidden.bs.modal', function() {
        updateDeviceForm.reset();
        updateSubmitBtn.disabled = false;
        btnText.style.display = 'inline';
        btnLoading.style.display = 'none';
    });

    updateDeviceForm.addEventListener('submit', function(e) {
        updateSubmitBtn.disabled = true;
        btnText.style.display = 'none';
        btnLoading.style.display = 'inline';
    });

    updateDeviceModal.addEventListener('shown.bs.modal', function() {
        document.getElementById('update_device_id').focus();
    });
});
</script>
