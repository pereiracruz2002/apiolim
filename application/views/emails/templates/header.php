<?php
$img = SITE_URL . "assets/img/site/logo-header.png";
$type = pathinfo($img, PATHINFO_EXTENSION);
$data = base64_encode(file_get_contents($img));
$imgUri = "data:image/jpg;base64,{$data}";
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Dinner 4 Friends</title>
        <style type="text/css">
            * {
                margin: 0;
                padding: 0;
                font-family: arial, verdana, sans-serif;
            }
            body {
                background: #f9f9f9;
            }
            nav.navbar {
                background: #712d81;
                padding: 10px 20px 5px 20px;
            }
            .container-fluid {
                width: 1170px;
                padding: 10px 20px;
                min-height: 350px;
                /*position: relative;
                width: auto;
                max-width: 800px;
                margin: 0 auto;
                margin-top: 40px;
                padding: 20px;
                background: #fff;
                border: solid 1px #ccc;
                border-radius: 5px;
                box-shadow: 0 1px 1px 0px #aaa;*/
            }
            .footer-bar {
                background: #f05a4e;
                padding: 30px;
            }
            h1 {
                color: #f05a4e;
                padding: 10px;
            }
            h3, h4 {
                color: #333;
                padding: 5px 15px;
            }
        </style>
    </head>
    <body>
        <nav class="navbar">
            <div class="">
                <a class="navbar-brand" href="<?php echo SITE_URL ?>"><img src="<?php echo $img ?>" alt="Dinner 4 Friends" /></a>
            </div>
        </nav>
        <div class="container-fluid">