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
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/ionicons.min.css?v=2.0.1" />
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/site.css" />
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/painel.css" />
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/croppie.css" />
        <link rel="Stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/sweetalert.css" />

        <script type="text/javascript">BASEURL = "<?php echo (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" . $_SERVER['SERVER_NAME'] : "http://" . $_SERVER['SERVER_NAME']; ?>/"</script>
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({
                google_ad_client: "ca-pub-8618272045920323",
                enable_page_level_ads: true
            });
        </script>

        <?php if (isset($cssFiles)): ?>
            <?php foreach ($cssFiles as $item): ?>
                <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/<?php echo $item ?>" />
            <?php endforeach; ?>
        <?php endif; ?>

        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/eventos.css" />
        <script>
            var site = "<?php echo SITE_URL; ?>";
        </script>

    </head>
    <body id="page-chef">
        <script>
            (function (d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id))
                    return;
                js = d.createElement(s);
                js.id = id;
                js.src = "//connect.facebook.net/pt_BR/sdk.js";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
            window.fbAsyncInit = function () {
                FB.init({
                    appId: '528142240712093',
                    status: true,
                    xfbml: true,
                    version: 'v2.7' // or v2.6, v2.5, v2.4, v2.3
                });
            }
        </script>
        <!-- Fixed navbar -->
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Navegação</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo site_url() ?>"><img src="<?php echo base_url() ?>assets/img/site/logo-header.png" alt="Dinner 4 Friends" /></a>
                </div>
                <div id="navbar" class="navbar-collapse collapse navbar-right">
                    <ul class="nav navbar-nav">
                        <li><a href="<?php echo site_url() ?>">HOME</a></li>
                        <li><a href="<?php echo site_url('sobre') ?>">SOBRE NÓS</a></li>
                        <li><a href="<?php echo site_url('faq') ?>">DÚVIDAS FREQUENTES</a></li>
                        <li><a href="<?php echo site_url('contato') ?>">FALE CONOSCO</a></li>
                        <li class="active"><a href="<?php echo site_url('login') ?>">ÁREA DO CHEF</a></li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </nav>
        <div class="container-fluid" id="main-container">
<?php include_once(dirname(__FILE__) . '/sidebar.php'); ?>
            <div class="col-sm-9 col-lg-10 content-page">