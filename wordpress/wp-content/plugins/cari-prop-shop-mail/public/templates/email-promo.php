<?php
$site_name = get_bloginfo('name');
$site_url = home_url();
$logo_url = get_option('cps_mail_logo_url', '');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo esc_html($subject); ?></title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            font-family: 'Montserrat', 'Open Sans', Arial, sans-serif;
        }
        .email-wrapper {
            width: 100%;
            background-color: #f5f5f5;
        }
        .email-container {
            max-width: 650px;
            margin: 0 auto;
            background-color: #ffffff;
        }
        .email-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 50px 40px;
            text-align: center;
        }
        .email-header a {
            color: #ffffff;
            text-decoration: none;
            font-size: 28px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 3px;
        }
        .promo-banner {
            background-color: #ff6b6b;
            color: #ffffff;
            text-align: center;
            padding: 15px;
            font-weight: bold;
            font-size: 18px;
            text-transform: uppercase;
        }
        .email-body {
            padding: 50px 40px;
            color: #333333;
            line-height: 1.8;
        }
        .email-body h1,
        .email-body h2,
        .email-body h3 {
            color: #333333;
            margin-top: 0;
        }
        .email-body a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff !important;
            padding: 18px 40px;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 20px 0;
        }
        .email-footer {
            background-color: #2d2d2d;
            padding: 40px;
            text-align: center;
            color: #999999;
            font-size: 14px;
        }
        .email-footer a {
            color: #ffffff;
        }
        .social-links {
            margin: 20px 0;
        }
        .social-links a {
            display: inline-block;
            margin: 0 10px;
            color: #ffffff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <table role="presentation" cellspacing="0" cellpadding="0" width="100%" class="email-wrapper">
        <tr>
            <td align="center">
                <table role="presentation" cellspacing="0" cellpadding="0" width="650" class="email-container">
                    <tr>
                        <td class="email-header">
                            <?php if (!empty($logo_url)): ?>
                                <a href="<?php echo esc_url($site_url); ?>">
                                    <img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr($site_name); ?>" style="max-width: 200px; height: auto;">
                                </a>
                            <?php else: ?>
                                <a href="<?php echo esc_url($site_url); ?>"><?php echo esc_html($site_name); ?></a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="email-body">
                            <?php echo do_shortcode($content); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="email-footer">
                            <p><?php echo esc_html($site_name); ?></p>
                            <div class="social-links">
                                <a href="<?php echo esc_url($site_url); ?>"><?php _e('Website', 'cari-prop-shop-mail'); ?></a>
                            </div>
                            <p>
                                <a href="{unsubscribe_url}"><?php _e('Unsubscribe', 'cari-prop-shop-mail'); ?></a>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>