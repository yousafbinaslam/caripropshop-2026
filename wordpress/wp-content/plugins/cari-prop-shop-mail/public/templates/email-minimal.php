<?php
$site_name = get_bloginfo('name');
$site_url = home_url();
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
            background-color: #ffffff;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
        }
        .email-container {
            max-width: 500px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        .email-header {
            text-align: center;
            margin-bottom: 40px;
        }
        .email-header a {
            color: #333333;
            text-decoration: none;
            font-size: 20px;
            font-weight: 300;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        .email-body {
            color: #333333;
            line-height: 1.8;
            font-size: 16px;
        }
        .email-body a {
            color: #000000;
            text-decoration: underline;
        }
        .email-footer {
            margin-top: 60px;
            padding-top: 30px;
            border-top: 1px solid #eeeeee;
            text-align: center;
            color: #999999;
            font-size: 12px;
        }
        .email-footer a {
            color: #666666;
        }
    </style>
</head>
<body>
    <table role="presentation" cellspacing="0" cellpadding="0" width="100%">
        <tr>
            <td align="center">
                <table role="presentation" cellspacing="0" cellpadding="0" width="500" class="email-container">
                    <tr>
                        <td class="email-header">
                            <a href="<?php echo esc_url($site_url); ?>"><?php echo esc_html($site_name); ?></a>
                        </td>
                    </tr>
                    <tr>
                        <td class="email-body">
                            <?php echo do_shortcode($content); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="email-footer">
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