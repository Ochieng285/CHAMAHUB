<?php 
require_once 'db.php'; 
session_start();

// 1. Fetch PENDING payments for the Verification Queue
$stmtPending = $pdo->query("SELECT p.*, u.full_name, u.member_number 
                           FROM payments p 
                           JOIN users u ON p.user_id = u.id 
                           WHERE p.status = 'pending' 
                           ORDER BY p.payment_date DESC");
$pendingPayments = $stmtPending->fetchAll();

// 2. Fetch ALL USERS and their TOTAL VERIFIED contributions
$stmtMembers = $pdo->query("SELECT u.id, u.full_name, u.member_number, 
                           SUM(CASE WHEN p.status = 'verified' THEN p.detected_amount ELSE 0 END) as total_savings
                           FROM users u
                           LEFT JOIN payments p ON u.id = p.user_id
                           GROUP BY u.id
                           ORDER BY total_savings DESC");
$memberList = $stmtMembers->fetchAll();

// 3. Count Total Users
$totalUsers = count($memberList);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-50 text-slate-900">

    <nav class="bg-slate-900 p-6 text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <h1 class="font-bold tracking-tighter text-xl">CHAMAHUB <span class="text-rose-500 text-xs ml-2 uppercase tracking-widest">Treasurer</span></h1>
            <div class="flex items-center gap-6">
                <span class="text-sm font-bold text-slate-400">Total Members: <span class="text-white"><?php echo $totalUsers; ?></span></span>
                <a href="index.php" class="text-xs bg-white/10 px-4 py-2 rounded-lg hover:bg-rose-500 transition font-bold uppercase">Dashboard</a>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto p-8 space-y-12">
        
        <section>
            <div class="mb-6">
                <h2 class="text-2xl font-black text-slate-800">Pending Approvals</h2>
                <p class="text-sm text-slate-500">New screenshots waiting for your confirmation.</p>
            </div>

            <?php if (count($pendingPayments) > 0): ?>
                <div class="grid gap-4">
                    <?php foreach ($pendingPayments as $pay): ?>
                    <div class="bg-white rounded-3xl p-5 shadow-sm border border-slate-200 flex flex-col md:flex-row gap-6 items-center">
                        <img src="<?php echo $pay['screenshot_path']; ?>" class="w-20 h-20 rounded-2xl object-cover border border-slate-100 cursor-pointer" onclick="window.open(this.src)">
                        <div class="flex-grow">
                            <h4 class="font-bold text-slate-800"><?php echo htmlspecialchars($pay['full_name']); ?></h4>
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-tight"><?php echo $pay['member_number']; ?></p>
                            <p class="text-lg font-black text-rose-500 mt-1">Ksh <?php echo number_format($pay['detected_amount']); ?></p>
                        </div>
                        <div class="flex gap-2">
                            <form action="update_status.php" method="POST">
                                <input type="hidden" name="payment_id" value="<?php echo $pay['id']; ?>">
                                <input type="hidden" name="new_status" value="verified">
                                <button class="bg-emerald-500 text-white px-6 py-3 rounded-xl font-bold text-sm hover:bg-emerald-600 transition">Approve</button>
                            </form>
                            <form action="update_status.php" method="POST">
                                <input type="hidden" name="payment_id" value="<?php echo $pay['id']; ?>">
                                <input type="hidden" name="new_status" value="flagged">
                                <button class="bg-slate-100 text-slate-400 px-6 py-3 rounded-xl font-bold text-sm hover:bg-rose-50 hover:text-rose-500 transition">Deny</button>
                            </form>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="p-10 text-center bg-white rounded-3xl border-2 border-dashed border-slate-200 text-slate-400 font-medium">No pending payments.</div>
            <?php endif; ?>
        </section>

        <section>
            <div class="mb-6">
                <h2 class="text-2xl font-black text-slate-800">Member Contributions</h2>
                <p class="text-sm text-slate-500">Total verified savings for every member in the Chama.</p>
            </div>

            <div class="bg-white rounded-[2rem] shadow-sm border border-slate-200 overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100">
                            <th class="p-6 text-xs font-bold text-slate-400 uppercase tracking-widest">Member Name</th>
                            <th class="p-6 text-xs font-bold text-slate-400 uppercase tracking-widest text-center">ID Number</th>
                            <th class="p-6 text-xs font-bold text-slate-400 uppercase tracking-widest text-right">Total Verified (Ksh)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <?php foreach ($memberList as $member): ?>
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="p-6">
                                <p class="font-bold text-slate-800"><?php echo htmlspecialchars($member['full_name']); ?></p>
                            </td>
                            <td class="p-6 text-center">
                                <span class="bg-slate-100 px-3 py-1 rounded-lg text-xs font-bold text-slate-500">
                                    <?php echo $member['member_number']; ?>
                                </span>
                            </td>
                            <td class="p-6 text-right">
                                <p class="text-lg font-black text-slate-900">
                                    <?php echo number_format($member['total_savings']); ?>
                                </p>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>

    </main>

</body>
</html>