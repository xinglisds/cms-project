<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - {{ config('app.name') }}</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .email-container {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 10px;
            padding: 40px;
            text-align: center;
            color: white;
            margin-bottom: 30px;
        }
        .email-content {
            background: white;
            border-radius: 10px;
            padding: 40px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .logo {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .subtitle {
            font-size: 16px;
            opacity: 0.9;
            margin-bottom: 0;
        }
        .greeting {
            font-size: 24px;
            color: #2d3748;
            margin-bottom: 20px;
            font-weight: 600;
        }
        .message {
            font-size: 16px;
            color: #4a5568;
            margin-bottom: 30px;
            line-height: 1.8;
        }
        .reset-button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 40px;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 16px;
            margin: 20px 0;
            transition: transform 0.2s;
        }
        .reset-button:hover {
            transform: translateY(-2px);
            color: white;
        }
        .expiry-notice {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
            color: #856404;
        }
        .security-notice {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
            color: #721c24;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            color: #718096;
            font-size: 14px;
        }
        .url-fallback {
            background-color: #f7fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
            word-break: break-all;
            font-family: monospace;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="logo">🔐 {{ config('app.name') }}</div>
        <div class="subtitle">Secure Content Management System</div>
    </div>

    <div class="email-content">
        <div class="greeting">Hello!</div>
        
        <div class="message">
            You are receiving this email because we received a password reset request for your account.
        </div>

        <div style="text-align: center;">
            <a href="{{ $resetUrl }}" class="reset-button">
                🔑 Reset My Password
            </a>
        </div>

        <div class="expiry-notice">
            <strong>⏰ Important Notice:</strong> This password reset link will expire in {{ $expireMinutes }} minutes. Please complete your password reset as soon as possible.
        </div>

        <div class="security-notice">
            <strong>🛡️ Security Notice:</strong> If you did not request a password reset, please ignore this email. Your account remains secure and no action is required.
        </div>

        <div class="message">
            If you're having trouble clicking the button above, copy and paste the following link into your browser:
        </div>

        <div class="url-fallback">
            {{ $resetUrl }}
        </div>
    </div>

    <div class="footer">
        <p>This email was sent automatically by {{ config('app.name') }} system. Please do not reply.</p>
        <p>If you have any questions, please contact our technical support team.</p>
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</body>
</html> 