<div class="modal fade" id="deleteDeviceModal" tabindex="-1" aria-labelledby="deleteDeviceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content delete-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="deleteDeviceModalLabel">
                    <i class="fas fa-exclamation-triangle text-warning"></i>
                    Confirm Delete IoT Device
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <div class="delete-confirmation text-center">
                    <div class="delete-icon-container mb-3">
                        <i class="fas fa-microchip delete-icon"></i>
                    </div>
                    
                    <h4 class="delete-title mb-3">Are you sure?</h4>
                    
                    <div class="delete-message mb-4">
                        <p class="mb-2">
                            Do you really want to delete device 
                            <strong id="deleteDeviceName" class="text-danger"></strong>?
                        </p>
                        
                        <div class="item-info-preview bg-light p-3 rounded mb-3">
                            <div class="text-start">
                                <p class="mb-1"><i class="fas fa-box"></i> Product: <span id="deleteDeviceProduct"></span></p>
                                <p class="mb-1"><i class="fas fa-map-marker-alt"></i> Location: <span id="deleteDeviceLocation"></span></p>
                                <p class="mb-1"><i class="fas fa-chart-line"></i> Metrics: <span id="deleteDeviceMetrics"></span></p>
                                <p class="mb-0"><i class="fas fa-bell"></i> Thresholds: <span id="deleteDeviceThresholds"></span></p>
                            </div>
                        </div>
                        
                        <small class="warning-text text-muted">
                            <i class="fas fa-exclamation-circle"></i>
                            This action cannot be undone. All metrics and thresholds will also be deleted.
                        </small>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer item-modal-footer">
                <button type="button" class="btn btn-cancel me-3" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i>
                    Cancel
                </button>
                <a href="#" id="deleteConfirmBtn" class="btn btn-delete">
                    <i class="fas fa-trash-alt"></i>
                    <span>Yes, Delete It</span>
                    <span class="btn-loading" style="display: none;">
                        <i class="fas fa-spinner fa-spin"></i>
                        Deleting...
                    </span>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function openDeleteModal(deviceId, deviceData) {
    document.getElementById('deleteDeviceName').textContent = deviceData.device_id;
    document.getElementById('deleteDeviceProduct').textContent = deviceData.product ? deviceData.product.name : 'N/A';
    document.getElementById('deleteDeviceLocation').textContent = deviceData.location || 'N/A';
    document.getElementById('deleteDeviceMetrics').textContent = deviceData.metrics ? deviceData.metrics.length : 0;
    document.getElementById('deleteDeviceThresholds').textContent = deviceData.thresholds ? deviceData.thresholds.length : 0;
    
    const deleteBtn = document.getElementById('deleteConfirmBtn');
    //deleteBtn.href = `{{ url('iot-devices/delete') }}/${deviceId}`;
    deleteBtn.href = `{{ route('administrator.iot_devices.delete', ['id' => '__ID__']) }}`.replace('__ID__', deviceId);

    
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteDeviceModal'));
    deleteModal.show();
}

document.addEventListener('DOMContentLoaded', function() {
    const deleteConfirmBtn = document.getElementById('deleteConfirmBtn');
    const btnText = deleteConfirmBtn.querySelector('span:not(.btn-loading)');
    const btnLoading = deleteConfirmBtn.querySelector('.btn-loading');

    deleteConfirmBtn.addEventListener('click', function(e) {
        e.preventDefault();
        btnText.style.display = 'none';
        btnLoading.style.display = 'inline';
        deleteConfirmBtn.style.pointerEvents = 'none';
        window.location.href = this.href;
    });
});
</script>
