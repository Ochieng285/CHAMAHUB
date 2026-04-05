<?php
require_once 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE phone_number = ?");
    $stmt->execute([$phone]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Store user info in the session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['member_number'] = $user['member_number'];
        $_SESSION['full_name'] = $user['full_name'];
        
        header("Location: index.php");
        exit();
    } else {
        $error = "Invalid phone number or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
    <title>Login | ChamaHub</title>
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen font-['Inter']">
    <div class="w-full max-w-md p-8">
        
        <div class="text-center mb-10">
            <h1 class="text-3xl font-black text-rose-500 tracking-tighter">CHAMAHUB</h1>
            <p class="text-slate-500 mt-2">Sign in to manage your contributions</p>
        </div>

        <form method="POST" class="bg-white p-8 rounded-[2rem] shadow-xl border border-slate-100 mb-8">
            <?php if(isset($error)): ?>
                <div class="bg-red-50 text-red-500 p-4 rounded-xl mb-6 text-sm text-center font-bold">
                    ⚠️ <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <?php if(isset($_GET['msg'])): ?>
                <div class="bg-emerald-50 text-emerald-600 p-4 rounded-xl mb-6 text-xs text-center font-bold uppercase tracking-widest">
                    <?php echo htmlspecialchars($_GET['msg']); ?>
                </div>
            <?php endif; ?>

            <div class="mb-4">
                <label class="text-xs font-bold text-slate-400 uppercase ml-2 tracking-widest">Phone Number</label>
                <input type="text" name="phone" placeholder="0712345678" class="w-full p-4 mt-1 bg-slate-50 border border-slate-100 rounded-2xl focus:border-rose-400 outline-none transition" required>
            </div>

            <div class="mb-8">
                <label class="text-xs font-bold text-slate-400 uppercase ml-2 tracking-widest">Password</label>
                <input type="password" name="password" placeholder="••••••••" class="w-full p-4 mt-1 bg-slate-50 border border-slate-100 rounded-2xl focus:border-rose-400 outline-none transition" required>
            </div>

            <button type="submit" class="w-full bg-slate-900 text-white py-4 rounded-2xl font-bold hover:bg-rose-600 transition shadow-lg active:scale-95">
                Sign In
            </button>
            
            <p class="text-center mt-6 text-sm text-slate-500">
                New member? <a href="register.php" class="text-rose-500 font-bold hover:underline">Register here</a>
            </p>
        </form>

        <div class="text-center">
            <a href="home.php" class="inline-flex items-center gap-2 text-slate-400 hover:text-rose-500 transition font-bold text-sm uppercase tracking-widest">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                Back to Home
            </a>
        </div>

    </div>
</body>
</html>