<?php
session_start();
include '../php/db.php';

// Check if unique_id is set and redirect if not
if (empty($_SESSION['unique_id'])) {
    header("Location: ../login_page.html");
    exit(); // Don't forget to call exit() after header redirection
}

$unique_id = $_SESSION['unique_id'];

// Fetch user details
$qry = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = '{$unique_id}'");
if (!$qry) {
    die("DB Error: " . mysqli_error($conn));
}

if (mysqli_num_rows($qry) > 0) {
    $row = mysqli_fetch_assoc($qry);
    $first_name = $row['fname'];
    $phone = $row['phone'];
    $role = $row['Role'];
    $_SESSION['Role'] = $role;

    // Redirect if not verified
    if ($row['verification_status'] != 'Verified') {
        header("Location: verify.html");
        exit();
    }
} else {
    // Handle no user found
    header("Location: ../login_page.html");
    exit();
}

// Define functions before using them
function truncateText($text, $maxWords)
{
    $wordArray = explode(' ', $text);
    if (count($wordArray) > $maxWords) {
        $wordArray = array_slice($wordArray, 0, $maxWords);
        $text = implode(' ', $wordArray) . '...';
    }
    return $text;
}

function countTasksByStatus($tasks, $status)
{
    return count(array_filter($tasks, function ($task) use ($status) {
        return $task['status'] === $status;
    }));
}

// Fetch tasks
$taskQuery = "SELECT * FROM tasks WHERE (SELECT id FROM users WHERE unique_id = '{$unique_id}') = assigned_to";
$taskResult = $conn->query($taskQuery);
if (!$taskResult) {
    die("DB Error: " . mysqli_error($conn));
}

$tasks = [];
while ($taskRow = $taskResult->fetch_assoc()) {
    $tasks[] = $taskRow;
}

$acceptedTasksCount = countTasksByStatus($tasks, 'accepted');
$rejectedTasksCount = countTasksByStatus($tasks, 'rejected');
$completedTasksCount = countTasksByStatus($tasks, 'completed');
$totalTasksCount = count($tasks);

// Check if the user has completed their profile
$stmt = $conn->prepare("SELECT * FROM user_data WHERE user_id = (SELECT id FROM users WHERE unique_id = ?)");
$stmt->bind_param("s", $unique_id);
$stmt->execute();
$result = $stmt->get_result();
$profile_completed = $result->num_rows > 0;
$stmt->close();

// Check if user profile status is 'null', 'pending', 'approved', or 'rejected'
if ($profile_completed) {
    $userData = $result->fetch_assoc();
    $profileStatus = $userData['status'];
} else {
    $profileStatus = 'null';
}

?>

<!DOCTYPE html>
<html lang="en" class="light-theme">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Dashboard</title>
    <!-- Combine Google Fonts links -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.3/dist/tailwind.min.css">
</head>

<body class="bg-white font-poppins min-h-[100%] text-black">
    <div class="pb-10">
        <!-- Responsive Navbar -->
        <nav class="bg-white border-gray-200 dark:bg-gray-900">
            <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
                <!-- Logo and Welcome Message -->
                <a href="#" class="flex hover:no-underline items-center space-x-3 rtl:space-x-reverse">
                    <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Welcome,
                        <?php echo $first_name; ?></span>
                </a>
                <!-- Mobile menu button -->
                <button onclick="toggleMenu()" type="button"
                    class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                    aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 6h18M3 12h18M3 18h18" />
                    </svg>
                </button>
                <!-- Menu items -->
                <div class="hidden w-full md:block md:w-auto" id="navbar">
                    <ul
                        class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                        <li>
                            <a href="../homepage.php"
                                class=" hover:no-underline block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Home</a>
                        </li>
                        <li>
                            <a href="#"
                                class=" hover:no-underline block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Pricing</a>
                        </li>


                        <li>
                            <a href="user_profile.php"
                                class=" hover:no-underline block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Profile</a>
                        </li>
                        <li>
                            <a href="../php/logout.php"
                                class=" hover:no-underline block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container mx-auto p-4">
            <?php
            // Display profile status
            if ($profileStatus === 'pending') {
                echo "<div class='bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-4 mb-4 rounded relative'
                    role='alert'>
                    <strong class='font-bold'>Attention!</strong>
                    <span class='block sm:inline'>Your profile is pending approval. You will receive an email notification
                        once it's approved.</span>
                </div>";
            } elseif ($profileStatus === 'null') {
                echo "<div class='bg-red-100 border border-red-400 text-red-700 px-4 py-4 mb-4 rounded relative'
                    role='alert'>
                    <strong class='font-bold'>Attention!</strong>
                    <span class='block sm:inline'>You need to complete your profile to receive jobs.</span>
                    <a href='user_profile.php' class='absolute top-0 bottom-0 right-0 px-4 py-3'>Complete Profile</a>
                </div>";
            } elseif ($profileStatus === 'rejected') {
                echo "<div class='bg-red-100 border border-red-400 text-red-700 px-4 py-4 mb-4 rounded relative'
                    role='alert'>
                    <strong class='font-bold'>Attention!</strong>
                    <span class='block sm:inline'>Your profile has been rejected. Please review the provided information and
                        update your profile accordingly.</span>
                </div>";
            } elseif ($profileStatus === 'approved') {
                echo "<div class='bg-green-100 border border-green-400 text-green-700 px-4 py-4 mb-4 rounded relative'
                    role='alert'>
                    <strong class='font-bold'>Congratulations!</strong>
                    <span class='block sm:inline'>Your profile has been approved.</span>
                </div>";
            }

            ?>
            <h1 class="text-3xl font-semibold mb-6">My Tasks</h1>

            <!-- Dashboard counters -->
            <div class="justify-between mb-4 grid grid-cols-2 gap-4">
                <div class="p-4 bg-blue-200 rounded">
                    <h2 class="font-bold">Accepted Jobs</h2>
                    <p>
                        <?php echo $acceptedTasksCount; ?>
                    </p>
                </div>
                <div class="p-4 bg-red-200 rounded">
                    <h2 class="font-bold">Rejected Jobs</h2>
                    <p>
                        <?php echo $rejectedTasksCount; ?>
                    </p>
                </div>
                <div class="p-4 bg-green-200 rounded">
                    <h2 class="font-bold">Completed Jobs</h2>
                    <p>
                        <?php echo $completedTasksCount; ?>
                    </p>
                </div>
                <div class="p-4 bg-gray-200 rounded">
                    <h2 class="font-bold">Total Jobs</h2>
                    <p>
                        <?php echo $totalTasksCount; ?>
                    </p>
                </div>
            </div>
            <hr class="h-0.5 bg-purple-700">

            <h2 class="text-xl font-semibold my-4">Available Jobs:</h2>

            <!-- Task list -->
            <div class="space-y-4 py-16">
                <?php if (empty($tasks)): ?>
                    <div class="text-center text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 mx-auto mb-4" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 2a8 8 0 00-8 8c0 3.38 2.464 6.197 5.678 6.788.233.885.928 1.571 1.769 1.791C8.443 19.094 9.213 20 10 20s1.557-.906 2.553-1.421c.841-.22 1.536-.906 1.769-1.791C17.536 16.197 20 13.38 20 10a8 8 0 00-8-8zM8 11a1 1 0 11-2 0 1 1 0 012 0zm2 0a1 1 0 11-2 0 1 1 0 012 0zm4 0a1 1 0 11-2 0 1 1 0 012 0z"
                                clip-rule="evenodd" />
                        </svg>
                        <p>No tasks available</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($tasks as $task): ?>
                        <div
                            class="bg-purple-700 flex flex-col md:flex-row justify-between align-middle p-4 rounded-lg shadow-md text-white space-y-2 md:space-y-0 md:space-x-4">

                            <span class="px-3 py-2 rounded self-start md:self-center
            <?php
            // Check the status and set the background color accordingly
            switch ($task['status']) {
                case 'completed':
                    echo 'bg-green-500 text-white'; // Green background for completed tasks
                    break;
                case 'accepted':
                    echo 'bg-blue-500 text-white'; // Blue background for accepted tasks
                    break;
                case 'rejected':
                    echo 'bg-red-500 text-white'; // Red background for rejected tasks
                    break;
                default:
                    echo 'bg-gray-500'; // Light gray background for pending tasks
                    break;
            }
            ?>
        ">
                                <?php echo $task['status']; ?>
                            </span>

                            <h3 class="text-xl truncate font-semibold">
                                <?php echo " {$task['name']}"; ?>
                            </h3>

                            <p class="truncate">
                                <?php
                                $maxWords = 10;
                                echo truncateText($task['info'], $maxWords);
                                ?>
                            </p>

                            <p class=""><strong>Amount:</strong> $
                                <?php

                                echo $task['amount']; ?>
                            </p>

                            <div class="flex justify-end">
                                <a href="task_details.php?task_id=<?php echo $task['id']; ?>"
                                    class="bg-white text-black py-2 px-4 rounded">View Job</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script>
        function toggleMenu() {
            const navbar = document.getElementById('navbar');
            navbar.classList.toggle('hidden');
        }
    </script>
</body>

</html>