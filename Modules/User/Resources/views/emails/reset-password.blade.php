<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
</head>
<body>
<table style="max-width: 600px; margin: 0 auto; padding: 20px;">
    <tr>
        <td style="text-align: center; background-color: #f5f5f5; padding: 20px;">
            <h1>Password Reset</h1>
        </td>
    </tr>
    <tr>
        <td style="background-color: #ffffff; padding: 20px;">
            <p>Hello {{ $user->name }},</p>
            <p>You have requested to reset your password. Please click the button below to proceed:</p>
            <p style="text-align: center;">
                <a href="{{ $resetUrl }}" style="display: inline-block; background-color: #4caf50; color: #ffffff; text-decoration: none; padding: 10px 20px; margin-top: 20px;">Reset Password</a>
            </p>
            <p>If you didn't request a password reset, please ignore this email.</p>
        </td>
    </tr>
    <tr>
        <td style="text-align: center; background-color: #f5f5f5; padding: 20px;">
            <strong>Copyright &copy; {{ date("Y") }} <a href="{{ env("APP_URL") }}">{{ env("APP_NAME") }}</a>.</strong> {{ tr('all_rights_reserved') }}
        </td>
    </tr>
</table>
</body>
</html>
