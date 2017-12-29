<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Dinner 4 Friends <?php echo isset($page_title) ? '| ' . $page_title : '' ?></title>
        <meta name='robots' content='index,follow' />

        <meta name="description" content="">
        <meta name="author" content="">

        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/bootstrap.min.css" />
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/font-awesome.min.css" />
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/font-d4f.css" />
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/site.css" />
        <script type="text/javascript">var BASEURL = "<?php echo base_url() ?>";</script>
        <link rel="apple-touch-icon" sizes="57x57" href="<?php echo base_url() ?>favicon/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="<?php echo base_url() ?>favicon/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="<?php echo base_url() ?>favicon/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url() ?>favicon/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="<?php echo base_url() ?>favicon/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="<?php echo base_url() ?>favicon/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="<?php echo base_url() ?>favicon/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="<?php echo base_url() ?>favicon/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url() ?>favicon/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo base_url() ?>favicon/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url() ?>favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url() ?>favicon/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url() ?>favicon/favicon-16x16.png">
        <link rel="manifest" href="/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="<?php echo base_url() ?>favicon/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">

        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({
                google_ad_client: "ca-pub-8618272045920323",
                enable_page_level_ads: true
            });
        </script>
    </head>
    <body>
        <div id="fb-root"></div>
        <script>(function (d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id))
                    return;
                js = d.createElement(s);
                js.id = id;
                js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.9&appId=528142240712093";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script>

        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div id="head" class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Navegação</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo site_url() ?>"><img src="<?php echo base_url() ?>assets/img/site/logo-header.png" alt="Dinner 4 Friends" /></a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li id="menu_home"><a href="<?php echo site_url() ?>">HOME</a></li>
                        <li id="menu_sobre"><a href="<?php echo site_url('sobre') ?>">SOBRE NÓS</a></li>
                        <li id="menu_faq"><a href="<?php echo site_url('faq') ?>">DÚVIDAS FREQUENTES</a></li>
                        <li id="menu_contato"><a href="<?php echo site_url('contato') ?>">FALE CONOSCO</a></li>
                        <li id="menu_login"><a href="<?php echo site_url('login') ?>">ÁREA DO CHEF</a></li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </nav>
        <input type="hidden" id="site" value="<?php echo SITE_URL; ?>">
        <div class="container">
