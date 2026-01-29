<div class="modal fade" id="orderDetailModal" tabindex="-1" aria-labelledby="orderDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content item-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="orderDetailModalLabel">
                    <i class="fas fa-file-invoice"></i>
                    Order Details: <span id="detailOrderId">#</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 border-end">
                        <h6 class="section-title mb-3"><i class="fas fa-info-circle"></i> Basic Information</h6>
                        <p><strong>Customer:</strong> <span id="detailUserName"></span></p>
                        <p><strong>Status:</strong> <span id="detailStatus" class="badge"></span></p>
                        <p><strong>Date Placed:</strong> <span id="detailCreatedAt"></span></p>
                        <p><strong>Payment Method:</strong> <span id="detailPaymentMethod"></span></p>
                        <hr>
                        <h6 class="section-title mb-3"><i class="fas fa-map-marker-alt"></i> Shipping Details</h6>
                        <p><strong>Phone:</strong> <span id="detailContactPhone"></span></p>
                        <p><strong>Address:</strong> <span id="detailShippingAddress"></span></p>
                        <p><strong>Notes:</strong> <span id="detailNotes">N/A</span></p>
                    </div>

                    <div class="col-md-6">
                        <h6 class="section-title mb-3"><i class="fas fa-calculator"></i> Financial Summary</h6>
                        <table class="table table-sm table-borderless">
                            <tbody>
                                <tr><td>Subtotal:</td><td class="text-end"><strong>$<span id="detailSubtotal"></span></strong></td></tr>
                                <tr><td>Tax Amount:</td><td class="text-end"><strong>$<span id="detailTaxAmount"></span></strong></td></tr>
                                <tr><td>Shipping Fee:</td><td class="text-end"><strong>$<span id="detailShippingFee"></span></strong></td></tr>
                                <tr class="border-top border-3"><td>Total Amount:</td><td class="text-end text-success fs-5"><strong>$<span id="detailTotalAmount"></span></strong></td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <h6 class="section-title mt-4 mb-3"><i class="fas fa-list"></i> Order Items (<span id="detailItemCount"></span>)</h6>
                <div id="detailOrderItems" class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th class="text-end">Price</th>
                                <th class="text-end">Qty</th>
                                <th class="text-end">Line Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            </tbody>
                    </table>
                </div>
            </div>

            <div class="modal-footer item-modal-footer">
                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>

<script>

 function openOrderDetailsModal(orderData) {
        const modalElement = document.getElementById('orderDetailModal');
        if (!modalElement) {
            console.error("Order detail modal element not found.");
            return;
        }

        // 1. Cập nhật thông tin cơ bản
        document.getElementById('detailOrderId').textContent = '#' + orderData.id;
        document.getElementById('detailUserName').textContent = orderData.user ? orderData.user.name : 'Guest';
        document.getElementById('detailStatus').textContent = orderData.status ? orderData.status.name : 'N/A';
        //document.getElementById('detailStatus').className = 'badge status-' + (orderData.status ? orderData.status.name.toLowerCase().replace(/ /g, '-') : 'na');
        
        // Format ngày tháng
        const createdDate = new Date(orderData.created_at);
        document.getElementById('detailCreatedAt').textContent = createdDate.toLocaleDateString('en-GB') + ' ' + createdDate.toLocaleTimeString('en-GB');

        document.getElementById('detailPaymentMethod').textContent = orderData.payment_method;
        document.getElementById('detailContactPhone').textContent = orderData.contact_phone;
        document.getElementById('detailShippingAddress').textContent = orderData.shipping_address;
        document.getElementById('detailNotes').textContent = orderData.notes || 'No notes provided.';

        // 2. Cập nhật thông tin tài chính
        document.getElementById('detailSubtotal').textContent = parseFloat(orderData.subtotal).toFixed(2);
        document.getElementById('detailTaxAmount').textContent = parseFloat(orderData.tax_amount).toFixed(2);
        document.getElementById('detailShippingFee').textContent = parseFloat(orderData.shipping_fee).toFixed(2);
        document.getElementById('detailTotalAmount').textContent = parseFloat(orderData.total_amount).toFixed(2);

        // 3. Cập nhật danh sách Order Items
        const itemsBody = document.querySelector('#detailOrderItems tbody');
        itemsBody.innerHTML = ''; // Xóa nội dung cũ
        let itemCount = 0;

        orderData.items.forEach(item => {
            const row = itemsBody.insertRow();
            const product = item.product || {name: 'Product Deleted', id: 0};
            
            const lineTotal = item.quantity * item.price_at_order;
            itemCount += item.quantity;
            
            row.innerHTML = `
                <td>${product.name} (ID: ${item.product_id})</td>
                <td class="text-end">${formatter.format(item.price_at_order)}</td>
                <td class="text-end">${item.quantity}</td>
                <td class="text-end"><strong>${formatter.format(lineTotal)}</strong></td>
            `;
        });
        document.getElementById('detailItemCount').textContent = orderData.items.length;
        

        // 4. Hiển thị Modal
        const orderDetailModal = new bootstrap.Modal(modalElement);
        orderDetailModal.show();
    }
</script>
