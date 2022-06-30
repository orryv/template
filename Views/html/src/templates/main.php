<!DOCTYPE html>
<html>
<head>
    <title><?= $p_title ?></title>
    <meta name="description" content="<?= $p_description ?>"/>
    <link rel="canonical" href="<?= BASE_URL.$p_url ?>" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/brands.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/solid.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/fontawesome.min.css">

    <link rel="apple-touch-icon" sizes="57x57" href="<?= CDN ?>/icons/apple-touch-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?= CDN ?>/icons/apple-touch-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?= CDN ?>/icons/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?= CDN ?>/icons/apple-touch-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?= CDN ?>/icons/apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?= CDN ?>/icons/apple-touch-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?= CDN ?>/icons/apple-touch-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?= CDN ?>/icons/apple-touch-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= CDN ?>/icons/apple-touch-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= CDN ?>/icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="194x194" href="<?= CDN ?>/icons/favicon-194x194.png">
    <link rel="icon" type="image/png" sizes="192x192" href="<?= CDN ?>/icons/android-chrome-192x192.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= CDN ?>/icons/favicon-16x16.png">
    <link rel="manifest" href="<?= CDN ?>/icons/site.webmanifest">
    <link rel="mask-icon" href="<?= CDN ?>/icons/safari-pinned-tab.svg" color="#3770ab">
    <link rel="shortcut icon" href="<?= CDN ?>/icons/favicon.ico">
    <meta name="apple-mobile-web-app-title" content="ESP Wins">
    <meta name="application-name" content="ESP Wins">
    <meta name="msapplication-TileColor" content="#3770ab">
    <meta name="msapplication-TileImage" content="<?= CDN ?>/icons/mstile-144x144.png">
    <meta name="msapplication-config" content="<?= CDN ?>/icons/browserconfig.xml">
    <meta name="theme-color" content="#3770ab">

    <?php /*
    FOLLOW –The search engine crawler will follow all the links in that webpage
    INDEX –The search engine crawler will index the whole webpage
    NOFOLLOW – The search engine crawler will NOT follow the page and any links in that webpage
    NOINDEX – The search engine crawler will NOT index that webpage 
    */ ?>
    <meta name=”robots” content=”index, follow”>
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta property="og:title" content="<?= $p_title ?>"/>
    <meta property="og:url" content="<?= BASE_URL.FULL_REQUEST_URI ?>" />
    <meta property="og:description" content="<?= $p_description ?>" />
    <meta name="twitter:title" content="<?= $p_title ?>">
    <meta name="twitter:description" content="<?= $p_description ?>">
    <meta charset="utf-8">

</head>
<body>

    <div id="content">

    </div>

</body>
</html>