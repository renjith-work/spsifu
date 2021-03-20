<!doctype html>
<html class="no-js" lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Supreme Sifu | Custom Men's Tailored Shirts</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.ico">
    
    <!-- CSS 
    ========================= -->
   
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/front/assets/css/bootstrap.min.css">
    
    <!-- Font CSS -->
    <link rel="stylesheet" href="/front/assets/css/font-awesome.min.css">
    
    <!-- Plugins CSS -->
    <link rel="stylesheet" href="/front/assets/css/plugins.css">
    
    <!-- Main Style CSS -->
    <link rel="stylesheet" href="/front/assets/css/style.css?version=<?php echo date('l jS \of F Y h:i:s A'); ?>">
    <link rel="stylesheet" href="/front/assets/css/set2.css">
    <link rel="stylesheet" href="/front/assets/css/custom.css?version=<?php echo date('l jS \of F Y h:i:s A'); ?>">
    <link rel="stylesheet" href="/front/assets/css/mobile.css?version=<?php echo date('l jS \of F Y h:i:s A'); ?>">
    <link rel="stylesheet" href="/front/assets/css/responsive.css?version=<?php echo date('l jS \of F Y h:i:s A'); ?>">
    <link rel="stylesheet" href="/front/assets/css/gallery.css">
    <link href="https://fonts.google.com" rel="stylesheet">
    {{-- <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet"> --}}
    {{-- <link rel="stylesheet" href="/front/assets/css/timeline.css">  --}}
    
    <!-- Modernizer JS -->
    <script src="/front/assets/js/vendor/modernizr-2.8.3.min.js"></script>
    @yield('header')
</head>

<body>
<div id="loading-overlay">
    {{-- <div class="loading-icon"></div> --}}
    <div class="fa fa-cog fa-icon"></div>
</div>  
<!-- Main Wrapper Start -->
<div class="main-wrapper">
    <!-- header-area start -->
    <div class="header-area">
        <!-- header-top start -->
        <div class="header-top bg-black">
            <div class="mobile-container">
                <div class="row">
                    <div class="col-lg-8 order-2 order-lg-1">
                        <div class="top-left-wrap">
                            <ul class="link-top top-social">
                                <li><a href="#" title="twitter"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="#" title="Rss"><i class="fa fa-rss"></i></a></li>
                                <li><a href="#" title="Google"><i class="fa fa-google-plus"></i></a></li>
                                <li><a href="#" title="Facebook"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#" title="Youtube"><i class="fa fa-youtube"></i></a></li>
                                <li><a href="#" title="Instagram"><i class="fa fa-instagram"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 order-1 order-lg-2">
                        <div class="top-selector-wrapper">
                            <ul class="single-top-selector">
                                <!-- Sanguage Start -->
                                <li class="setting-top list-inline-item">
                                    <div class="btn-group top-sign">
                                         @guest
                                            <a href="/register">Sign Up</a>&nbsp; | &nbsp;<a href="/login">Login</a>
                                        @endguest
                                    </div>
                                </li>
                                @auth
                                <li class="setting-top list-inline-item">
                                    <div class="btn-group">
                                        <button class="dropdown-toggle">{{ Auth::user()->fname }} {{ Auth::user()->lname }}'s Account <i class="fa fa-angle-down"></i></button>
                                        <div class="dropdown-menu acc-dropdown">
                                            <ul>
                                                <li><a href="/user/dashboard"><i class="acc-icon fa fa-user-circle-o"></i> Manage My Account</a></li>
                                                <li><a href="/user/order"><i class="acc-icon fa fa-shopping-cart"></i> My Orders</a></li>
                                                <li><a href="/user/logout"><i class="acc-icon fa fa-sign-out"></i> Logout</a></li>
                                                @hasrole('Super Admin')<li><a href="/admin/dashboard/super-admin"><i class="acc-icon fa fa-cog"></i> Admin Dashboard</a></li>@endhasrole
                                                @hasrole('Administrator')<li><a href="/admin/dashboard/admin"><i class="acc-icon fa fa-cog"></i> Admin Dashboard</a></li>@endhasrole
                                                @hasrole('Product Manager')<li><a href="/admin/dashboard/product-manager"><i class="acc-icon fa fa-cog"></i> Admin Dashboard</a></li>@endhasrole
                                                @hasrole('Order Manager')<li><a href="/admin/dashboard/order-manager"><i class="acc-icon fa fa-cog"></i> Admin Dashboard</a></li>@endhasrole
                                                @hasrole('Logistics Manager')<li><a href="/admin/dashboard/logistics-manager"><i class="acc-icon fa fa-cog"></i> Admin Dashboard</a></li>@endhasrole
                                                @hasrole('Accounts Manager')<li><a href="/admin/dashboard/accounts-manager"><i class="acc-icon fa fa-cog"></i> Admin Dashboard</a></li>@endhasrole
                                                @hasrole('Business Manager')<li><a href="/admin/dashboard/business-manager"><i class="acc-icon fa fa-cog"></i> Admin Dashboard</a></li>@endhasrole
                                                @hasrole('Media Manager')<li><a href="/admin/dashboard/media-manager"><i class="acc-icon fa fa-cog"></i> Admin Dashboard</a></li>@endhasrole
                                                @hasrole('Editor')<li><a href="/admin/dashboard/editor"><i class="acc-icon fa fa-cog"></i> Admin Dashboard</a></li>@endhasrole
                                                @hasrole('Author')<li><a href="/admin/dashboard/author"><i class="acc-icon fa fa-cog"></i> Admin Dashboard</a></li>@endhasrole
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                                @endauth
                                <!-- Sanguage End -->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Header-top end -->
        <!-- Header-bottom start -->
        <div class="header-bottom-area header-sticky">
            {{-- <div class="top-container"> --}}
            <div class="top-container">
                <div class="row">
                    <div class="col-lg-2 col-md-2">
                        <!-- logo start -->
                        <div class="logo">
                            <a href="/"><img src="/front/assets/images/logo/logo.png" alt=""></a>
                        </div>
                        <!-- logo end -->
                    </div>
                    <div class="col-lg-7 d-none d-lg-block col-md-7">
                        <!-- main-menu-area start -->
                        <div class="main-menu-area text-center">
                            <nav class="main-navigation">
                                <ul>
                                    <li  class="active"><a href="/">Home</a></li>
                                    <li><a href="/custom-shirt/fabric/class">Custom Shirt Design</a></li>
                                    <li><a href="/collection/shirts">Dress Shirts</a></li>
                                    {{-- <li><a href="">Jackets</a></li>
                                    <li><a href="">Trousers</a></li> --}}
                                    <li>
                                        <a href="/guides">Design Guides</a>
                                        {{-- <ul class="sub-menu">
                                            <li><a href="/guides">Design A Shirt</a></li>
                                            <li><a href="/guides/customize-a-shirt">Customize A Shirt</a></li>
                                            <li><a href="/guides/measure-your-body">Measure Yourself</a></li>
                                            <li><a href="/guides/direct-measurement">Direct Measurement</a></li>
                                            <li><a href="/guides/standard-size-guide">Standard Size Guide</a></li>
                                            <li><a href="/guides/take-care-of-dress-shirt">Shirt Care</a></li>
                                        </ul> --}}
                                    </li>
                                    {{-- <li><a href="/promotions">Promotions</a></li> --}}
                                </ul>
                            </nav>
                        </div>
                        <!-- main-menu-area End -->
                    </div>
                    <div class="col-lg-3 col-md-3">
                        <div class="header-bottom-right">
                            <div class="block-search">
                                <div class="trigger-search"><i class="fa fa-search"></i> <span class="top-semiTitle">Search</span></div>
                                <div class="search-box main-search-active">
                                    <form action="#" class="search-box-inner">
                                        <input type="text" placeholder="Search our catalog">
                                        <button class="search-btn" type="submit"><i class="fa fa-search"></i></button>
                                    </form>
                                </div>
                            </div>
                            <div class="shoping-cart">
                                <div class="btn-group">
                                    <!-- Mini Cart Button start -->
                                    <button class="dropdown-toggle"><a href="/cart"><i class="fa fa-shopping-cart"></i> <span class="top-semiTitle">Cart </span> ({{Cart::getContent()->count()}})</a></button>
                                    <!-- Mini Cart button end -->
                                    
                                    <!-- Mini Cart wrap start -->
                                    <div class="dropdown-menu mini-cart-wrap">
                                        <div class="shopping-cart-content">
                                            {{-- <ul class="mini-cart-content">
                                                <!-- Mini-Cart-item start -->
                                                <li class="mini-cart-item">
                                                    <div class="mini-cart-product-img">
                                                        <a href="#"><img src="assets/images/cart/1.jpg" alt=""></a>
                                                        <span class="product-quantity">1x</span>
                                                    </div>
                                                    <div class="mini-cart-product-desc">
                                                        <h3><a href="#">Printed Summer Dress</a></h3>
                                                        <div class="price-box">
                                                            <span class="new-price">$55.21</span>
                                                        </div>
                                                        <div class="size">
                                                            Size: S
                                                        </div>
                                                    </div>
                                                    <div class="remove-from-cart">
                                                        <a href="#" title="Remove"><i class="fa fa-trash"></i></a>
                                                    </div>
                                                </li>
                                                <!-- Mini-Cart-item end -->
                                                
                                                <!-- Mini-Cart-item start -->
                                                <li class="mini-cart-item">
                                                    <div class="mini-cart-product-img">
                                                        <a href="#"><img src="assets/images/cart/3.jpg" alt=""></a>
                                                        <span class="product-quantity">1x</span>
                                                    </div>
                                                    <div class="mini-cart-product-desc">
                                                        <h3><a href="#">Faded Sleeves T-shirt</a></h3>
                                                        <div class="price-box">
                                                            <span class="new-price">$72.21</span>
                                                        </div>
                                                        <div class="size">
                                                            Size: M
                                                        </div>
                                                    </div>
                                                    <div class="remove-from-cart">
                                                        <a href="#" title="Remove"><i class="fa fa-trash"></i></a>
                                                    </div>
                                                </li>
                                                <!-- Mini-Cart-item end -->
                                                
                                                <li>
                                                    <!-- shopping-cart-total start -->
                                                    <div class="shopping-cart-total">
                                                        <h4>Sub-Total : <span>$127.42</span></h4>
                                                        <h4>Total : <span>$127.42</span></h4>
                                                    </div>
                                                    <!-- shopping-cart-total end -->
                                                </li>
                                                
                                                <li>   
                                                    <!-- shopping-cart-btn start -->
                                                    <div class="shopping-cart-btn">
                                                        <a href="checkout.html">Checkout</a>
                                                    </div>
                                                    <!-- shopping-cart-btn end -->
                                                </li>
                                            </ul> --}}
                                        </div>
                                    </div>
                                    <!-- Mini Cart wrap End -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <!-- mobile-menu start -->
                        <div class="mobile-menu d-block d-lg-none"></div>
                        <!-- mobile-menu end -->
                    </div>
                </div>
            </div>
        </div>
        <!-- Header-bottom end -->
    </div>
    <!-- Header-area end -->