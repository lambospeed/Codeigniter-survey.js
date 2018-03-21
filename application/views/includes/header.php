<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo $title; ?></title>


    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i%7CPoppins:300,400,500,600,700" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="<?= site_url();?>assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font-Awesome -->
    <link href="<?= site_url();?>assets/css/font-awesome.min.css" rel="stylesheet">

    <!-- Flat icon -->
    <link href="<?= site_url();?>assets/flaticon/flaticon.css" rel="stylesheet">

    <!-- Swiper -->
    <link href="<?= site_url();?>assets/css/swiper.min.css" rel="stylesheet">

    <!-- Lightcase -->
    <link href="<?= site_url();?>assets/css/lightcase.css" rel="stylesheet">

    <!-- quick-view -->
    <link href="<?= site_url();?>assets/css/quick-view.css" rel="stylesheet">

    <!-- nstSlider -->
    <link href="<?= site_url();?>assets/css/jquery.nstSlider.css" rel="stylesheet">

    <!-- flexslider -->
    <link href="<?= site_url();?>assets/css/flexslider.css" rel="stylesheet">

    <!-- banner-bg -->
    <link href="<?= site_url();?>assets/css/banner-bg.css" rel="stylesheet">

    <!-- Style -->
    <link href="<?= site_url();?>assets/css/style.css" rel="stylesheet">

    <!-- Responsive -->
    <link href="<?= site_url();?>assets/css/responsive.css" rel="stylesheet">

</head>
<body>
<div class="box-layout">
    <div class="mobile-menu-area">
        <div class="close">
            <i class="fa fa-close"></i>
        </div>
        <div class="mobile-menu">
            <ul class="m-menu">
                <li><a href="/">Home</a></li>
                <li><a href="/about">About</a></li>
                <li>
                    <a href="#">Awards</a>
                    <ul class="mobile-submenu">
                        <li><a href="/2018-categories">2018 Categories</a></li>
                        <li><a href="/2018-nominees">2018 Nominee's</a></li>
                        <li><a href="/vote">Vote Today!</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#">Sponsors</a>
                    <ul class="mobile-submenu">
                        <li><a href="/sponsors">Our Sponsors</a></li>
                        <li><a href="/become-sponsor">Become A Sponsor</a></li>
                    </ul>
                </li>
                <li><a href="/contact">Contact US</a></li>
            </ul>
        </div>
    </div>
    <header class="header-six">
        <nav class="main-menu menu-six menu-fixed">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="index.html"><img src="<?= site_url();?>images/logo.png" alt="logo" class="img-responsive site-logo"></a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-left">
                        <li class="active">
                            <a href="/" role="button">Home</a>
                        </li>
                        <li>
                            <a href="/about" role="button">About</a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Awards<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="/2018-categories">2018 Categories</a></li>
                                <li><a href="/2018-nominees">2018 Nominee's</a></li>
                                <li><a href="/vote">Vote Today!</a></li>
                            </ul>
                        </li>
                        <li><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Sponsors<span class="caret"></a>
                            <ul class="dropdown-menu">
                                <li><a href="/sponsors">Our Sponsors</a></li>
                                <li><a href="/become-sponsor">Become A Sponsor</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="/contact" role="button" aria-haspopup="true" aria-expanded="false">Contact Us</a>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container -->
        </nav>
    </header>