<?php 
require_once 'db.php'; 
session_start();

// Redirect to login if not authenticated
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// 1. Fetch PERSONAL Stats
$myStats = $pdo->prepare("SELECT SUM(detected_amount) as my_total FROM payments WHERE user_id = ? AND status = 'verified'");
$myStats->execute([$user_id]);
$myTotal = $myStats->fetch()['my_total'] ?? 0;

// 2. Fetch COMMUNITY Stats
$communityStats = $pdo->query("SELECT SUM(detected_amount) as grand_total FROM payments WHERE status = 'verified'")->fetch();

// 3. Handle Messages (Success/Error)
$msg = $_GET['msg'] ?? null;
$error = $_GET['error'] ?? null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChamaHub Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-slate-50">

    <nav class="bg-white p-6 border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-6xl mx-auto flex justify-between items-center">
            <span class="font-bold text-rose-500 text-xl tracking-tighter">CHAMAHUB</span>
            <div class="flex items-center gap-4">
                <div class="text-right hidden sm:block">
                    <p class="text-[10px] font-bold text-slate-400 uppercase">Member ID</p>
                    <p class="text-sm font-bold text-slate-700"><?php echo $_SESSION['member_number']; ?></p>
                </div>
                <a href="logout.php" class="text-xs bg-slate-100 px-3 py-2 rounded-lg font-bold text-slate-500 hover:bg-rose-50 hover:text-rose-500 transition">LOGOUT</a>
            </div>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto p-6">
        
        <?php if($msg): ?>
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-6 py-4 rounded-2xl mb-8 font-medium">
                ✅ <?php echo htmlspecialchars($msg); ?>
            </div>
        <?php endif; ?>
        <?php if($error): ?>
            <div class="bg-rose-50 border border-rose-200 text-rose-700 px-6 py-4 rounded-2xl mb-8 font-medium">
                ⚠️ <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <div class="grid md:grid-cols-2 gap-6 mb-12">
            <div class="bg-white p-8 rounded-[2rem] border-2 border-rose-100 shadow-sm relative overflow-hidden">
                <p class="text-xs font-bold text-rose-400 uppercase tracking-widest mb-2 relative z-10">My Total Savings</p>
                <p class="text-4xl font-black text-slate-800 relative z-10">Ksh <?php echo number_format($myTotal); ?></p>
                <div class="mt-4 h-2 bg-slate-100 rounded-full relative z-10">
                    <div class="bg-rose-500 h-2 rounded-full transition-all duration-1000" style="width: 45%"></div>
                </div>
                <div class="absolute -right-4 -bottom-4 text-rose-50 opacity-50">
                    <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                </div>
            </div>

            <div class="bg-slate-900 p-8 rounded-[2rem] text-white shadow-xl shadow-slate-200">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Community Growth</p>
                <p class="text-4xl font-black text-rose-400">Ksh <?php echo number_format($communityStats['grand_total']); ?></p>
                <p class="text-slate-400 text-xs mt-4">Transparent collective power of the Women's Chama.</p>
            </div>
        </div>

        <div class="grid lg:grid-cols-3 gap-8">
            <div class="lg:col-span-1">
                <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
                    <h3 class="font-bold text-slate-800 mb-6 flex items-center">
                        <span class="bg-rose-100 text-rose-500 p-2 rounded-lg mr-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        </span>
                        New Contribution
                    </h3>
                    
                    <form action="submit_payment.php" method="POST" enctype="multipart/form-data" class="space-y-5">
                        <div class="relative">
                            <input type="file" name="screenshot" id="sc" class="hidden" required onchange="updateFileName(this)">
                            <label for="sc" class="flex flex-col items-center justify-center bg-slate-50 border-2 border-dashed border-slate-200 p-8 rounded-2xl cursor-pointer hover:border-rose-400 transition group">
                                <svg class="w-8 h-8 text-slate-300 group-hover:text-rose-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                <span id="file-label" class="text-xs font-semibold text-slate-500">Upload Receipt Screenshot</span>
                            </label>
                        </div>

                        <div>
                            <label class="text-[10px] font-bold text-slate-400 uppercase ml-2 tracking-wider">Amount Paid (Ksh)</label>
                            <input type="number" name="manual_amount" placeholder="e.g. 20" required
                                class="w-full p-4 mt-1 bg-slate-50 border border-slate-100 rounded-2xl focus:border-rose-400 focus:bg-white outline-none transition font-bold text-slate-700">
                        </div>

                        <button type="submit" class="w-full bg-rose-500 text-white py-4 rounded-2xl font-bold shadow-lg shadow-rose-200 hover:bg-rose-600 transition active:scale-95">
                            Verify & Save
                        </button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                        <h3 class="font-bold text-slate-800 text-xs uppercase tracking-widest">My Recent Activity</h3>
                        <span class="text-[10px] font-bold text-slate-400 tracking-tighter">LAST 5 ENTRIES</span>
                    </div>
                    
                    <div class="divide-y divide-slate-100">
                        <?php
                        $myFeed = $pdo->prepare("SELECT * FROM payments WHERE user_id = ? ORDER BY payment_date DESC LIMIT 5");
                        $myFeed->execute([$user_id]);
                        $rows = $myFeed->fetchAll();

                        if (count($rows) > 0):
                            foreach($rows as $pay):
                                $status = $pay['status'];
                                $statusStyle = "text-amber-600 bg-amber-50";
                                if($status == 'verified') $statusStyle = "text-emerald-600 bg-emerald-50";
                                if($status == 'flagged') $statusStyle = "text-rose-600 bg-rose-50";
                        ?>
                        <div class="p-6 flex justify-between items-center hover:bg-slate-50 transition">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                </div>
                                <div>
                                    <p class="font-bold text-slate-800 text-lg">Ksh <?php echo number_format($pay['detected_amount']); ?></p>
                                    <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-tight"><?php echo date('M d, Y | H:i', strtotime($pay['payment_date'])); ?></p>
                                </div>
                            </div>
                            <span class="text-[10px] font-black px-4 py-1.5 rounded-full uppercase tracking-widest <?php echo $statusStyle; ?>">
                                <?php echo $status; ?>
                            </span>
                        </div>
                        <?php endforeach; else: ?>
                            <div class="p-12 text-center text-slate-400 italic text-sm">No contributions yet. Start saving today!</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        function updateFileName(input) {
            const label = document.getElementById('file-label');
            if (input.files && input.files[0]) {
                label.innerText = "Selected: " + input.files[0].name;
                label.classList.add('text-rose-500');
            }
        }
    </script>
</body>
</html>