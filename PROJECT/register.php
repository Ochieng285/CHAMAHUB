<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['full_name'];
    $phone = $_POST['phone'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    // Generate Unique Number: CHM + random digits
    $member_number = "CHM-" . rand(1000, 9999);

    $stmt = $pdo->prepare("INSERT INTO users (member_number, full_name, phone_number, password) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$member_number, $name, $phone, $password])) {
        echo "<script>alert('Success! Your Member Number is: $member_number'); window.location='login.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head><script src="https://cdn.tailwindcss.com"></script></head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen">
    <form method="POST" class="bg-white p-8 rounded-3xl shadow-xl w-full max-w-md border border-slate-200">
        <h2 class="text-2xl font-bold text-slate-800 mb-6 text-center">Join the Chama</h2>
        <input type="text" name="full_name" placeholder="Full Name" class="w-full p-4 mb-4 bg-slate-50 border rounded-2xl" required>
        <input type="text" name="phone" placeholder="Phone Number (M-Pesa)" class="w-full p-4 mb-4 bg-slate-50 border rounded-2xl" required>
        <input type="password" name="password" placeholder="Create Password" class="w-full p-4 mb-6 bg-slate-50 border rounded-2xl" required>
        <button type="submit" class="w-full bg-rose-500 text-white py-4 rounded-2xl font-bold shadow-lg shadow-rose-200">Register & Get ID</button>
    </form>
</body>
</html>