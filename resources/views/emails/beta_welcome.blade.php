<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #f8fafc; color: #1e293b; margin: 0; padding: 40px 20px;">
    
    <div style="max-width: 500px; margin: 0 auto; background-color: #ffffff; border-radius: 24px; padding: 40px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
        
        <h1 style="margin-top: 0; font-size: 28px; font-weight: 800; color: #3b82f6; text-align: center;">
            BedTime<span style="color: #f97316;">Bot</span>
        </h1>
        
        <h2 style="font-size: 20px; font-weight: 700; margin-top: 30px;">Hi {{ $parentName }},</h2>
        
        <p style="font-size: 16px; line-height: 1.6; color: #475569;">
            You're in! We are thrilled to welcome you and your family to the BedTimeBot Beta.
        </p>
        <p style="font-size: 16px; line-height: 1.6; color: #475569;">
            Your account has been successfully migrated from the waitlist. To get started, click the button below to set up your secure password and access your new dashboard.
        </p>
        
        <div style="text-align: center; margin: 40px 0;">
            <a href="{{ $signedUrl }}" style="background-color: #f97316; color: #ffffff; font-size: 18px; font-weight: bold; text-decoration: none; padding: 16px 32px; border-radius: 30px; display: inline-block;">Set Your Password</a>
        </div>
        
        <p style="font-size: 14px; line-height: 1.5; color: #94a3b8; text-align: center;">
            This magic link is secure and will expire in 7 days.<br>
            If you have any issues, reply directly to this email.
        </p>
        
    </div>

</body>
</html>