<div class="modal fade" id="addDeviceModal" tabindex="-1" aria-labelledby="addDeviceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content item-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="addDeviceModalLabel">
                    <i class="fa-light fa-microchip"></i>
                    Add New IoT Device
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="addDeviceForm" action="{{ route('administrator.iot_devices.add') }}" method="post">
                    @csrf

                    <!-- Device Info -->
                    <h6 class="mb-3 text-muted"><i class="fas fa-info-circle"></i> Device Information</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="form-label" for="device_id">
                                    <i class="fa-light fa-fingerprint"></i> Device ID <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control item-input @error('device_id') is-invalid @enderror" id="device_id" name="device_id" value="{{ old('device_id') }}" maxlength="50" required />
                                @error('device_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="form-label" for="product_id">
                                    <i class="fa-light fa-box"></i> Product <span class="text-danger">*</span>
                                </label>
                                <select class="form-select item-input @error('product_id') is-invalid @enderror" id="product_id" name="product_id" required>
                                    <option value="">-- Select Product --</option>
                                    @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                                    @endforeach
                                </select>
                                @error('product_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group mb-4">
                                <label class="form-label" for="location">
                                    <i class="fa-light fa-map-marker-alt"></i> Location
                                </label>
                                <input type="text" class="form-control item-input @error('location') is-invalid @enderror" id="location" name="location" value="{{ old('location') }}" maxlength="100" />
                                @error('location')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-4">
                                <label class="form-label">&nbsp;</label>
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked>
                                    <label class="form-check-label" for="is_active">
                                        <i class="fa-light">Active Device</i> 
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Device Metrics -->
                    <h6 class="mb-3 text-muted"><i class="fas fa-chart-line"></i> Device Metrics</h6>
                    <div id="metricsContainer">
                        <div class="metric-row mb-3 p-3 border rounded">
                            <div class="row align-items-end">
                                <div class="col-md-3">
                                    <label class="form-label small">Metric Key</label>
                                    <input type="text" class="form-control item-input" name="metrics[0][metric_key]" maxlength="20" placeholder="e.g. t, h, m" />
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small">Description</label>
                                    <input type="text" class="form-control item-input" name="metrics[0][description]" maxlength="100" placeholder="e.g. Temperature" />
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label small">Unit</label>
                                    <input type="text" class="form-control item-input" name="metrics[0][unit]" maxlength="20" placeholder="e.g. C, %, lux" />
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-danger btn-sm" onclick="removeMetricRow(this)" disabled>
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-secondary btn-sm mb-4" onclick="addMetricRow()">
                        <i class="fas fa-plus"></i> Add Metric
                    </button>

                    <hr class="my-4">

                    <!-- Alert Thresholds -->
                    <h6 class="mb-3 text-muted"><i class="fas fa-bell"></i> Alert Thresholds</h6>
                    <div id="thresholdsContainer">
                        <div class="threshold-row mb-3 p-3 border rounded">
                            <div class="row align-items-end">
                                <div class="col-md-4">
                                    <label class="form-label small">Metric Key</label>
                                    <input type="text" class="form-control item-input" name="thresholds[0][metric_key]" maxlength="20" placeholder="e.g. t" />
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label small">Min Value</label>
                                    <input type="number" step="0.01" class="form-control item-input" name="thresholds[0][min_value]" placeholder="Min" />
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label small">Max Value</label>
                                    <input type="number" step="0.01" class="form-control item-input" name="thresholds[0][max_value]" placeholder="Max" />
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-danger btn-sm" onclick="removeThresholdRow(this)" disabled>
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-secondary btn-sm" onclick="addThresholdRow()">
                        <i class="fas fa-plus"></i> Add Threshold
                    </button>
                </form>
            </div>

            <div class="modal-footer item-modal-footer">
                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">
                    <i class="fa-light fa-times"></i> Cancel
                </button>
                <button type="submit" form="addDeviceForm" class="btn btn-action" id="submitBtn">
                    <i class="fa-light fa-save"></i>
                    <span class="btn-text">Create Device</span>
                    <span class="btn-loading" style="display: none;">
                        <i class="fa-light fa-spinner fa-spin"></i> Creating...
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let metricIndex = 0;
let thresholdIndex = 0;

function addMetricRow() {
    metricIndex++;
    const container = document.getElementById('metricsContainer');
    const newRow = document.createElement('div');
    newRow.className = 'metric-row mb-3 p-3 border rounded';
    newRow.innerHTML = `
        <div class="row align-items-end">
            <div class="col-md-3">
                <label class="form-label small">Metric Key</label>
                <input type="text" class="form-control item-input" name="metrics[${metricIndex}][metric_key]" maxlength="20" placeholder="e.g. t, h, m" />
            </div>
            <div class="col-md-4">
                <label class="form-label small">Description</label>
                <input type="text" class="form-control item-input" name="metrics[${metricIndex}][description]" maxlength="100" placeholder="e.g. Temperature" />
            </div>
            <div class="col-md-3">
                <label class="form-label small">Unit</label>
                <input type="text" class="form-control item-input" name="metrics[${metricIndex}][unit]" maxlength="20" placeholder="e.g. C, %, lux" />
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger btn-sm" onclick="removeMetricRow(this)">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
    `;
    container.appendChild(newRow);
    updateMetricRemoveButtons();
}

function removeMetricRow(btn) {
    btn.closest('.metric-row').remove();
    updateMetricRemoveButtons();
}

function updateMetricRemoveButtons() {
    const rows = document.querySelectorAll('#metricsContainer .metric-row');
    rows.forEach(row => {
        const btn = row.querySelector('.btn-danger');
        btn.disabled = rows.length <= 1;
    });
}

function addThresholdRow() {
    thresholdIndex++;
    const container = document.getElementById('thresholdsContainer');
    const newRow = document.createElement('div');
    newRow.className = 'threshold-row mb-3 p-3 border rounded';
    newRow.innerHTML = `
        <div class="row align-items-end">
            <div class="col-md-4">
                <label class="form-label small">Metric Key</label>
                <input type="text" class="form-control item-input" name="thresholds[${thresholdIndex}][metric_key]" maxlength="20" placeholder="e.g. t" />
            </div>
            <div class="col-md-3">
                <label class="form-label small">Min Value</label>
                <input type="number" step="0.01" class="form-control item-input" name="thresholds[${thresholdIndex}][min_value]" placeholder="Min" />
            </div>
            <div class="col-md-3">
                <label class="form-label small">Max Value</label>
                <input type="number" step="0.01" class="form-control item-input" name="thresholds[${thresholdIndex}][max_value]" placeholder="Max" />
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger btn-sm" onclick="removeThresholdRow(this)">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
    `;
    container.appendChild(newRow);
    updateThresholdRemoveButtons();
}

function removeThresholdRow(btn) {
    btn.closest('.threshold-row').remove();
    updateThresholdRemoveButtons();
}

function updateThresholdRemoveButtons() {
    const rows = document.querySelectorAll('#thresholdsContainer .threshold-row');
    rows.forEach(row => {
        const btn = row.querySelector('.btn-danger');
        btn.disabled = rows.length <= 1;
    });
}

document.addEventListener('DOMContentLoaded', function() {
    const addDeviceModal = document.getElementById('addDeviceModal');
    const addDeviceForm = document.getElementById('addDeviceForm');
    const submitBtn = document.getElementById('submitBtn');
    const btnText = submitBtn.querySelector('.btn-text');
    const btnLoading = submitBtn.querySelector('.btn-loading');

    addDeviceModal.addEventListener('hidden.bs.modal', function() {
        addDeviceForm.reset();
        // Reset metrics
        const metricsContainer = document.getElementById('metricsContainer');
        while (metricsContainer.children.length > 1) {
            metricsContainer.removeChild(metricsContainer.lastChild);
        }
        // Reset thresholds
        const thresholdsContainer = document.getElementById('thresholdsContainer');
        while (thresholdsContainer.children.length > 1) {
            thresholdsContainer.removeChild(thresholdsContainer.lastChild);
        }
        metricIndex = 0;
        thresholdIndex = 0;
        submitBtn.disabled = false;
        btnText.style.display = 'inline';
        btnLoading.style.display = 'none';
    });

    addDeviceForm.addEventListener('submit', function(e) {
        submitBtn.disabled = true;
        btnText.style.display = 'none';
        btnLoading.style.display = 'inline';
    });

    addDeviceModal.addEventListener('shown.bs.modal', function() {
        document.getElementById('device_id').focus();
    });
});
</script>
