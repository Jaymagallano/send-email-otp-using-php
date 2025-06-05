<?php
session_start();
require_once 'config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $otp = trim($_POST['otp']);
    $user_id = $_SESSION['user_id'];
    
    // Debug information
    error_log("Attempting to verify OTP: " . $otp . " for user: " . $user_id);
    
    // Get the OTP record
    $stmt = $pdo->prepare("SELECT * FROM otp WHERE user_id = ? AND otp_code = ? ORDER BY created_at DESC LIMIT 1");
    $stmt->execute([$user_id, $otp]);
    $otp_record = $stmt->fetch();
    
    if ($otp_record) {
        // Check if OTP is expired
        $current_time = new DateTime();
        $expires_at = new DateTime($otp_record['expires_at']);
        
        error_log("Current time: " . $current_time->format('Y-m-d H:i:s'));
        error_log("Expires at: " . $expires_at->format('Y-m-d H:i:s'));
        
        if ($current_time <= $expires_at) {
            // Update user verification status
            $stmt = $pdo->prepare("UPDATE users SET is_verified = TRUE WHERE id = ?");
            $stmt->execute([$user_id]);
            
            // Clear OTP codes for this user
            $stmt = $pdo->prepare("DELETE FROM otp WHERE user_id = ?");
            $stmt->execute([$user_id]);
            
            // Set session variables
            $_SESSION['verified'] = true;
            
            header("Location: dashboard.php");
            exit();
        } else {
            error_log("OTP expired");
            $error = "OTP has expired. Please request a new one.";
        }
    } else {
        error_log("Invalid OTP code");
        $error = "Invalid OTP code";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Verify OTP</h3>
                    </div>
                    <div class="card-body">
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger">
                                <?php echo htmlspecialchars($error); ?>
                            </div>
                        <?php endif; ?>
                        
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="otp" class="form-label">Enter OTP Code</label>
                                <input type="text" class="form-control" id="otp" name="otp" required maxlength="6" pattern="[0-9]{6}">
                                <div class="form-text">Please enter the 6-digit code sent to your email.</div>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Verify OTP</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 