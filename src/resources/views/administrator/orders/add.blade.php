<div class="modal fade" id="addOrderModal" tabindex="-1" aria-labelledby="addOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content item-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="addOrderModalLabel">
                    <i class="fa-light fa-plus-circle"></i>
                    Add New Order
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="addOrderForm" action="{{ route('administrator.orders.add') }}" method="post">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="form-label" for="user_id">
                                    <i class="fa-light fa-user"></i> Customer <span class="text-danger">*</span>
                                </label>
                                <select class="form-select item-input @error('user_id') is-invalid @enderror" id="user_id" name="user_id" required>
                                    <option value="">-- Select Customer --</option>
                                    @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                @error('user_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="form-label" for="order_status_id">
                                    <i class="fa-light fa-flag"></i> Status <span class="text-danger">*</span>
                                </label>
                                <select class="form-select item-input @error('order_status_id') is-invalid @enderror" id="order_status_id" name="order_status_id" required>
                                    <option value="">-- Select Status --</option>
                                    @foreach($statuses as $status)
                                    <option value="{{ $status->id }}" {{ old('order_status_id') == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
                                    @endforeach
                                </select>
                                @error('order_status_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="form-label" for="contact_phone">
                                    <i class="fa-light fa-phone"></i> Contact Phone <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control item-input @error('contact_phone') is-invalid @enderror" id="contact_phone" name="contact_phone" value="{{ old('contact_phone') }}" maxlength="20" required />
                                @error('contact_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="form-label" for="payment_method">
                                    <i class="fa-light fa-credit-card"></i> Payment Method <span class="text-danger">*</span>
                                </label>
                                <select class="form-select item-input @error('payment_method') is-invalid @enderror" id="payment_method" name="payment_method" required>
                                    <option value="">-- Select Payment --</option>
                                    <option value="COD" {{ old('payment_method') == 'COD' ? 'selected' : '' }}>Cash on Delivery</option>
                                    <option value="Credit Card" {{ old('payment_method') == 'Credit Card' ? 'selected' : '' }}>Credit Card</option>
                                    <option value="Bank Transfer" {{ old('payment_method') == 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                    <option value="E-Wallet" {{ old('payment_method') == 'E-Wallet' ? 'selected' : '' }}>E-Wallet</option>
                                </select>
                                @error('payment_method')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label" for="shipping_address">
                            <i class="fa-light fa-map-marker-alt"></i> Shipping Address <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control item-input @error('shipping_address') is-invalid @enderror" id="shipping_address" name="shipping_address" rows="2" required>{{ old('shipping_address') }}</textarea>
                        @error('shipping_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="form-label" for="tax_amount">
                                    <i class="fa-light fa-percent"></i> Tax Amount
                                </label>
                                <input type="number" step="0.01" min="0" class="form-control item-input" id="tax_amount" name="tax_amount" value="{{ old('tax_amount', 0) }}" onchange="calculateTotal()" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="form-label" for="shipping_fee">
                                    <i class="fa-light fa-truck"></i> Shipping Fee
                                </label>
                                <input type="number" step="0.01" min="0" class="form-control item-input" id="shipping_fee" name="shipping_fee" value="{{ old('shipping_fee', 0) }}" onchange="calculateTotal()" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label" for="notes">
                            <i class="fa-light fa-sticky-note"></i> Notes
                        </label>
                        <textarea class="form-control item-input" id="notes" name="notes" rows="2">{{ old('notes') }}</textarea>
                    </div>

                    <!-- Order Items -->
                    <div class="form-group mb-4">
                        <label class="form-label">
                            <i class="fa-light fa-list"></i> Order Items <span class="text-danger">*</span>
                        </label>
                        <div id="orderItemsContainer">
                            <div class="order-item-row mb-3 p-3 border rounded">
                                <div class="row align-items-end">
                                    <div class="col-md-5">
                                        <label class="form-label small">Product</label>
                                        <select class="form-select item-input product-select" name="items[0][product_id]" required onchange="updatePrice(this, 0)">
                                            <option value="">-- Select Product --</option>
                                            @foreach($products as $product)
                                            <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }} - ${{ number_format($product->price, 2) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label small">Quantity</label>
                                        <input type="number" class="form-control item-input quantity-input" name="items[0][quantity]" min="1" value="1" required onchange="calculateTotal()" />
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label small">Price</label>
                                        <input type="number" step="0.01" class="form-control item-input price-input" name="items[0][price_at_order]" min="0" required onchange="calculateTotal()" />
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-danger btn-sm" onclick="removeOrderItem(this)" disabled>
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary btn-sm" onclick="addOrderItem()">
                            <i class="fas fa-plus"></i> Add Item
                        </button>
                    </div>

                    <!-- Order Summary -->
                    <div class="order-summary bg-light p-3 rounded">
                        <div class="row">
                            <div class="col-md-6 offset-md-6">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Subtotal:</span>
                                    <strong id="subtotalDisplay">$0.00</strong>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Tax:</span>
                                    <span id="taxDisplay">$0.00</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Shipping:</span>
                                    <span id="shippingDisplay">$0.00</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <strong>Total:</strong>
                                    <strong id="totalDisplay" class="text-success">$0.00</strong>
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
                <button type="submit" form="addOrderForm" class="btn btn-action" id="submitBtn">
                    <i class="fa-light fa-save"></i>
                    <span class="btn-text">Create Order</span>
                    <span class="btn-loading" style="display: none;">
                        <i class="fa-light fa-spinner fa-spin"></i> Creating...
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let itemIndex = 0;

function addOrderItem() {
    itemIndex++;
    const container = document.getElementById('orderItemsContainer');
    const productOptions = document.querySelector('.product-select').innerHTML;
    
    const newRow = document.createElement('div');
    newRow.className = 'order-item-row mb-3 p-3 border rounded';
    newRow.innerHTML = `
        <div class="row align-items-end">
            <div class="col-md-5">
                <label class="form-label small">Product</label>
                <select class="form-select item-input product-select" name="items[${itemIndex}][product_id]" required onchange="updatePrice(this, ${itemIndex})">
                    ${productOptions}
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small">Quantity</label>
                <input type="number" class="form-control item-input quantity-input" name="items[${itemIndex}][quantity]" min="1" value="1" required onchange="calculateTotal()" />
            </div>
            <div class="col-md-3">
                <label class="form-label small">Price</label>
                <input type="number" step="0.01" class="form-control item-input price-input" name="items[${itemIndex}][price_at_order]" min="0" required onchange="calculateTotal()" />
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger btn-sm" onclick="removeOrderItem(this)">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
    `;
    container.appendChild(newRow);
    updateRemoveButtons();
}

function removeOrderItem(btn) {
    btn.closest('.order-item-row').remove();
    calculateTotal();
    updateRemoveButtons();
}

function updateRemoveButtons() {
    const rows = document.querySelectorAll('#orderItemsContainer .order-item-row');
    rows.forEach((row, index) => {
        const btn = row.querySelector('.btn-danger');
        btn.disabled = rows.length <= 1;
    });
}

function updatePrice(select, index) {
    const price = select.options[select.selectedIndex].dataset.price || 0;
    const container = select.closest('.order-item-row');
    container.querySelector('.price-input').value = price;
    calculateTotal();
}

function calculateTotal() {
    let subtotal = 0;
    document.querySelectorAll('#orderItemsContainer .order-item-row').forEach(row => {
        const qty = parseFloat(row.querySelector('.quantity-input').value) || 0;
        const price = parseFloat(row.querySelector('.price-input').value) || 0;
        subtotal += qty * price;
    });
    
    const tax = parseFloat(document.getElementById('tax_amount').value) || 0;
    const shipping = parseFloat(document.getElementById('shipping_fee').value) || 0;
    const total = subtotal + tax + shipping;
    
    document.getElementById('subtotalDisplay').textContent = '$' + subtotal.toFixed(2);
    document.getElementById('taxDisplay').textContent = '$' + tax.toFixed(2);
    document.getElementById('shippingDisplay').textContent = '$' + shipping.toFixed(2);
    document.getElementById('totalDisplay').textContent = '$' + total.toFixed(2);
}

document.addEventListener('DOMContentLoaded', function() {
    const addOrderModal = document.getElementById('addOrderModal');
    addOrderModal.addEventListener('hidden.bs.modal', function() {
        document.getElementById('addOrderForm').reset();
        const container = document.getElementById('orderItemsContainer');
        while (container.children.length > 1) {
            container.removeChild(container.lastChild);
        }
        itemIndex = 0;
        calculateTotal();
    });
});
</script>
