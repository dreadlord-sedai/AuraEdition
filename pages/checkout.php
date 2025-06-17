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

        <!-- Checkout  -->
        <div class="flex flex-row gap-3 justify-between rounded-lg items-stretch bg-gray-500 p-4 mb-5">


            <!-- Checkout Card -->
            <div class="flex flex-col w-3/5 gap-3 justify-content-center rounded-lg align-items-start bg-gray-200 p-5">
                <h4>Checkout</h4>

                <!-- Item Card -->
                <div class="flex flex-row gap-3 justify-content-center rounded-md align-items-start bg-gray-400 p-4">

                    <div class="justify-content-center rounded-sm ">
                        <img src="/Projects/AuraEdition/assets/images/checkout1.jpg" class="img-fluid object-fit-cover aspect-square w-24 " alt="">
                    </div>

                    <div class="flex flex-row gap-4">
                        <div class="w-3/4 mt-2 ">
                            <h5>2023 Lamborghini Huracan</h5>
                        </div>

                        <div class="flex flex-col w-1/4 justify-content-center align-items-center">
                            <div class="mb-2 mt-3">
                                <h5>$100</h5>
                            </div>

                            <div class="flex flex-row gap-2">
                                <button class="btn btn-primary">-</button>
                                <h5>1</h5>
                                <button class="btn btn-primary">+</button>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="flex flex-row gap-3 justify-content-center rounded-md align-items-start bg-gray-400 p-4">

                    <div class="justify-content-center rounded-sm ">
                        <img src="/Projects/AuraEdition/assets/images/checkout1.jpg" class="img-fluid object-fit-cover aspect-square w-24 " alt="">
                    </div>

                    <div class="flex flex-row gap-4">
                        <div class="w-3/4 mt-2 ">
                            <h5>2023 Lamborghini Huracan</h5>
                        </div>

                        <div class="flex flex-col w-1/4 justify-content-center align-items-center">
                            <div class="mb-2 mt-3">
                                <h5>$100</h5>
                            </div>

                            <div class="flex flex-row gap-2">
                                <button class="btn btn-primary">-</button>
                                <h5>1</h5>
                                <button class="btn btn-primary">+</button>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="flex flex-row gap-3 justify-content-center rounded-md align-items-start bg-gray-400 p-4">

                    <div class="justify-content-center rounded-sm ">
                        <img src="/Projects/AuraEdition/assets/images/checkout1.jpg" class="img-fluid object-fit-cover aspect-square w-24 " alt="">
                    </div>

                    <div class="flex flex-row gap-4">
                        <div class="w-3/4 mt-2 ">
                            <h5>2023 Lamborghini Huracan</h5>
                        </div>

                        <div class="flex flex-col w-1/4 justify-content-center align-items-center">
                            <div class="mb-2 mt-3">
                                <h5>$100</h5>
                            </div>

                            <div class="flex flex-row gap-2">
                                <button class="btn btn-primary">-</button>
                                <h5>1</h5>
                                <button class="btn btn-primary">+</button>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="flex flex-row gap-3 justify-content-center rounded-md align-items-start bg-gray-400 p-4">

                    <div class="justify-content-center rounded-sm ">
                        <img src="/Projects/AuraEdition/assets/images/checkout1.jpg" class="img-fluid object-fit-cover aspect-square w-24 " alt="">
                    </div>

                    <div class="flex flex-row gap-4">
                        <div class="w-3/4 mt-2 ">
                            <h5>2023 Lamborghini Huracan</h5>
                        </div>

                        <div class="flex flex-col w-1/4 justify-content-center align-items-center">
                            <div class="mb-2 mt-3">
                                <h5>$100</h5>
                            </div>

                            <div class="flex flex-row gap-2">
                                <button class="btn btn-primary">-</button>
                                <h5>1</h5>
                                <button class="btn btn-primary">+</button>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- Item Card -->

            </div>
            <!-- Checkout Card -->


            <!-- Payment Card -->
            <div class="flex flex-col w-2/5  justify-content-center rounded-lg align-items-center
             bg-gray-200 p-4">

                <div class="flex flex-col w-5/6 justify-content-center text-center mb-3 border-b-1 pb-2">
                    <p>Total Amount</p>
                    <h1 class="font-bold">$400</h1>
                </div>

                <div class="flex flex-col w-5/6 gap-2 justify-content-start text-start mb-3 border-b-1 pb-2">
                    <p class="font-bold">Order Summary</p>

                    <div class="flex flex-row gap-50 justify-content-center">
                        <div class="flex flex-col">
                            <p>Item 1</p>
                            <p>Item 2</p>
                            <p>Item 3</p>
                            <p>Item 4</p>
                        </div>

                        <div class="flex flex-col font-bold text-end">
                            <p>$100</p>
                            <p>$100</p>
                            <p>$100</p>
                            <p>$100</p>

                        </div>

                    </div>
                </div>

                <div class="flex flex-row w-5/6 gap-53 justify-content-start text-start mb-5 px-3 pb-2">
                    <p>Total</p>
                    <p class="font-bold text-end">$400</p>
                </div>

                <div class="flex flex-row w-5/6 justify-content-center text-center mb-5 pb-2">

                    <!-- Make the Pay button a long green button with Tailwind -->
                    <div class="flex flex-row gap-2 w-full px">
                        <button class="w-full bg-green-600 hover:bg-green-700 text-white font-bold
                         py-3 rounded-lg transition" type="submit" name="submit" value="Pay" onclick="pay();">
                            Pay
                        </button>
                    </div>
                </div>
            </div>
            <!-- Payment Card -->
        </div>
    </div>
    <!-- Main Content -->


    <!-- Scripts -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js
"></script>
    <script src="/Projects/AuraEdition/assets/js/script.js"></script>

</body>

</html>