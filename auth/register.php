<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/session.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/db.php';

$message = "";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data and trim whitespace
    $fname = trim($_POST['fname'] ?? '');
    $lname = trim($_POST['lname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Validate input
    if ($fname && $lname && $email && $password) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $message = "Invalid email format.";
        } else {
            // Prepare and execute the SQL statement to check if the email already exists
            $stmt = $connection->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $message = "Email already exists. Please choose a different email.";
            } else {
                // Email does not exist, proceed with registration
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $connection->prepare("INSERT INTO users (fname, lname, email, password,registerd_date) VALUES (?, ?, ?, ?, NOW())");
                $stmt->bind_param("ssss", $fname, $lname, $email, $password);
                if ($stmt->execute()) {
                    //$message = "Registration successful! You can now log in.";
                    header("Location: /Projects/AuraEdition/auth/login.php?registered=1");
                    exit;
                } else {
                    $message = "Registration failed. Please try again.";
                }
            }
            $stmt->close();
        }
    } else {
        $message = "Please fill in all fields.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuraEdition | Register</title>

    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/header.php'; ?>

<body>

    <div class="relative w-full h-screen">
        <img src="/Projects/AuraEdition/assets/images/sign.jpg" class="w-full h-screen object-cover" alt="Sign Image">
        <div class="absolute inset-0 flex justify-center items-center">
            <div class="w-full max-w-md">
                <div class="bg-black/40 backdrop-blur shadow-md rounded px-8 pt-6 pb-8 mb-4">
                    <h2 class="text-2xl font-bold mb-4 text-white">Register</h2>

                    <!-- Display message-->
                    <?php if (!empty($message)): ?>
                    <div class="mb-4 text-center text-red-600 font-semibold bg-white/20 border border-red-500 rounded px-2 py-1">
                        <?= htmlspecialchars($message) ?>
                    </div>
                    <?php endif; ?>
                    <!-- Display message-->

                    <form action="/Projects/AuraEdition/auth/register.php" method="POST">
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div class="">
                                <label for="fname" class="block text-white text-sm font-bold mb-2">First Name</label>
                                <input type="fname" id="fname" name="fname" required
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-200 leading-tight focus:outline-none focus:shadow-outline">
                            </div>
                            <div class="">
                                <label for="lname" class="block text-white text-sm font-bold mb-2">Last Name</label>
                                <input type="lname" id="lname" name="lname" required
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-200 leading-tight focus:outline-none focus:shadow-outline">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="email" class="block text-white text-sm font-bold mb-2">Email</label>
                            <input type="email" id="email" name="email" required
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-200 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        <div class="mb-2">
                            <label for="password" class="block text-white text-sm font-bold mb-2">Password</label>
                            <input type="password" id="password" name="password" required
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-200 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        <div class="flex flex-col gap-3">
                            <button type="submit"
                                class="bg-blue-500 mt-4 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Register
                            </button>
                            <a href="/Projects/AuraEdition/auth/login.php"
                                class="w-full">
                                <button type="button"
                                    class="w-full bg-gray-100 hover:bg-blue-100 text-blue-700 font-bold py-2 px-4 rounded border border-blue-500 focus:outline-none focus:shadow-outline">
                                    Login
                                </button>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js
"></script>
    <script src="/Projects/AuraEdition/assets/js/script.js"></script>

</body>

</html>