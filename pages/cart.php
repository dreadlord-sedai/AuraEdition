<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuraEdition | Cart</title>

    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/header.php'; ?>

<body>

    <!-- Navigation Bar -- -->
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/navbar.php'; ?>
    <!-- Navigation Bar -->


    <!-- Main Content -->
    <div class="container-md my-5 main-content">

        <div class="flex flex-col justify-content-center align-items-center">
            <!-- Cart Card -->
            <div class="flex flex-col w-75 flex-grow gap-3 justify-content-center rounded-lg align-items-center bg-gray-200 p-5">
                <h4>Checkout</h4>

                <!-- Item Card -->
                <div class="flex flex-row justify-between gap-3 items-center rounded-md bg-gray-400 p-4 w-full">
                    <div class="rounded-sm">
                        <img src="/Projects/AuraEdition/assets/images/checkout1.jpg" class="img-fluid object-fit-cover aspect-square w-40" alt="">
                    </div>

                    <div class="flex flex-col items-center">
                        <div class="">
                            <h5>2023 Lamborghini Huracan</h5>
                        </div>
                        <div class="mb-2">
                            <h5>$100</h5>
                        </div>

                        <div class="flex flex-row gap-2">
                            <button class="btn btn-primary">-</button>
                            <h5 class="mx-2">1</h5>
                            <button class="btn btn-primary">+</button>
                        </div>
                    </div>

                    <div class="flex flex-col items-center gap-2">
                        <button class="btn btn-outline-success">Buy Now</button>
                        <button class="btn btn-outline-danger">Remove</button>

                    </div>
                </div>
                <!-- Item Card -->

            </div>
            <!-- Cart Card -->
        </div>


    </div>
    <!-- Main Content -->


    <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/Projects/AuraEdition/includes/footer.php"; ?>