<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/session.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/db.php';

$Error_message = "";
$Success_message = "";

// If redirected from registration, show a success message
if (isset($_GET['registered']) && $_GET['registered'] == 1) {
    $Success_message = "Registration successful! You can now log in.";
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';


    if ($email && $password) {
        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $Error_message = "Invalid email format.";
        } else {
            // Prepare a statement to select user by email
            $select_user_query = $connection->prepare(
                "SELECT id, fname, lname, email, hashed_password, role FROM users WHERE email = ?"
            );
            $select_user_query->bind_param("s", $email);
            $select_user_query->execute();
            $select_user_query->store_result();


            if ($select_user_query->num_rows > 0) {

                $select_user_query->bind_result($id, $fname, $lname, $db_email, $hashed_password, $role);
                $select_user_query->fetch();

                // Verify the password using password_verify
                if (password_verify($password, $hashed_password)) {
                    $_SESSION['user_id'] = $id;
                    $_SESSION['fname'] = $fname;
                    $_SESSION['lname'] = $lname;
                    $_SESSION['email'] = $db_email;
                    $_SESSION['role'] = $role;

                    $select_user_query->close();
                    // Redirect to the home page after successful login
                    header("Location: /Projects/AuraEdition/index.php");
                    exit;
                } else {
                    // Password is incorrect
                    $Error_message = "Incorrect password. Please try again.";
                }
            } else {
                // No user found with this email
                $Error_message = "Email not found. Please register first.";
            }
            $select_user_query->close();
        }
    } else {
        // One or both fields are empty
        $Error_message = "Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuraEdition | Login</title>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/header.php'; ?>
</head>

<body>
    <div class="relative w-full h-screen">
        <!-- Background image -->
        <img src="/Projects/AuraEdition/assets/images/sign.jpg" class="w-full h-screen object-cover" alt="Sign Image">

        <!-- Centered login card -->
        <div class="absolute inset-0 flex justify-center items-center">
            <div class="w-full max-w-md">
                <div class="bg-black/40 backdrop-blur shadow-md rounded px-8 pt-6 pb-8 mb-4">
                    <h2 class="text-2xl font-bold mb-4 text-white">Login</h2>

                    <!-- Display error message if any -->
                    <?php if (!empty($Error_message)): ?>
                        <div class="mb-4 text-center text-red-200 font-semibold bg-white/20 border border-red-500 rounded px-2 py-1">
                            <?= htmlspecialchars($Error_message) ?>
                        </div>
                    <?php endif; ?>

                    <!-- Display success message if any -->
                    <?php if (!empty($Success_message)): ?>
                        <div class="mb-4 text-center text-green-200 font-semibold bg-white/20 border border-green-500 rounded px-2 py-1">
                            <?= htmlspecialchars($Success_message) ?>
                        </div>
                    <?php endif; ?>

                    <!-- Login form -->
                    <form action="/Projects/AuraEdition/auth/login.php" method="POST">
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
                        <div class="mb-6 text-right">
                            <a href="/Projects/AuraEdition/auth/forgot_password.php"
                                class="text-blue-300 hover:text-blue-400 text-sm">Forgot your password?</a>
                        </div>
                        <div class="flex flex-col gap-3">
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Login
                            </button>
                            <a href="/Projects/AuraEdition/auth/register.php"
                                class="w-full">
                                <button type="button"
                                    class="w-full bg-gray-100 hover:bg-blue-100 text-blue-700 font-bold py-2 px-4 rounded border border-blue-500 focus:outline-none focus:shadow-outline">
                                    Register
                                </button>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/Projects/AuraEdition/assets/js/script.js"></script>
</body>

</html>