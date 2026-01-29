<div class="modal fade" id="updateOrderModal" tabindex="-1" aria-labelledby="updateOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content item-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="updateOrderModalLabel">
                    <i class="fa-light fa-edit"></i>
                    Edit Order #<span id="updateOrderId"></span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="updateOrderForm" action="" method="post">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="form-label">
                                    <i class="fa-light fa-user"></i> Customer
                                </label>
                                <input type="text" class="form-control item-input" id="updateCustomerName" readonly disabled />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="form-label" for="update_order_status_id">
                                    <i class="fa-light fa-flag"></i> Status <span class="text-danger">*</span>
                                </label>
                                <select class="form-select item-input" id="update_order_status_id" name="order_status_id" required>
                                    @foreach($statuses as $status)
                                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="form-label" for="update_contact_phone">
                                    <i class="fa-light fa-phone"></i> Contact Phone <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control item-input" id="update_contact_phone" name="contact_phone" maxlength="20" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="form-label" for="update_payment_method">
                                    <i class="fa-light fa-credit-card"></i> Payment Method <span class="text-danger">*</span>
                                </label>
                                <select class="form-select item-input" id="update_payment_method" name="payment_method" required>
                                    <option value="COD">Cash on Delivery</option>
                                    <option value="Credit Card">Credit Card</option>
                                    <option value="Bank Transfer">Bank Transfer</option>
                                    <option value="E-Wallet">E-Wallet</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label" for="update_shipping_address">
                            <i class="fa-light fa-map-marker-alt"></i> Shipping Address <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control item-input" id="update_shipping_address" name="shipping_address" rows="2" required></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="form-label" for="update_tax_amount">
                                    <i class="fa-light fa-percent"></i> Tax Amount
                                </label>
                                <input type="number" step="0.01" min="0" class="form-control item-input" id="update_tax_amount" name="tax_amount" onchange="calculateUpdateTotal()" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="form-label" for="update_shipping_fee">
                                    <i class="fa-light fa-truck"></i> Shipping Fee
                                </label>
                                <input type="number" step="0.01" min="0" class="form-control item-input" id="update_shipping_fee" name="shipping_fee" onchange="calculateUpdateTotal()" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label" for="update_notes">
                            <i class="fa-light fa-sticky-note"></i> Notes
                        </label>
                        <textarea class="form-control item-input" id="update_notes" name="notes" rows="2"></textarea>
                    </div>

                    <!-- Order Items -->
                    <div class="form-group mb-4">
                        <label class="form-label">
                            <i class="fa-light fa-list"></i> Order Items <span class="text-danger">*</span>
                        </label>
                        <div id="updateOrderItemsContainer"></div>
                        <button type="button" class="btn btn-secondary btn-sm" onclick="addUpdateOrderItem()">
                            <i class="fas fa-plus"></i> Add Item
                        </button>
                    </div>

                    <!-- Order Summary -->
                    <div class="order-summary bg-light p-3 rounded">
                        <div class="row">
                            <div class="col-md-6 offset-md-6">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Subtotal:</span>
                                    <strong id="updateSubtotalDisplay">$0.00</strong>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Tax:</span>
                                    <span id="updateTaxDisplay">$0.00</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Shipping:</span>
                                    <span id="updateShippingDisplay">$0.00</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <strong>Total:</strong>
                                    <strong id="updateTotalDisplay" class="text-success">$0.00</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer item-modal-footer">
                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">
                    <i class="fa-light fa-times"></i> Cancel
                </button>
                <button type="submit" form="updateOrderForm" class="btn btn-action" id="updateSubmitBtn">
                    <i class="fa-light fa-save"></i>
                    <span class="btn-text">Update Order</span>
                    <span class="btn-loading" style="display: none;">
                        <i class="fa-light fa-spinner fa-spin"></i> Updating...
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let updateItemIndex = 0;

function getProductOptionsHtml() {
    let html = '<option value="">-- Select Product --</option>';
    if (typeof productsData !== 'undefined') {
        productsData.forEach(p => {
            html += `<option value="${p.id}" data-price="${p.price}">${p.name} - $${parseFloat(p.price).toFixed(2)}</option>`;
        });
    }
    return html;
}

function addUpdateOrderItem(productId = '', quantity = 1, price = 0) {
    const container = document.getElementById('updateOrderItemsContainer');
    const productOptions = getProductOptionsHtml();
    
    const newRow = document.createElement('div');
    newRow.className = 'order-item-row mb-3 p-3 border rounded';
    newRow.innerHTML = `
        <div class="row align-items-end">
            <div class="col-md-5">
                <label class="form-label small">Product</label>
                <select class="form-select item-input product-select" name="items[${updateItemIndex}][product_id]" required onchange="updateUpdatePrice(this)">
                    ${productOptions}
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small">Quantity</label>
                <input type="number" class="form-control item-input quantity-input" name="items[${updateItemIndex}][quantity]" min="1" value="${quantity}" required onchange="calculateUpdateTotal()" />
            </div>
            <div class="col-md-3">
                <label class="form-label small">Price</label>
                <input type="number" step="0.01" class="form-control item-input price-input" name="items[${updateItemIndex}][price_at_order]" min="0" value="${price}" required onchange="calculateUpdateTotal()" />
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger btn-sm" onclick="removeUpdateOrderItem(this)">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
    `;
    container.appendChild(newRow);
    
    if (productId) {
        newRow.querySelector('.product-select').value = productId;
    }
    
    updateItemIndex++;
    updateUpdateRemoveButtons();
}

function removeUpdateOrderItem(btn) {
    btn.closest('.order-item-row').remove();
    calculateUpdateTotal();
    updateUpdateRemoveButtons();
}

function updateUpdateRemoveButtons() {
    const rows = document.querySelectorAll('#updateOrderItemsContainer .order-item-row');
    rows.forEach(row => {
        const btn = row.querySelector('.btn-danger');
        btn.disabled = rows.length <= 1;
    });
}

function updateUpdatePrice(select) {
    const price = select.options[select.selectedIndex].dataset.price || 0;
    const container = select.closest('.order-item-row');
    container.querySelector('.price-input').value = price;
    calculateUpdateTotal();
}

function calculateUpdateTotal() {
    let subtotal = 0;
    document.querySelectorAll('#updateOrderItemsContainer .order-item-row').forEach(row => {
        const qty = parseFloat(row.querySelector('.quantity-input').value) || 0;
        const price = parseFloat(row.querySelector('.price-input').value) || 0;
        subtotal += qty * price;
    });
    
    const tax = parseFloat(document.getElementById('update_tax_amount').value) || 0;
    const shipping = parseFloat(document.getElementById('update_shipping_fee').value) || 0;
    const total = subtotal + tax + shipping;
    
    document.getElementById('updateSubtotalDisplay').textContent = '$' + subtotal.toFixed(2);
    document.getElementById('updateTaxDisplay').textContent = '$' + tax.toFixed(2);
    document.getElementById('updateShippingDisplay').textContent = '$' + shipping.toFixed(2);
    document.getElementById('updateTotalDisplay').textContent = '$' + total.toFixed(2);
}

function openUpdateModal(orderId, orderData) {
    const updateForm = document.getElementById('updateOrderForm');
    //updateForm.action = `{{ url('orders/update') }}/${orderId}`;
    updateForm.action = `{{ route('administrator.orders.update', ['id' => '__ID__']) }}`.replace('__ID__', orderId);
    
    document.getElementById('updateOrderId').textContent = orderId;
    document.getElementById('updateCustomerName').value = orderData.user ? orderData.user.name : 'N/A';
    document.getElementById('update_order_status_id').value = orderData.order_status_id || '';
    document.getElementById('update_contact_phone').value = orderData.contact_phone || '';
    document.getElementById('update_payment_method').value = orderData.payment_method || '';
    document.getElementById('update_shipping_address').value = orderData.shipping_address || '';
    document.getElementById('update_tax_amount').value = orderData.tax_amount || 0;
    document.getElementById('update_shipping_fee').value = orderData.shipping_fee || 0;
    document.getElementById('update_notes').value = orderData.notes || '';
    
    // Clear and populate order items
    const container = document.getElementById('updateOrderItemsContainer');
    container.innerHTML = '';
    updateItemIndex = 0;
    
    if (orderData.items && orderData.items.length > 0) {
        orderData.items.forEach(item => {
            addUpdateOrderItem(item.product_id, item.quantity, item.price_at_order);
        });
    } else {
        addUpdateOrderItem();
    }
    
    calculateUpdateTotal();
    
    const updateModal = new bootstrap.Modal(document.getElementById('updateOrderModal'));
    updateModal.show();
}
</script>
