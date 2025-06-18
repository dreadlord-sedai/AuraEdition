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
    <div class=" flex container-md my-5 main-content justify-content-center ">
        <!-- Invoice -->
        <div class="w-2/3 p-6">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <!-- Header with gray background -->
                <div class="bg-gray-800 text-white p-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h1 class="text-2xl font-bold">INVOICE</h1>
                            <p class="text-gray-300 text-sm mt-1">Order #1234567890</p>
                        </div>
                        <div class="text-right text-sm">
                            <p class="text-gray-300">Date Issued</p>
                            <p class="font-semibold">July 26, 2024</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <!-- Customer & Shipping Info -->
                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <div>
                            <h2 class="text-gray-600 text-sm uppercase tracking-wider mb-2">Bill To</h2>
                            <div class="text-sm">
                                <p class="font-semibold">Sophia Carter</p>
                                <p class="text-gray-600">123 Maple Street</p>
                                <p class="text-gray-600">Anytown, CA 91234</p>
                                <p class="text-gray-600 mt-2">sophia.carter@email.com</p>
                                <p class="text-gray-600">(555) 123-4567</p>
                            </div>
                        </div>
                        <div>
                            <h2 class="text-gray-600 text-sm uppercase tracking-wider mb-2">Ship To</h2>
                            <div class="text-sm">
                                <p class="font-semibold">Sophia Carter</p>
                                <p class="text-gray-600">123 Maple Street</p>
                                <p class="text-gray-600">Anytown, CA 91234</p>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="mb-6">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="px-4 py-2 text-left text-gray-600">Item</th>
                                    <th class="px-4 py-2 text-left text-gray-600">Quantity</th>
                                    <th class="px-4 py-2 text-right text-gray-600">Price</th>
                                    <th class="px-4 py-2 text-right text-gray-600">Total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <tr>
                                    <td class="px-4 py-3">Product A</td>
                                    <td class="px-4 py-3">1</td>
                                    <td class="px-4 py-3 text-right">$29.99</td>
                                    <td class="px-4 py-3 text-right">$29.99</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Totals -->
                    <div class="border-t border-gray-200 pt-4">
                        <div class="flex justify-end">
                            <div class="w-64">
                                <div class="flex justify-between text-sm mb-2">
                                    <span class="text-gray-600">Subtotal</span>
                                    <span>$79.96</span>
                                </div>
                                <div class="flex justify-between text-sm mb-2">
                                    <span class="text-gray-600">Shipping</span>
                                    <span>$5.00</span>
                                </div>
                                <div class="flex justify-between text-sm mb-2">
                                    <span class="text-gray-600">Discount</span>
                                    <span class="text-red-600">-$10.00</span>
                                </div>
                                <div class="flex justify-between font-bold text-lg border-t border-gray-200 pt-2">
                                    <span>Total</span>
                                    <span>$74.96</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Info -->
                    <div class="border-t border-gray-200 mt-6 pt-6">
                        <div class="flex justify-between items-center text-sm">
                            <div>
                                <p class="text-gray-600 uppercase tracking-wider mb-1">Payment Method</p>
                                <p class="font-semibold">Credit Card ending in 1234</p>
                            </div>
                            <div class="text-right">
                                <p class="text-gray-600 uppercase tracking-wider mb-1">Payment Status</p>
                                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Paid</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>>
        <!-- Invoice -->

    </div>
    <!-- Main Content -->


    <!-- Scripts -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js
"></script>
    <script src="/Projects/AuraEdition/assets/js/script.js"></script>

</body>

</html>