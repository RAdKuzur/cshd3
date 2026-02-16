<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @media only screen and (max-width: 600px) {
            .container { width: 100% !important; }
            .button { width: 100% !important; display: block !important; }
        }
    </style>
</head>
<body style="margin: 0; padding: 0; font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #f4f6f9;">
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #f4f6f9; padding: 20px;">
    <tr>
        <td align="center">
            <table class="container" width="600" cellpadding="0" cellspacing="0" border="0" style="background-color: #ffffff; border-radius: 16px; box-shadow: 0 8px 20px rgba(0,0,0,0.05); overflow: hidden;">
                <!-- Header -->
                <tr>
                    <td style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 40px 30px; text-align: center;">
                        <h1 style="color: #ffffff; margin: 0; font-size: 28px; font-weight: 300; letter-spacing: 1px;">
                            @yield('header', '📄 Документ создан')
                        </h1>
                    </td>
                </tr>

                <!-- Main content -->
                <tr>
                    <td style="padding: 40px 30px;">
                        <div style="text-align: center;">
                            <!-- Main message -->
                            <h2 style="color: #333333; margin: 0 0 20px; font-size: 24px; font-weight: 500;">
                                @yield('title')
                            </h2>

                            <p style="color: #4a5568; font-size: 18px; line-height: 1.6; margin: 0 0 30px; background-color: #f7fafc; padding: 20px; border-radius: 12px;">
                                @yield('message')
                            </p>

                            <!-- Details box -->
                            <div style="background-color: #f8f9fa; border-left: 4px solid #667eea; padding: 20px; margin: 30px 0; text-align: left; border-radius: 8px;">
                                <p style="color: #2d3748; margin: 0 0 10px; font-size: 16px;">
                                    <strong style="color: #4a5568;">📋 Информация:</strong>
                                </p>
                                <p style="color: #4a5568; margin: 5px 0; font-size: 15px;">
                                    @yield('details')
                                </p>
                            </div>

                            <!-- Button -->
                            @hasSection('button_url')
                                <table cellpadding="0" cellspacing="0" border="0" style="margin: 30px auto;">
                                    <tr>
                                        <td style="border-radius: 50px;" bgcolor="#667eea">
                                            <a href="@yield('button_url')"
                                               style="display: inline-block; padding: 16px 40px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50px; color: #ffffff; text-decoration: none; font-weight: 600; font-size: 18px; letter-spacing: 1px; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);">
                                                @yield('button_text', '🔗 ПЕРЕЙТИ К ДОКУМЕНТУ')
                                            </a>
                                        </td>
                                    </tr>
                                </table>

                                <!-- Alternative text link -->
                                <p style="margin: 20px 0 0;">
                                    <a href="@yield('button_url')" style="color: #718096; font-size: 14px; text-decoration: none; border-bottom: 1px dashed #cbd5e0;">
                                        или скопируйте ссылку: @yield('button_url')
                                    </a>
                                </p>
                            @endif
                        </div>
                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td style="background-color: #f8fafc; padding: 30px; border-top: 1px solid #e2e8f0;">
                        <p style="color: #718096; font-size: 14px; margin: 0 0 10px; text-align: center;">
                            @yield('footer_note', 'Это автоматическое уведомление, пожалуйста, не отвечайте на него.')
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
