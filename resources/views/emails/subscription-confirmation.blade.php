<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscription Confirmation</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8fafc;
        }
        .container {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            color: white;
        }
        .title {
            color: #1a202c;
            font-size: 28px;
            font-weight: bold;
            margin: 0;
        }
        .subtitle {
            color: #718096;
            font-size: 16px;
            margin: 10px 0 0 0;
        }
        .content {
            margin: 30px 0;
        }
        .welcome-text {
            font-size: 18px;
            color: #2d3748;
            margin-bottom: 20px;
        }
        .email-highlight {
            background-color: #edf2f7;
            padding: 12px 16px;
            border-radius: 8px;
            font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
            color: #2b6cb0;
            font-weight: 600;
            text-align: center;
            margin: 20px 0;
        }
        .features {
            background-color: #f7fafc;
            border-radius: 8px;
            padding: 20px;
            margin: 25px 0;
        }
        .features h3 {
            color: #2d3748;
            font-size: 18px;
            margin: 0 0 15px 0;
        }
        .feature-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .feature-list li {
            padding: 8px 0;
            color: #4a5568;
            position: relative;
            padding-left: 25px;
        }
        .feature-list li:before {
            content: "✅";
            position: absolute;
            left: 0;
        }
        .cta-section {
            text-align: center;
            margin: 30px 0;
        }
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            padding: 14px 28px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            transition: transform 0.2s;
        }
        .cta-button:hover {
            transform: translateY(-2px);
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            color: #718096;
            font-size: 14px;
        }
        .social-links {
            margin: 20px 0;
        }
        .social-links a {
            display: inline-block;
            margin: 0 10px;
            color: #667eea;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">📧</div>
            <h1 class="title">Subscription Successful!</h1>
            <p class="subtitle">Welcome to our Newsletter community</p>
        </div>

        <div class="content">
            <p class="welcome-text">
                Dear Reader,
            </p>
            
            <p>
                Thank you for subscribing to our Newsletter! We're excited to have you join our community and stay connected with us.
            </p>

            <div class="email-highlight">
                {{ $subscriberEmail }}
            </div>

            <p>
                Your email address has been successfully added to our subscription list. From now on, you'll regularly receive our carefully curated content, including:
            </p>

            <div class="features">
                <h3>What you'll receive:</h3>
                <ul class="feature-list">
                    <li>Latest technical articles and in-depth analysis</li>
                    <li>Industry trends and insights</li>
                    <li>Exclusive content and early previews</li>
                    <li>Practical tips and best practices</li>
                    <li>Community events and special offers</li>
                </ul>
            </div>

            <p>
                We promise to only send valuable content and will never spam you. You can unsubscribe at any time.
            </p>
        </div>

        <div class="cta-section">
            <a href="{{ url('/') }}" class="cta-button">
                🏠 Visit Our Website
            </a>
        </div>

        <div class="footer">
            <p>
                <strong>{{ config('app.name') }}</strong><br>
                Thank you for your trust and support!
            </p>
            
            <div class="social-links">
                <a href="{{ url('/') }}">🌐 Website</a>
                <a href="{{ url('/articles') }}">📚 Articles</a>
            </div>
            
            <p style="font-size: 12px; color: #a0aec0; margin-top: 20px;">
                If you no longer wish to receive these emails, you can 
                <a href="#" style="color: #667eea;">unsubscribe</a> at any time.
            </p>
            
            <p style="font-size: 12px; color: #a0aec0;">
                Email sent on: {{ date('F j, Y \a\t g:i A') }}
            </p>
        </div>
    </div>
</body>
</html> 