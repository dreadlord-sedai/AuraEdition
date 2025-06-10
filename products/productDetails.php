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

        <!-- Product Details Section -->

        <!--- Product Image Section -->
        <div class="flex gap-2 justify-center">
            <!-- Main Product Image (left, fixed size) -->
            <div class="flex items-center justify-center">
                <div class="aspect-square w-[420px] bg-white/10 rounded-lg shadow-lg flex items-center justify-center">
                    <img src="/Projects/AuraEdition/products/img/product1.jpg" alt="Main Product" class="object-cover w-full h-full rounded-lg" />
                </div>
            </div>
            <!-- Image Grid (right, 2x2, each image half the main image size) -->
            <div class="grid grid-cols-2 grid-rows-2 gap-2">
                <div class="aspect-square w-[200px] bg-white/10 rounded-lg shadow-lg flex items-center justify-center">
                    <img src="/Projects/AuraEdition/products/img/product1.jpg" alt="Grid 1" class="object-cover w-full h-full rounded-lg" />
                </div>
                <div class="aspect-square w-[200px] bg-white/10 rounded-lg shadow-lg flex items-center justify-center">
                    <img src="/Projects/AuraEdition/products/img/product1.jpg" alt="Grid 2" class="object-cover w-full h-full rounded-lg" />
                </div>
                <div class="aspect-square w-[200px] bg-white/10 rounded-lg shadow-lg flex items-center justify-center">
                    <img src="/Projects/AuraEdition/products/img/product1.jpg" alt="Grid 3" class="object-cover w-full h-full rounded-lg" />
                </div>
                <div class="aspect-square w-[200px] bg-white/10 rounded-lg shadow-lg flex items-center justify-center">
                    <img src="/Projects/AuraEdition/products/img/product1.jpg" alt="Grid 4" class="object-cover w-full h-full rounded-lg" />
                </div>
            </div>
        </div>



        

        <!-- Product Details Section -->



    </div>


    <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/Projects/AuraEdition/includes/footer.php"; ?>