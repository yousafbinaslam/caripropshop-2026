<?php
$site_name = get_bloginfo('name');
$site_url = home_url();
$logo_url = get_option('cps_mail_logo_url', '');

$footer_text = get_option('cps_mail_footer_text', sprintf(__('© %s. All rights reserved.', 'cari-prop-shop-mail'), date('Y')));
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
            background-color: #f4f4f4;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
        }
        .email-header {
            background-color: #2c3e50;
            padding: 30px;
            text-align: center;
        }
        .email-header a {
            color: #ffffff;
            text-decoration: none;
            font-size: 24px;
            font-weight: bold;
        }
        .email-body {
            padding: 40px 30px;
            color: #333333;
            line-height: 1.6;
        }
        .email-body h1,
        .email-body h2,
        .email-body h3 {
            color: #2c3e50;
            margin-top: 0;
        }
        .email-body a {
            color: #3498db;
            text-decoration: underline;
        }
        .email-body img {
            max-width: 100%;
            height: auto;
        }
        .email-footer {
            background-color: #f8f9fa;
            padding: 30px;
            text-align: center;
            color: #666666;
            font-size: 14px;
        }
        .email-footer a {
            color: #3498db;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #3498db;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 4px;
            font-weight: 500;
        }
        .button-primary {
            background-color: #2ecc71;
        }
    </style>
</head>
<body>
    <table role="presentation" cellspacing="0" cellpadding="0" width="100%" style="background-color: #f4f4f4;">
        <tr>
            <td align="center">
                <table role="presentation" cellspacing="0" cellpadding="0" width="600" class="email-container">
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
                            <p><?php echo wp_kses_post($footer_text); ?></p>
                            <p>
                                <a href="{unsubscribe_url}"><?php _e('Unsubscribe', 'cari-prop-shop-mail'); ?></a> | 
                                <a href="<?php echo esc_url($site_url); ?>"><?php _e('Visit Website', 'cari-prop-shop-mail'); ?></a>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>