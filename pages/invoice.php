<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuraEdition | Checkout</title>

    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/header.php'; ?>

<body>

    <!-- Navigation Bar -- -->
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/navbar.php'; ?>
    <!-- Navigation Bar -->


    <!-- Main Content -->
    <div class="container-md my-5 main-content">
        <!-- Invoice -->
        <div class="bg-white shadow-lg rounded-lg p-6"> <!-- Reduced padding from p-8 -->
            <!-- Invoice Header -->
            <div class="mb-4"> <!-- Reduced margin from mb-8 -->
                <h1 class="text-2xl font-bold mb-2">INVOICE</h1> <!-- Reduced from text-3xl -->
                <div class="text-sm text-gray-600"> <!-- Added text-sm -->
                    <p>Order #1234567890</p>
                    <p>Placed on July 26, 2024</p>
                </div>
            </div>

            <!-- Customer Information -->
            <div class="mb-4 text-sm"> <!-- Added text-sm, reduced margin -->
                <h2 class="text-lg font-semibold mb-2">Customer Information</h2>
                <div class="grid grid-cols-2 gap-4"> <!-- Reduced gap -->
                    <div>
                        <p class="text-gray-600">Customer Name</p>
                        <p class="font-medium">Sophia Carter</p>
                        <p class="text-gray-600 mt-1">Email</p>
                        <p>sophia.carter@email.com</p>
                        <p class="text-gray-600 mt-1">Phone</p>
                        <p>(555) 123-4567</p>
                    </div>
                </div>
            </div>

            <!-- Billing & Shipping -->
            <div class="grid grid-cols-2 gap-4 mb-4 text-sm"> <!-- Added text-sm -->
                <div>
                    <h2 class="text-lg font-semibold mb-2">Billing Address</h2>
                    <p>123 Maple Street</p>
                    <p>Anytown, CA 91234</p>
                </div>
                <div>
                    <h2 class="text-lg font-semibold mb-2">Shipping Address</h2>
                    <p>123 Maple Street</p>
                    <p>Anytown, CA 91234</p>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="mb-4 text-sm"> <!-- Added text-sm -->
                <h2 class="text-lg font-semibold mb-2">Order Summary</h2>
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="text-left py-1">Item</th>
                            <th class="text-left py-1">Quantity</th>
                            <th class="text-left py-1">Price</th>
                            <th class="text-right py-1">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b border-gray-100">
                            <td class="py-2">Product A</td>
                            <td>1</td>
                            <td>$29.99</td>
                            <td class="text-right">$29.99</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Order Totals -->
            <div class="flex justify-end text-sm"> <!-- Added text-sm -->
                <div class="w-48"> <!-- Reduced from w-64 -->
                    <div class="flex justify-between mb-1">
                        <span>Subtotal</span>
                        <span>$79.96</span>
                    </div>
                    <div class="flex justify-between mb-1">
                        <span>Shipping</span>
                        <span>$5.00</span>
                    </div>
                    <div class="flex justify-between mb-1">
                        <span>Discount</span>
                        <span>-$10.00</span>
                    </div>
                    <div class="flex justify-between font-bold border-t border-gray-200 pt-1">
                        <span>Total</span>
                        <span>$74.96</span>
                    </div>
                </div>
            </div>

            <!-- Payment Method -->
            <div class="mt-4 text-sm"> <!-- Added text-sm -->
                <h2 class="text-lg font-semibold mb-2">Payment Method</h2>
                <div class="flex gap-4">
                    <div>
                        <p class="text-gray-600">Method</p>
                        <p>Credit Card</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Card Number</p>
                        <p>************1234</p>
                    </div>
                </div>
            </div>
        </div>






    </div>
    <!-- Main Content -->


    <!-- Scripts -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js
"></script>
    <script src="/Projects/AuraEdition/assets/js/script.js"></script>

</body>

</html>