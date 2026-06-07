<!DOCTYPE html>
<html>
<head>
    <title>Password Reset Request</title>
</head>
<body>
    <h2>Hello,</h2>
    <p>You are receiving this email because we received a password reset request for your account.</p>
    <a href="{{ url('password/reset', $token) }}?email={{ urlencode($email) }}"
       style="display:inline-block;padding:10px 20px;background:#f59e0b;color:white;text-decoration:none;border-radius:5px;">
        Reset Password
    </a>
    <p>This link will expire in 60 minutes. If you did not request a password reset, no further action is required.</p>
</body>
</html>
