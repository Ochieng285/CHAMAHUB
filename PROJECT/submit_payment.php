<?php
require_once 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['screenshot'])) {
    $apiKey = 'K87483143788957'; 
    $userId = $_SESSION['user_id'];
    $memberNum = $_SESSION['member_number'];
    
    // User must enter exactly 20 (Ksh)
    $requiredAmount = 20;
    $manualAmount = isset($_POST['manual_amount']) ? (float)$_POST['manual_amount'] : 0;
    if ($manualAmount <= 0) {
        header("Location: index.php?error=" . urlencode("Please enter the amount shown on your receipt."));
        exit();
    }

    // 1. Handle File Upload
    $targetDir = "uploads/";
    if (!file_exists($targetDir)) { mkdir($targetDir, 0777, true); }
    
    $fileExt = pathinfo($_FILES["screenshot"]["name"], PATHINFO_EXTENSION);
    $fileName = "rcpt_" . time() . "_" . $userId . "." . $fileExt;
    $targetPath = $targetDir . $fileName;

    if (move_uploaded_file($_FILES["screenshot"]["tmp_name"], $targetPath)) {
        
        // 2. Optimized OCR API Call
        $imageData = base64_encode(file_get_contents($targetPath));
        $postData = [
            'apikey' => $apiKey,
            'base64Image' => 'data:image/' . $fileExt . ';base64,' . $imageData,
            'language' => 'eng',
            'isOverlayRequired' => false,
            'scale' => true,      // Makes the image bigger/clearer for the API
            'OCREngine' => 2,     // Engine 2 is best for receipts
            'detectOrientation' => true 
        ];

        $ch = curl_init('https://api.ocr.space/parse/image');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response, true);
        $parsedText = $result['ParsedResults'][0]['ParsedText'] ?? '';

        // 3. Advanced Extraction Logic
        $detectedAmount = 0;

        // Step A: Look for patterns like "Ksh 500.00" or "Amount: 1,200"
        if (preg_match('/(?:Ksh|Amount|Sent|Paid|Balance)\s*([\d,]+\.?\d*)/i', $parsedText, $matches)) {
            $detectedAmount = (float)str_replace(',', '', $matches[1]);
        }

        // Step B: If Step A fails, find the highest decimal number (usually the transaction total)
        if ($detectedAmount < 5) { // Assuming contributions are > 5 Ksh
            if (preg_match_all('/([\d,]+\.\d{2})/', $parsedText, $allDecimals)) {
                $numbers = array_map(function($n) { 
                    return (float)str_replace(',', '', $n); 
                }, $allDecimals[0]);
                
                $filtered = array_filter($numbers, function($val) {
                    return !in_array($val, [2024, 2025, 2026]);
                });

                if (!empty($filtered)) {
                    $detectedAmount = max($filtered);
                }
            }
        }

        // 4. Verified only if entered amount is 20 (tolerance 0.01 for decimals)
        $enteredAmountCorrect = (abs($manualAmount - $requiredAmount) < 0.01);
        $status = $enteredAmountCorrect ? 'verified' : 'flagged';
        $amountToStore = $detectedAmount > 0 ? $detectedAmount : $manualAmount;

        // 5. Save to Database
        try {
            $stmt = $pdo->prepare("INSERT INTO payments (user_id, member_id, screenshot_path, detected_amount, status) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$userId, $memberNum, $targetPath, $amountToStore, $status]);

            if ($status === 'verified') {
                header("Location: index.php?msg=Verified: Ksh " . number_format($amountToStore) . " saved.");
            } else {
                header("Location: index.php?error=" . urlencode("Flagged: contribution amount must be Ksh 20. You entered Ksh " . number_format($manualAmount) . "."));
            }
        } catch (PDOException $e) {
            die("Database Error: " . $e->getMessage());
        }
        exit();
    }
}