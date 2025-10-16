<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Checkout</title>
    <!-- Load Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Load Lucide icons for a clean look -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        /* Custom styles for a modern look */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f7f9fc; /* Light background */
        }
        .card {
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }
        input[type="radio"]:checked + label {
            border-color: #4f46e5;
            background-color: #eef2ff;
        }
        .input-focus:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
        }
    </style>
</head>
<body class="min-h-screen antialiased">
    <!-- Main Content Container -->
    <div class="max-w-4xl mx-auto p-4 md:p-8">

        <!-- Header -->
        <header class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800 flex items-center justify-center">
                <i data-lucide="shopping-cart" class="w-7 h-7 mr-2 text-indigo-600"></i>
                Secure Checkout
            </h1>
            <p class="text-gray-500 mt-1">Please confirm your details to place the order.</p>
        </header>

        <form id="checkoutForm" class="grid grid-cols-1 lg:grid-cols-3 gap-8" method="POST" action="{{ route('checkout.place') }}">
            @csrf
            <input type="hidden" name="shipping" id="shippingInput">
            <input type="hidden" name="payment" id="paymentInput">

            <!-- Section 1: Customer Information (Col 1 & 2) -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Customer Details Card -->
                <div class="card bg-white p-6 rounded-xl border border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                        <i data-lucide="user" class="w-5 h-5 mr-2 text-indigo-500"></i>
                        1. Customer Details
                    </h2>
                    <div class="space-y-4">
                        <label class="block">
                            <span class="text-sm font-medium text-gray-700">Full Name</span>
                            <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name ?? '') }}" required class="input-focus mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none transition duration-150">
                        </label>
                        <label class="block">
                            <span class="text-sm font-medium text-gray-700">Email</span>
                            <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email ?? '') }}" required class="input-focus mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none transition duration-150">
                        </label>
                        <label class="block">
                            <span class="text-sm font-medium text-gray-700">Phone Number (e.g., 01XXXXXXXXX)</span>
                            <input type="tel" id="phone" required pattern="^01[0-9]{9}$" title="Must be a valid Bangladeshi 11-digit mobile number starting with 01" class="input-focus mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none transition duration-150">
                        </label>
                        <label class="block">
                            <span class="text-sm font-medium text-gray-700">Full Address (House, Road, Area)</span>
                            <textarea name="address" id="address" rows="3" required class="input-focus mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none transition duration-150">{{ old('address') }}</textarea>
                        </label>
                    </div>
                </div>

                <!-- Shipping Options Card -->
                <div class="card bg-white p-6 rounded-xl border border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                        <i data-lucide="map-pin" class="w-5 h-5 mr-2 text-indigo-500"></i>
                        2. Shipping Options
                    </h2>
                    <div class="space-y-3" id="shippingOptions">
                        <!-- Radio buttons for shipping -->
                        <div class="flex items-center">
                            <input type="radio" id="shippingDhaka" name="shipping" value="Dhaka Within" data-charge="80" required class="hidden" onchange="updateSummary()">
                            <label for="shippingDhaka" class="w-full cursor-pointer p-4 border-2 border-gray-300 rounded-xl flex justify-between items-center transition duration-200 hover:bg-gray-50">
                                <div>
                                    <span class="font-medium text-gray-800">Dhaka Within</span>
                                    <p class="text-xs text-gray-500">Fastest Delivery</p>
                                </div>
                                <span class="font-bold text-indigo-600">৳ 80</span>
                            </label>
                        </div>
                        
                        <div class="flex items-center">
                            <input type="radio" id="shippingChittagong" name="shipping" value="Chittagong Within" data-charge="100" required class="hidden" onchange="updateSummary()">
                            <label for="shippingChittagong" class="w-full cursor-pointer p-4 border-2 border-gray-300 rounded-xl flex justify-between items-center transition duration-200 hover:bg-gray-50">
                                <div>
                                    <span class="font-medium text-gray-800">Chittagong Within</span>
                                    <p class="text-xs text-gray-500">Standard Delivery</p>
                                </div>
                                <span class="font-bold text-indigo-600">৳ 100</span>
                            </label>
                        </div>

                        <div class="flex items-center">
                            <input type="radio" id="shippingOutside" name="shipping" value="Outside Areas" data-charge="150" required class="hidden" onchange="updateSummary()">
                            <label for="shippingOutside" class="w-full cursor-pointer p-4 border-2 border-gray-300 rounded-xl flex justify-between items-center transition duration-200 hover:bg-gray-50">
                                <div>
                                    <span class="font-medium text-gray-800">Outside Areas</span>
                                    <p class="text-xs text-gray-500">Extended Delivery Time</p>
                                </div>
                                <span class="font-bold text-indigo-600">৳ 150</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Payment Method Card -->
                <div class="card bg-white p-6 rounded-xl border border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                        <i data-lucide="wallet" class="w-5 h-5 mr-2 text-indigo-500"></i>
                        3. Payment Method
                    </h2>
                    <div class="space-y-3">
                        <!-- COD -->
                        <div class="flex items-center">
                            <input type="radio" id="paymentCOD" name="payment" value="Cash on Delivery" required class="hidden" onchange="togglePaymentFields(this.value)">
                            <label for="paymentCOD" class="w-full cursor-pointer p-4 border-2 border-gray-300 rounded-xl flex items-center transition duration-200 hover:bg-gray-50">
                                <i data-lucide="baggage-claim" class="w-5 h-5 mr-3 text-green-600"></i>
                                <span class="font-medium text-gray-800">Cash on Delivery (COD)</span>
                            </label>
                        </div>
                        
                        <!-- bKash -->
                        <div class="flex items-center">
                            <input type="radio" id="paymentBkash" name="payment" value="bKash" required class="hidden" onchange="togglePaymentFields(this.value)">
                            <label for="paymentBkash" class="w-full cursor-pointer p-4 border-2 border-gray-300 rounded-xl flex items-center transition duration-200 hover:bg-gray-50">
                                <i data-lucide="zap" class="w-5 h-5 mr-3 text-pink-600"></i>
                                <span class="font-medium text-gray-800">bKash</span>
                            </label>
                        </div>
                        
                        <!-- Nagad -->
                        <div class="flex items-center">
                            <input type="radio" id="paymentNagad" name="payment" value="Nagad" required class="hidden" onchange="togglePaymentFields(this.value)">
                            <label for="paymentNagad" class="w-full cursor-pointer p-4 border-2 border-gray-300 rounded-xl flex items-center transition duration-200 hover:bg-gray-50">
                                <i data-lucide="gauge" class="w-5 h-5 mr-3 text-red-600"></i>
                                <span class="font-medium text-gray-800">Nagad</span>
                            </label>
                        </div>

                        <!-- bKash/Nagad Transaction Fields (Conditionally visible) -->
                        <div id="transactionFields" class="bg-gray-50 p-4 rounded-lg space-y-4 hidden mt-4 transition-all duration-300">
                            <p id="paymentAccountInfo" class="text-sm font-semibold text-center text-indigo-600"></p>
                            
                            <label class="block">
                                <span class="text-sm font-medium text-gray-700">Your Payment Number</span>
                                <input type="tel" id="paymentNumber" placeholder="Your 11-digit number" class="input-focus mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none transition duration-150">
                            </label>
                            
                            <label class="block">
                                <span class="text-sm font-medium text-gray-700">Transaction ID (TrxID)</span>
                                <input type="text" id="transactionId" placeholder="e.g., 8G7A5F3R4S" class="input-focus mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none transition duration-150">
                            </label>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Section 2: Order Summary (Col 3 / Right Sidebar) -->
            <div class="lg:col-span-1">
                <div class="card bg-white p-6 rounded-xl sticky top-8 border border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                        <i data-lucide="receipt" class="w-5 h-5 mr-2 text-indigo-500"></i>
                        Order Summary
                    </h2>
                    @if(!empty($items))
                    <div class="space-y-3 mb-4 max-h-56 overflow-auto pr-2">
                        @foreach($items as $it)
                        <div class="flex items-center justify-between text-sm">
                            <div class="flex items-center">
                                <img src="{{ $it['image'] }}" alt="" class="w-10 h-10 rounded mr-2 object-cover">
                                <div>
                                    <div class="font-medium text-gray-800">{{ $it['name'] }}</div>
                                    <div class="text-gray-500">Qty: {{ $it['quantity'] }}</div>
                                </div>
                            </div>
                            <div class="font-medium text-gray-800">৳ {{ number_format($it['price'] * $it['quantity'], 2) }}</div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                    
                    <div class="space-y-3 pb-4 border-b border-gray-200">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600">Product Cost (Fixed)</span>
                            <span class="font-semibold text-gray-800">৳ <span id="productCost" data-amount="{{ (float) $subtotal }}">{{ number_format($subtotal, 2) }}</span></span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600">Delivery Charge</span>
                            <span class="font-semibold text-gray-800">৳ <span id="deliveryCharge">0</span></span>
                        </div>
                    </div>

                    <div class="pt-4 flex justify-between items-center text-lg font-bold">
                        <span class="text-gray-800">Total Payable</span>
                        <span class="text-indigo-600">৳ <span id="totalAmount">{{ number_format($subtotal, 2) }}</span></span>
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-xl transition duration-200 flex items-center justify-center">
                            <i data-lucide="check-circle" class="w-5 h-5 mr-2"></i>
                            Preview & Place Order
                        </button>
                    </div>
                    
                    <p class="text-xs text-gray-400 mt-4 text-center">Your User ID: <span id="userIdDisplay" class="font-mono text-gray-500"></span></p>

                    <!-- Message Box for general feedback (e.g., success/error) -->
                    <div id="messageBox" class="mt-4 p-3 rounded-lg text-sm hidden"></div>
                </div>
            </div>
        </form>
    </div>

    <!-- Order Preview Modal -->
    <div id="previewModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 z-50 flex items-center justify-center hidden p-4 transition-opacity duration-300 opacity-0">
        <div class="bg-white rounded-xl w-full max-w-md p-6 shadow-2xl transform scale-95 transition-transform duration-300">
            <h3 class="text-2xl font-bold text-gray-800 mb-4 border-b pb-2 flex items-center">
                <i data-lucide="clipboard-check" class="w-6 h-6 mr-2 text-green-500"></i>
                Confirm Your Order
            </h3>
            <div id="modalSummaryContent" class="space-y-3 text-sm mb-6">
                <!-- Summary content will be injected here -->
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeModal()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 transition duration-150">
                    Edit
                </button>
                <button type="button" onclick="placeOrder()" id="confirmOrderBtn" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-150 flex items-center">
                    <i data-lucide="package-check" class="w-4 h-4 mr-2"></i>
                    Confirm Order
                </button>
            </div>
        </div>
    </div>

    <!-- Loading Indicator -->
    <div id="loadingIndicator" class="fixed inset-0 bg-gray-900 bg-opacity-50 z-[60] flex items-center justify-center hidden">
        <div class="flex flex-col items-center bg-white p-6 rounded-lg shadow-xl">
            <svg class="animate-spin h-8 w-8 text-indigo-600 mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <p class="text-gray-700 font-medium">Processing Order...</p>
        </div>
    </div>

    <!-- Initialize totals from server -->
    <script>
        window.INIT_SUBTOTAL = parseFloat(document.getElementById('productCost').dataset.amount || '0');
    </script>
    
    <script>
        // Data and Constants
        const PRODUCT_COST = window.INIT_SUBTOTAL || 0;
        const DELIVERY_CHARGES = {
            'Dhaka Within': 80,
            'Chittagong Within': 100,
            'Outside Areas': 150
        };
        
        document.addEventListener('DOMContentLoaded', () => {
            // Initialize Lucide icons
            lucide.createIcons();
            // Attach form submission listener
            document.getElementById('checkoutForm').addEventListener('submit', handleFormSubmit);
            // Ensure initial summary calculation
            updateSummary();
        });

        /**
         * Toggles the visibility of bKash/Nagad transaction fields.
         * @param {string} paymentMethod - The selected payment method (e.g., 'bKash', 'Nagad', 'Cash on Delivery').
         */
        function togglePaymentFields(paymentMethod) {
            const fieldsDiv = document.getElementById('transactionFields');
            const infoText = document.getElementById('paymentAccountInfo');
            const paymentNumberInput = document.getElementById('paymentNumber');
            const transactionIdInput = document.getElementById('transactionId');

            if (paymentMethod === 'bKash' || paymentMethod === 'Nagad') {
                fieldsDiv.classList.remove('hidden');
                fieldsDiv.style.opacity = '1';
                // MANDATORY: Set inputs as required
                paymentNumberInput.required = true;
                transactionIdInput.required = true;

                const accountInfo = paymentMethod === 'bKash'
                    ? `Please send the total amount to our official bKash Merchant Number: **017XXXXXXXX**`
                    : `Please send the total amount to our official Nagad Merchant Number: **018XXXXXXXX**`;
                
                infoText.innerHTML = accountInfo;

            } else {
                fieldsDiv.classList.add('hidden');
                fieldsDiv.style.opacity = '0';
                // IMPORTANT: Remove required attribute for COD
                paymentNumberInput.required = false;
                transactionIdInput.required = false;
                paymentNumberInput.value = '';
                transactionIdInput.value = '';
            }
        }

        /**
         * Updates the Delivery Charge and Total Amount in the Order Summary section.
         */
        function updateSummary() {
            const selectedShippingRadio = document.querySelector('input[name="shipping"]:checked');
            const deliveryCharge = selectedShippingRadio ? parseInt(selectedShippingRadio.getAttribute('data-charge')) : 0;
            const totalAmount = PRODUCT_COST + deliveryCharge;

            document.getElementById('productCost').textContent = PRODUCT_COST;
            document.getElementById('deliveryCharge').textContent = deliveryCharge;
            document.getElementById('totalAmount').textContent = totalAmount;
        }

        /**
         * Collects form data and returns a structured object.
         * @returns {Object|null} The collected data or null if validation fails.
         */
        function getFormData() {
            const form = document.getElementById('checkoutForm');
            if (!form.checkValidity()) {
                form.reportValidity(); // Show browser validation errors
                return null;
            }

            const shippingRadio = document.querySelector('input[name="shipping"]:checked');
            const paymentRadio = document.querySelector('input[name="payment"]:checked');

            if (!shippingRadio || !paymentRadio) {
                showMessage("Please select both a Shipping Option and a Payment Method.", 'bg-yellow-100 text-yellow-700');
                return null;
            }

            const deliveryCharge = parseInt(shippingRadio.getAttribute('data-charge'));
            const totalAmount = PRODUCT_COST + deliveryCharge;
            const paymentMethod = paymentRadio.value;

            const data = {
                name: document.getElementById('name').value.trim(),
                email: document.getElementById('email').value.trim(),
                phone: document.getElementById('phone').value.trim(),
                address: document.getElementById('address').value.trim(),
                shippingOption: shippingRadio.value,
                deliveryCharge: deliveryCharge,
                productCost: PRODUCT_COST,
                totalAmount: totalAmount,
                paymentMethod: paymentMethod,
                // These are null/empty for COD, will be validated for digital payments
                paymentNumber: document.getElementById('paymentNumber').value.trim(),
                transactionId: document.getElementById('transactionId').value.trim(),
            };
            
            // Additional client-side validation for bKash/Nagad
            if ((paymentMethod === 'bKash' || paymentMethod === 'Nagad')) {
                if (!data.paymentNumber || data.paymentNumber.length !== 11 || !data.paymentNumber.startsWith('01')) {
                    showMessage("For " + paymentMethod + ", please enter a valid 11-digit sender number.", 'bg-red-100 text-red-700');
                    return null;
                }
                if (!data.transactionId || data.transactionId.length < 8) {
                    showMessage("For " + paymentMethod + ", please enter a valid Transaction ID (TrxID).", 'bg-red-100 text-red-700');
                    return null;
                }
            }
            
            return data;
        }

        /**
         * Handles form submission: validates, displays preview modal.
         * @param {Event} event 
         */
        function handleFormSubmit(event) {
            event.preventDefault();
            const data = getFormData();
            if (data) {
                showModal(data);
            }
        }

        /**
         * Displays the order preview modal with collected data.
         * @param {Object} data - The validated order data.
         */
        function showModal(data) {
            const modal = document.getElementById('previewModal');
            const content = document.getElementById('modalSummaryContent');
            
            let paymentDetails = '';
            if (data.paymentMethod !== 'Cash on Delivery') {
                paymentDetails = `
                    <p><span class="font-semibold text-indigo-600">${data.paymentMethod} Details:</span></p>
                    <div class="ml-2">
                        <p class="text-gray-600">Sender No: <span class="font-mono text-gray-800">${data.paymentNumber}</span></p>
                        <p class="text-gray-600">Trx ID: <span class="font-mono text-gray-800">${data.transactionId}</span></p>
                    </div>
                `;
            }

            content.innerHTML = `
                <div class="border-b pb-2">
                    <p class="text-gray-600"><span class="font-semibold text-gray-800">Name:</span> ${data.name}</p>
                    <p class="text-gray-600"><span class="font-semibold text-gray-800">Email:</span> ${data.email}</p>
                    <p class="text-gray-600"><span class="font-semibold text-gray-800">Phone:</span> ${data.phone}</p>
                    <p class="text-gray-600"><span class="font-semibold text-gray-800">Address:</span> ${data.address}</p>
                    <p class="text-gray-600"><span class="font-semibold text-gray-800">Shipping:</span> ${data.shippingOption} (৳${data.deliveryCharge})</p>
                </div>
                
                <div class="border-b py-2">
                    <p class="text-gray-600"><span class="font-semibold text-gray-800">Payment:</span> ${data.paymentMethod}</p>
                    ${paymentDetails}
                </div>
                
                <div class="pt-2 text-lg font-bold flex justify-between">
                    <span class="text-gray-800">TOTAL PAYABLE:</span>
                    <span class="text-indigo-600">৳ ${data.totalAmount}</span>
                </div>
            `;
            
            modal.classList.remove('hidden', 'opacity-0');
            modal.classList.add('flex');
            // Animate scale in
            setTimeout(() => {
                modal.querySelector('div').classList.remove('scale-95');
                modal.classList.remove('opacity-0');
            }, 10);

            // Store data globally for placeOrder
            window.finalOrderData = data;
            // Sync hidden inputs
            document.getElementById('shippingInput').value = data.shippingOption;
            document.getElementById('paymentInput').value = data.paymentMethod;
            // Sync optional payment fields
            const num = document.getElementById('paymentNumber');
            const trx = document.getElementById('transactionId');
            // Create hidden inputs if not present
            if (!document.getElementById('paymentNumberInput')) {
                const i = document.createElement('input'); i.type = 'hidden'; i.name = 'paymentNumber'; i.id = 'paymentNumberInput';
                document.getElementById('checkoutForm').appendChild(i);
            }
            if (!document.getElementById('transactionIdInput')) {
                const i = document.createElement('input'); i.type = 'hidden'; i.name = 'transactionId'; i.id = 'transactionIdInput';
                document.getElementById('checkoutForm').appendChild(i);
            }
            document.getElementById('paymentNumberInput').value = num ? num.value.trim() : '';
            document.getElementById('transactionIdInput').value = trx ? trx.value.trim() : '';
        }

        /**
         * Closes the order preview modal.
         */
        function closeModal() {
            const modal = document.getElementById('previewModal');
            modal.querySelector('div').classList.add('scale-95');
            modal.classList.add('opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
        }

        /**
         * Displays temporary feedback message in the message box.
         * @param {string} message - The message to display.
         * @param {string} className - Tailwind classes for styling (e.g., 'bg-green-100 text-green-700').
         */
        function showMessage(message, className) {
            const box = document.getElementById('messageBox');
            box.className = `mt-4 p-3 rounded-lg text-sm block ${className}`;
            box.textContent = message;
            box.classList.remove('hidden');
            setTimeout(() => {
                box.classList.add('hidden');
            }, 5000);
        }

        /**
         * Places the order by saving data to Firestore.
         */
        async function placeOrder() {
            if (!window.finalOrderData) {
                showMessage("Order data missing. Please fill the form and try again.", 'bg-red-100 text-red-700');
                closeModal();
                return;
            }
            // Fill any missing fields (name/email/address already bound to form inputs)
            document.getElementById('checkoutForm').submit();
        }
    </script>
</body>
</html>
