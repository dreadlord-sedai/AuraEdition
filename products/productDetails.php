<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuraEdition | Contact</title>

    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/header.php'; ?>

<body>

    <!-- Navigation Bar -- -->
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/navbar.php'; ?>
    <!-- Navigation Bar -->

    <div class="container-md my-5 main-content">

        <div>

            <!--- Product Image Section -->
            <div class="flex gap-6 justify-center">
                <!-- Main Product Image (left, takes half width) -->
                <div class="w-1/2 flex items-center justify-center">
                    <div class="aspect-square w-full bg-white/10 rounded-lg shadow-lg flex items-center justify-center">
                        <img src="/Projects/AuraEdition/products/img/product1.jpg" alt="Main Product" class="object-cover w-full h-full rounded-lg" />
                    </div>
                </div>
                <!-- Image Grid (right, 2x2, takes half width) -->
                <div class="w-1/2 grid grid-cols-2 grid-rows-2 gap-4">
                    <div class="aspect-square bg-white/10 rounded-lg shadow-lg flex items-center justify-center">
                        <img src="/Projects/AuraEdition/products/img/product1.jpg" alt="Grid 1" class="object-cover w-full h-full rounded-lg" />
                    </div>
                    <div class="aspect-square bg-white/10 rounded-lg shadow-lg flex items-center justify-center">
                        <img src="/Projects/AuraEdition/products/img/product1.jpg" alt="Grid 2" class="object-cover w-full h-full rounded-lg" />
                    </div>
                    <div class="aspect-square bg-white/10 rounded-lg shadow-lg flex items-center justify-center">
                        <img src="/Projects/AuraEdition/products/img/product1.jpg" alt="Grid 3" class="object-cover w-full h-full rounded-lg" />
                    </div>
                    <div class="aspect-square bg-white/10 rounded-lg shadow-lg flex items-center justify-center">
                        <img src="/Projects/AuraEdition/products/img/product1.jpg" alt="Grid 4" class="object-cover w-full h-full rounded-lg" />
                    </div>
                </div>
            </div>

            <hr>
            <!-- Product Details -->
            <div class="flex flex-row justify-between items-center mt-4 mb-20 p-4">

                <div class="flex flex-col gap-4 w-2/3 text-center justify-center items-start p-2">
                    <div class="flex flex-row gap-14 justify-start items-center">
                        <h2 class="text-2xl font-bold ">2023 Mustang GT</h2>
                        <h3 class="text-gray-500 ">$250,000</h3>
                    </div>

                    <p class="text-gray-600 text-start">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>

                </div>

                <!-- Action Buttons Section -->
                <div class="flex flex-col gap-4 w-1/3  text-center justify-center items-center p-2">
                    <div class="CTA-card flex flex-col gap-4 justify-center items-center p-2
                        bg-white/10 rounded-lg shadow-lg w-64 h-72">
                        <a href="">
                        <button class="btn btn-primary d-flex justify-content-center align-items-center">
                            Buy Now
                        </button>
                    </a>
                     <a href="">
                        <button class="btn btn-primary d-flex justify-content-center align-items-center">
                            Add to cart
                        </button>
                    </a>

                    <div class="flex flex-row gap-2 justify-center items-center">
                        <label for="quantity" class="text-gray-600">Quantity:</label>
                        <select name="quantity" id="">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                        </select>
                    </div>
                    </div>
                </div>

            </div>

        </div>

        <hr>
        <!-- Product Details Section -->



    </div>


    <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/Projects/AuraEdition/includes/footer.php"; ?>