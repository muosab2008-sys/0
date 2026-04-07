<?php
if (!defined('BASEPATH')) {
    exit('Unable to view file.');
}
$page = (isset($_GET['x']) ? $_GET['x'] : 0);
$limit = 25;
$start = (is_numeric($page) && $page > 0 ? ($page - 1) * $limit : 0);

$total_pages = $db->QueryGetNumRows("SELECT `id` FROM `completed_offers` WHERE `status`='1'");
include(BASE_PATH . '/system/libs/paginator.php');
$recover_key = false;
if (isset($_GET['recover'])) {
    $getKey = $db->EscapeString($_GET['recover']);
    $checkKey = $db->QueryFetchArray("SELECT `user_id` FROM `users_recovery` WHERE `hash_key`='" . $getKey . "' LIMIT 1");

    if (!empty($checkKey['user_id'])) {
        $recover_key = true;
    }
}
$urlPattern = GenerateURL('completed&x=(:num)', false, true);
$paginator = new Paginator($total_pages, $limit, $page, $urlPattern);
$paginator->setMaxPagesToShow(5);
?>
<!DOCTYPE html>
<html lang="en" class="dark-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="/assets/"
    data-template="horizontal-menu-template">

<head>
    <meta charset="utf-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

    <meta name="csrf-token" content="194WppxVbKQx93w2axoramirXk9jG42Na1O3vqKX">
    <title>Earnsfly | The #1 Website to make money online</title>
    <link rel="icon" type="image/x-icon" href="/assets/img/logo.svg">

    <script></script>
    <link rel="alternate" hreflang="en" href="#">
    <link rel="canonical" href="#">
    <meta name="robots" content="index, follow">
    <meta name="googlebot" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="keywords"
        content="coupons, cash back, cash app, Paid Online Surveys, Free Gift Cards, promo codes, offers, discounts, deals, coupon codes, timebucks, swagbucks, earn by click, paid by click, referral earn money online, earn money watching videos, click to pay earn money, make money signing up, easy earn, withdraw paypal, withdraw bitcoin, fast pay, easy offers, free game card, freefire gift, pubg gift, free gift card, fast earn, minimun withdraw, payperclick, surveys, make money online, CPA, CPL, CPV, ways to earn money, earn cash online,take surveys and make money,free online survey jobs,money surveys,earn survey,best online survey sites,best surveys to earn money,take surveys for money,get paid surveys,paid surveys scams,get paid for surveys,take surveys for cash,take surveys,survey sites to make money,cash for surveys,online survey for money,paid survey online,get paid for online surveys,paid to take surveys,best online surveys to make money,online survey rewards,best surveys for money,pay me for surveys,the best online surveys for money,which online surveys pay the most,top survey sites to earn money">
    <meta name="description"
        content="Complete tasks, play games or take online surveys for money. Want to know how to get free Robux, or how to get free V Bucks. Join Coinhub today.">
    <meta property="og:locale" content="en_US">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Coinhub | The #1 Website to make money online">
    <meta property="og:description"
        content="Complete tasks, play games or take online surveys for money. Want to know how to get free Robux, or how to get free V Bucks. Join Coinhub today.">
    <meta property="og:url" content="#">
    <meta property="og:site_name" content="Coinhub">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:creator" content="@Coinhub">
    <meta name="twitter:site" content="@Coinhub">
    <meta property="og:image" content="/assets/img/thumbnail.jpg">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        window.swiper = Swiper;
    </script>
    <!-- Icons -->
    <link rel="preload" as="style" href="/assets/css/fontawesome.css">
    <link rel="preload" as="style" href="/assets/css/flag-icons.css">
    <link rel="stylesheet" href="/assets/css/fontawesome.css" data-navigate-track="reload">
    <link rel="stylesheet" href="/assets/css/flag-icons.css" data-navigate-track="reload">
    <!-- Core CSS -->
    <link rel="preload" as="style" href="/css/assets/core-dark.css">
    <link rel="preload" as="style" href="/assets/css/theme-default-dark.css">
    <link rel="preload" as="style" href="/assets/css/demo.css">
    <link rel="stylesheet" href="/assets/css/core-dark.css" data-navigate-track="reload">
    <link rel="stylesheet" href="/assets/css/theme-default-dark.css" data-navigate-track="reload">
    <link rel="stylesheet" href="/assets/css/demo.css" data-navigate-track="reload">
    <link rel="preload" as="style" href="/assets/css/perfect-scrollbar.css">
    <link rel="preload" as="style" href="/assets/css/typeahead.css">
    <link rel="stylesheet" href="/assets/css/perfect-scrollbar.css" data-navigate-track="reload">
    <link rel="stylesheet" href="/assets/css/typeahead.css" data-navigate-track="reload">
    <link rel="modulepreload" href="/assets/js/helpers.js">
    <link rel="modulepreload" href="/assets/js/config.js">
    <script type="module" src="/assets/js/helpers.js" data-navigate-track="reload"></script>
    <script type="module" src="assets/js/config.js" data-navigate-track="reload"></script>
    <link rel="preload" as="style" href="/assets/css/app-kr.css">
    <link rel="stylesheet" href="/assets/css/app-kr.css" data-navigate-track="reload">
    <!-- Google tag (gtag.js) -->
    <script async="" defer="" src="https://www.googletagmanager.com/gtag/js?id=G-11M04T41G7"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());
        gtag('config', 'G-11M04T41G7');
    </script>

    <style>
        .buy-now-alert {
            position: fixed;
            bottom: 80px;
            right: 0;
            /*padding: 10px 30px;*/
            margin: 0 5px;
            z-index: 1050;
            /*display: none;*/
        }
    </style>
    <style>
        .home-offer-container {
            max-width: 100%;
            display: flex;
            gap: 1rem;
        }

        @media (max-width: 514px) {
            .home-offer-container {
                justify-items: center;
                gap: 1rem;
            }
        }

        @keyframes popIn {
            from {
                transform: scale(0.85);
                opacity: 0.01;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .offer-card {
            animation: popIn 0.5s ease-in-out;
            border-radius: 10px;
            transition: all 0.3s;
            box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.1);
            padding: 10px !important;
            cursor: pointer;
            border: none;
        }

        .offer-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2);
        }

        .offer-card {
            width: 10rem;
        }

        .partner-slider {
            overflow: hidden;
            position: relative;
            width: 100%;
            white-space: nowrap;
        }

        .partner-track {
            display: flex;
            align-items: center;
            gap: 40px;
            width: max-content;
            animation: scroll 30s linear infinite;
        }

        .partner-logo img {
            max-height: 80px;
            max-width: 200px;
            opacity: 0.75;
            transition: transform 0.3s ease;
        }

        /* Hover effect */
        .partner-logo img:hover {
            transform: scale(1.1);
            opacity: 1;
        }

        /* Smooth Scrolling Animation */
        @keyframes scroll {
            from {
                transform: translateX(0);
            }

            to {
                transform: translateX(-50%);
            }
        }
    </style>

    <style>
        .lead-name {
            text-overflow: ellipsis;
            white-space: nowrap;
            overflow: hidden;
            width: 150px;
        }

        @media (max-width: 768px) {
            .lead-name {
                width: 100px;
            }
        }
    </style>

    <!-- Livewire Styles -->
    <style>
        [wire\:loading][wire\:loading],
        [wire\:loading\.delay][wire\:loading\.delay],
        [wire\:loading\.inline-block][wire\:loading\.inline-block],
        [wire\:loading\.inline][wire\:loading\.inline],
        [wire\:loading\.block][wire\:loading\.block],
        [wire\:loading\.flex][wire\:loading\.flex],
        [wire\:loading\.table][wire\:loading\.table],
        [wire\:loading\.grid][wire\:loading\.grid],
        [wire\:loading\.inline-flex][wire\:loading\.inline-flex] {
            display: none;
        }

        [wire\:loading\.delay\.none][wire\:loading\.delay\.none],
        [wire\:loading\.delay\.shortest][wire\:loading\.delay\.shortest],
        [wire\:loading\.delay\.shorter][wire\:loading\.delay\.shorter],
        [wire\:loading\.delay\.short][wire\:loading\.delay\.short],
        [wire\:loading\.delay\.default][wire\:loading\.delay\.default],
        [wire\:loading\.delay\.long][wire\:loading\.delay\.long],
        [wire\:loading\.delay\.longer][wire\:loading\.delay\.longer],
        [wire\:loading\.delay\.longest][wire\:loading\.delay\.longest] {
            display: none;
        }

        [wire\:offline][wire\:offline] {
            display: none;
        }

        [wire\:dirty]:not(textarea):not(input):not(select) {
            display: none;
        }

        :root {
            --livewire-progress-bar-color: #2299dd;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
    <style>
        /* Make clicks pass-through */

        #nprogress {
            pointer-events: none;
        }

        #nprogress .bar {
            background: var(--livewire-progress-bar-color, #29d);

            position: fixed;
            z-index: 1031;
            top: 0;
            left: 0;

            width: 100%;
            height: 2px;
        }

        /* Fancy blur effect */
        #nprogress .peg {
            display: block;
            position: absolute;
            right: 0px;
            width: 100px;
            height: 100%;
            box-shadow: 0 0 10px var(--livewire-progress-bar-color, #29d), 0 0 5px var(--livewire-progress-bar-color, #29d);
            opacity: 1.0;

            -webkit-transform: rotate(3deg) translate(0px, -4px);
            -ms-transform: rotate(3deg) translate(0px, -4px);
            transform: rotate(3deg) translate(0px, -4px);
        }

        /* Remove these to get rid of the spinner */
        #nprogress .spinner {
            display: block;
            position: fixed;
            z-index: 1031;
            top: 15px;
            right: 15px;
        }

        #nprogress .spinner-icon {
            width: 18px;
            height: 18px;
            box-sizing: border-box;

            border: solid 2px transparent;
            border-top-color: var(--livewire-progress-bar-color, #29d);
            border-left-color: var(--livewire-progress-bar-color, #29d);
            border-radius: 50%;

            -webkit-animation: nprogress-spinner 400ms linear infinite;
            animation: nprogress-spinner 400ms linear infinite;
        }

        .nprogress-custom-parent {
            overflow: hidden;
            position: relative;
        }

        .nprogress-custom-parent #nprogress .spinner,
        .nprogress-custom-parent #nprogress .bar {
            position: absolute;
        }

        @-webkit-keyframes nprogress-spinner {
            0% {
                -webkit-transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes nprogress-spinner {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
    <style type="text/css">
        .layout-menu-fixed .layout-navbar-full .layout-menu,
        .layout-menu-fixed-offcanvas .layout-navbar-full .layout-menu {
            top: 0px !important;
        }

        .layout-page {
            padding-top: 0px !important;
        }

        .content-wrapper {
            padding-bottom: 0px !important;
        }
    </style>
    <style>
        /* Live background (optional, if you want an animated background) */
        .live-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            /*background: rgba(0, 0, 255, 0.1); !* Light blue for live effect *!*/
            border-radius: 10px;
            animation: pulse 2s infinite ease-in-out;
        }

        /* Animation for the signal icon (pulse effect) */
        .live-icon {
            animation: pulse 1.5s infinite ease-in-out;
        }

        /* Keyframes for pulse animation */
        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 0.8;
            }

            50% {
                transform: scale(1.2);
                opacity: 1;
            }

            100% {
                transform: scale(1);
                opacity: 0.8;
            }
        }

        /* Optional - If you want a circular live indicator */
        .live {
            display: inline-block;
            animation: pulse 1.5s infinite ease-in-out;
            border-radius: 50%;
            background-color: #00bfff;
            /* Light blue circle */
        }
    </style>
    <style>
        .custom.right {
            text-align: right;
        }

        .custom.left {
            text-align: left;
        }

        .custom-chat-container {
            width: 100%;
            max-width: 400px;
            height: 80vh;
            position: fixed;
            bottom: 0;
            right: 0;
            z-index: 1051;
            opacity: 0;
            transform: translateY(100%);
            transition: opacity .3s, transform .3s, box-shadow .3s;
            box-shadow: 0 0 10px rgba(0, 0, 0, .2);
            /*font-family: 'Inter', sans-serif;*/
        }

        @media (max-width: 768px) {
            .custom-chat-container {
                height: 100%;
                max-width: 100%;
            }
        }

        .custom-chat-container p,
        .custom-chat-container span {
            font-size: 13px !important;
            /*line-height: 1;*/
        }

        .custom-chat-container strong {
            font-size: 14px !important;
        }

        .custom-chat-container.active {
            opacity: 1;
            transform: translateY(0);
            box-shadow: 0 4px 12px rgba(0, 0, 0, .4)
        }

        .custom-chat-box {
            padding: 1rem;
            height: 100%;
            background-color: var(--bs-base);
            border-radius: 10px;
            overflow-y: auto;
            display: flex;
            flex-direction: column
        }

        .custom-chat-icon {
            display: flex;
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: var(--bs-primary);
            color: #fff;
            padding: .5rem;
            border-radius: 999px;
            cursor: pointer;
            transition: opacity .3s;
            z-index: 1051;
            gap: 0.5rem;
        }

        @media (max-width: 1200px) {
            .custom-chat-icon {
                bottom: 100px;
            }
        }

        .custom-chat-icon.hidden {
            opacity: 0.00001;
            visibility: hidden
        }

        .custom-chat-icon.visible {
            opacity: 1;
            visibility: visible
        }

        .custom-card-header {
            padding: .5rem 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center
        }

        .custom-card-body {
            padding: 1rem;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            flex-grow: 1
        }

        .custom-chat-box .custom-card-body::-webkit-scrollbar {
            width: 3px
        }

        .custom-chat-box .custom-card-body::-webkit-scrollbar-track {
            background: #3a3e4b;
            border-radius: 10px
        }

        .custom-chat-box .custom-card-body::-webkit-scrollbar-thumb {
            background-color: var(--bs-primary);
            border-radius: 10px;
            border: 2px solid transparent
        }

        .custom-chat-box .custom-card-body::-webkit-scrollbar-thumb:hover {
            background-color: #4a49b8
        }

        .custom-btn-primary {
            background-color: var(--bs-base);
            border: none;
            color: #fff;
            padding: .3rem 1rem;
            border-radius: 5px;
            cursor: pointer
        }

        .custom-btn-primary:hover {
            background-color: var(--bs-primary)
        }

        .custom-card-footer {
            padding: 1rem .5rem .5rem;
            background-color: var(--bs-base);
        }

        .custom-input-group {
            display: flex;
            border: 1px solid var(--bs-primary);
            border-radius: 5px;
            overflow: hidden
        }

        .custom-form-control {
            flex-grow: 1;
            border: none;
            padding: .5rem;
            background-color: #1d1e26;
            color: #fff
        }

        .custom-form-control:focus {
            outline: 0
        }

        .custom-input-group-text {
            background-color: var(--bs-primary);
            color: #fff;
            border: none;
            padding: .5rem 2rem;
            cursor: pointer
        }

        .custom-input-group-text:hover {
            background-color: #4a49b8
        }

        .custom-card-body .progress-circle {
            width: 45px !important;
            height: 45px !important;
        }

        .custom-card-body .progress-circle:before {
            width: 40px !important;
            height: 40px !important;
        }
    </style>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>

<body>
    <div id="preloader" class="hidden" style="display: none;">
        <div class="text-center">
            <a href="#">
                <svg fill="#01d676" width="35px" height="35px" viewBox="0 0 36 36" version="1.1"
                    preserveAspectRatio="xMidYMid meet" xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <title>coin-bag-solid</title>
                        <path
                            d="M24.89,26h7.86c-.66-8.71-4.41-14.12-9.22-17.32L25.72,3.9a1,1,0,0,0-.91-1.4H11.1a1,1,0,0,0-.91,1.4l1.2,2.6H21.51l-.9,2H18.76A24.9,24.9,0,0,1,20,13.19a24.49,24.49,0,0,1,.32,3l-1.58,1.11a22.54,22.54,0,0,0-.32-3.86A21.74,21.74,0,0,0,17,8.5h-1a28.22,28.22,0,0,0-2.48,3.7,23.91,23.91,0,0,0-1.49,3.46l-1.37-.91a22.78,22.78,0,0,1,1.47-3.34A30.81,30.81,0,0,1,14.05,8.5H12.3l.08.17C7.08,12.2,3.05,18.4,3.05,28.75A1.65,1.65,0,0,0,4.61,30.5h8A2.67,2.67,0,0,1,14.21,26a2.67,2.67,0,0,1-.37-1.34,2.7,2.7,0,0,1,2.7-2.7h6a2.7,2.7,0,0,1,2.7,2.7A2.63,2.63,0,0,1,24.89,26Z"
                            class="clr-i-solid clr-i-solid-path-1"></path>
                        <path d="M21.6,28.5a1,1,0,0,0-1-1h-6a1,1,0,0,0,0,2h6A1,1,0,0,0,21.6,28.5Z"
                            class="clr-i-solid clr-i-solid-path-2"></path>
                        <path d="M22.54,23.5h-6a1,1,0,0,0,0,2h6a1,1,0,0,0,0-2Z" class="clr-i-solid clr-i-solid-path-3">
                        </path>
                        <path d="M22,31.5H16a1,1,0,0,0,0,2h6a1,1,0,0,0,0-2Z" class="clr-i-solid clr-i-solid-path-4">
                        </path>
                        <path d="M32.7,31.5h-7a1,1,0,0,0,0,2h7a1,1,0,0,0,0-2Z" class="clr-i-solid clr-i-solid-path-5">
                        </path>
                        <path d="M33.7,27.5h-7a1,1,0,0,0,0,2h7a1,1,0,0,0,0-2Z" class="clr-i-solid clr-i-solid-path-6">
                        </path>
                        <rect x="0" y="0" width="36" height="36" fill-opacity="0"></rect>
                    </g>
                </svg>

                <span class="app-brand-text demo menu-text fw-bold text-center">
                    <img src="/assets/img/logo.png" alt="Logo">
                </span>
            </a>
            <div class="loader m-auto"></div>
        </div>
    </div>

    <!-- Buy Now Alert -->


    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">


            <!-- Layout container -->
            <div class="layout-page"
                x-data="{ is_coin: (typeof localStorage !== 'undefined' ? localStorage.getItem('isCoin') || '0' : '0') }"
                x-on:update-coins.window="is_coin = $event.detail.isCoin">

                <nav class="layout-navbar container-fluid navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                    id="layout-navbar">


                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">






                        <div class="">
                            <a class="" target="_blank" style="" href="">
                                <img src="/assets/img/homelogo.png" alt="" class="me-2" style="max-width:300px;">

                            </a>
                        </div>

                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            <button class="btn bg-primary bg-opacity-50 text-white f-md  d-md-block me-2"
                                data-bs-target="#authModal" data-signup="true" data-bs-toggle="modal">
                                <i class="fa-solid fa-arrow-right-to-bracket me-1" style="font-size: 16px"></i>
                                Sign In
                            </button>
                        </ul>
                    </div>
                </nav>
                <div wire:id="xQSLPf46GJ15svff3k9t">
                    <div wire:id="MIAI8RM2XOTr5sMzSGM7">
                        <div class="container-fluid" x-data="">
                            <div class="d-flex justify-content-start mt-2 small">
                                <div class="swiper"
                                    x-init="new window.swiper($el, { slidesPerView: 'auto', autoplay: { delay: 5000, disableOnInteraction: false } })">
                                    <div class="swiper-wrapper" wire:ignore.self>
                                        <?php
                                        function time_ago($ts)
                                        {
                                            $t = is_numeric($ts) ? (int) $ts : strtotime($ts);
                                            $diff = time() - $t;
                                            if ($diff < 60)
                                                return 'Just now';
                                            $units = [
                                                31536000 => 'year',
                                                2592000 => 'month',
                                                604800 => 'week',
                                                86400 => 'day',
                                                3600 => 'hour',
                                                60 => 'minute'
                                            ];
                                            foreach ($units as $sec => $name) {
                                                if ($diff >= $sec) {
                                                    $val = floor($diff / $sec);
                                                    return $val . ' ' . $name . ($val > 1 ? 's' : '') . ' ago';
                                                }
                                            }
                                            return 'Just now';
                                        }

                                        $offers = $db->QueryFetchArrayAll("
      SELECT a.id, a.campaign_name, a.reward, a.user_id, a.method, a.timestamp, b.username 
      FROM completed_offers a
      LEFT JOIN users b ON b.id = a.user_id
      WHERE a.status = '1'
    ");

                                        $withdrawals = $db->QueryFetchArrayAll("
      SELECT w.id, w.coins, w.amount, w.method_name, w.time, u.username, u.id AS user_id
      FROM withdrawals w
      LEFT JOIN users u ON u.id = w.user_id
      WHERE w.status != '0'
    ");

                                        if (!is_array($offers))
                                            $offers = [];
                                        if (!is_array($withdrawals))
                                            $withdrawals = [];

                                        $merged = [];
                                        foreach ($offers as $o) {
                                            $merged[] = [
                                                'type' => 'offer',
                                                'id' => $o['id'],
                                                'username' => $o['username'],
                                                'user_id' => $o['user_id'],
                                                'campaign' => $o['campaign_name'],
                                                'method' => $o['method'],
                                                'coins' => $o['reward'],
                                                'ts' => (int) $o['timestamp']
                                            ];
                                        }
                                        foreach ($withdrawals as $w) {
                                            $merged[] = [
                                                'type' => 'withdrawal',
                                                'id' => $w['id'],
                                                'username' => $w['username'],
                                                'user_id' => $w['user_id'],
                                                'campaign' => 'Withdrawal',
                                                'method' => $w['method_name'],
                                                'coins' => '-' . $w['coins'],
                                                'ts' => (int) $w['time']
                                            ];
                                        }

                                        usort($merged, function ($a, $b) {
                                            return $b['ts'] - $a['ts'];
                                        });

                                        foreach ($merged as $item):
                                            $username = htmlspecialchars($item['username']);
                                            $ago = time_ago($item['ts']);
                                            $coins = number_format((float) $item['coins']);
                                            ?>
                                            <div class="swiper-slide fade-in-scale card text-white me-2 p-2"
                                                style="cursor: pointer; width: auto !important;"
                                                data-username="<?= $username ?>" data-campaign="<?= $item['campaign'] ?>"
                                                data-coins="<?= $coins ?>" data-time="<?= $ago ?>"
                                                data-method="<?= $item['method'] ?>">
                                                <div class="card-body p-0 pb-0 text-center">
                                                    <div class="d-flex justify-content-center gap-2">
                                                        <div class="d-flex justify-content-center rounded-circle align-items-center bg-secondary bg-opacity-50 text-white"
                                                            style="width: 30px; height: 30px;">
                                                            <span
                                                                class="fw-bold"><?= strtoupper(substr($username, 0, 1)) ?></span>
                                                        </div>
                                                        <div class="d-flex flex-column text-start align-items-start">
                                                            <span class="mb-0 small"><?= $username ?></span>
                                                            <h6 class="text-secondary pb-0 mb-0"><?= $ago ?></h6>
                                                        </div>
                                                        <div class="p-1">
                                                            <span
                                                                class="rounded badge bg-secondary bg-opacity-50 text-white d-flex align-items-center gap-1"
                                                                style="line-height:0">
                                                                <img src="https://poketcash.com/assets/img/coin.png"
                                                                    width="11px" alt="">
                                                                <span><?= $coins ?></span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>

                                <!-- 🟢 مودال واحد بس -->
                                <div class="modal fade" id="activityModal" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalUsername"></h5>
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>Campaign:</strong> <span id="modalCampaign"></span></p>
                                                <p><strong>Coins:</strong> <span id="modalCoins"></span></p>
                                                <p><strong>Time:</strong> <span id="modalTime"></span></p>
                                                <p><strong>Method:</strong> <span id="modalMethod"></span></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    function initSwiper() {
                                        return new Swiper(".swiper", {
                                            slidesPerView: "auto",
                                            autoplay: {
                                                delay: 5000,
                                                disableOnInteraction: false
                                            },
                                            loop: false
                                        });
                                    }

                                    document.addEventListener("DOMContentLoaded", () => {
                                        initSwiper();

                                        document.querySelectorAll(".swiper-slide").forEach(card => {
                                            card.addEventListener("click", () => {
                                                document.getElementById("modalUsername").innerText = card.dataset.username;
                                                document.getElementById("modalCampaign").innerText = card.dataset.campaign;
                                                document.getElementById("modalCoins").innerText = card.dataset.coins;
                                                document.getElementById("modalTime").innerText = card.dataset.time;
                                                document.getElementById("modalMethod").innerText = card.dataset.method;

                                                new bootstrap.Modal(document.getElementById("activityModal")).show();
                                            });
                                        });
                                    });

                                    document.addEventListener("livewire:update", () => {
                                        initSwiper();
                                    });
                                </script>

                            </div>
                        </div>
                        <!-- Content wrapper -->
                        <div class="content-wrapper">
                            <!-- Content -->
                            <div class="container-fluid flex-grow-1 container-p-y">
                                <div wire:id="HieFwBVwvAeaLIZkpiYV">
                                    <div class="col-12">
                                        <div class="bg-b-csm"
                                            style="background-image: url('assets/img/background-1.webp'); z-index: -1">
                                        </div>
                                        <div class="d-flex justify-content-center fw-bolder text-center"
                                            style="font-size: 3rem; color: #fff; padding-top: 5rem">
                                            <div>
                                                <span class="text-primary">Get paid </span> for testing apps,<br>games
                                                &amp; surveys
                                                <div class="d-flex justify-content-center gap-2 row-gap-1 flex-wrap align-items-center mt-3"
                                                    style="font-size: 14px; text-transform: none; color: #636363">
                                                    <div class="d-flex align-items-center">
                                                        <span class="ms-1">Earn up to <strong
                                                                class="text-white">$60.00</strong> per offer</span>
                                                    </div>

                                                    <div class="d-flex align-items-center">
                                                        <i class="fa-solid fa-circle text-primary"
                                                            style="font-size: 9px"></i>
                                                        <span class="ms-1">
                                                            <strong class="text-white"
                                                                wire:init="loadAvailableOffersCount">40</strong>
                                                            available offers now
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="d-flex flex-column flex-xxl-row mt-5 justify-content-center"
                                            style="row-gap: 6rem; column-gap: 4rem;">
                                            <div class="">
                                                <div class="d-flex mt-4">
                                                    <div class="mt-4 home-offer-container justify-items-center m-auto">
                                                        <a class="card bg-dark bg-opacity-75 offer-card p-2"
                                                            data-bs-target="#authModal" data-bs-toggle="modal">
                                                            <div
                                                                class="card-img-block text-center align-items-center d-flex justify-content-center">
                                                                <img class="card-img-top rounded-3"
                                                                    style="width: 100%; height: 100%; object-fit: cover"
                                                                    src="/assets/img/offers/monopoly-go.webp" alt="">
                                                                <i class="fa-solid fa-play position-absolute text-white text-primary rounded-circle"
                                                                    style="background-color: rgba(30,190,105,0.25) !important"></i>
                                                            </div>
                                                            <div class="card-body p-0 pt-0 pb-3 small text-start">
                                                                <span
                                                                    class="text-truncate text-white d-block mt-2">MONOPOLY
                                                                    GO!</span>
                                                                <span
                                                                    class="text-truncate text-secondary d-block">Complete
                                                                    offers on Coinhub and earn a lot!</span>
                                                            </div>
                                                            <div
                                                                class="card-footer justify-content-between border-0 pt-0 pb-2 p-0 text-start">
                                                                <div class="f-w-600 text-white">
                                                                    <span class="d-flex align-items-end fw-bold"
                                                                        style="font-size: 17px; line-height: 16px">$268.<span
                                                                            style="font-size: 15px; line-height: 12px"
                                                                            class="fw-bold">84</span>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </a>
                                                        <a class="card bg-dark bg-opacity-75 offer-card p-2"
                                                            data-bs-target="#authModal" data-bs-toggle="modal">
                                                            <div
                                                                class="card-img-block text-center align-items-center d-flex justify-content-center">
                                                                <img class="card-img-top rounded-3"
                                                                    style="width: 100%; height: 100%; object-fit: cover"
                                                                    src="/assets/img/offers/pop-world.png" alt="">
                                                                <i class="fa-solid fa-play position-absolute text-white text-primary rounded-circle"
                                                                    style="background-color: rgba(30,190,105,0.25) !important"></i>
                                                            </div>
                                                            <div class="card-body p-0 pt-0 pb-3 small text-start">
                                                                <span class="text-truncate text-white d-block mt-2">Pop
                                                                    World Mania: Puzzle Game - Android</span>
                                                                <span
                                                                    class="text-truncate text-secondary d-block">Complete
                                                                    offers on Coinhub and earn a lot!</span>
                                                            </div>
                                                            <div
                                                                class="card-footer justify-content-between border-0 pt-0 pb-2 p-0 text-start">
                                                                <div class="f-w-600 text-white">
                                                                    <span class="d-flex align-items-end fw-bold"
                                                                        style="font-size: 17px; line-height: 16px">$1.<span
                                                                            style="font-size: 14px; line-height: 12px"
                                                                            class="fw-bold">22</span>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </a>
                                                        <a class="card bg-dark bg-opacity-75 offer-card p-2"
                                                            data-bs-target="#authModal" data-bs-toggle="modal">
                                                            <div
                                                                class="card-img-block text-center align-items-center d-flex justify-content-center">
                                                                <img class="card-img-top rounded-3"
                                                                    style="width: 100%; height: 100%; object-fit: cover"
                                                                    src="/assets/img/offers/exness-global.png" alt="">
                                                                <i class="fa-solid fa-play position-absolute text-white text-primary rounded-circle"
                                                                    style="background-color: rgba(30,190,105,0.25) !important"></i>
                                                            </div>
                                                            <div class="card-body p-0 pt-0 pb-3 small text-start">
                                                                <span
                                                                    class="text-truncate text-white d-block mt-2">Exness
                                                                    Global – trading app - Android</span>
                                                                <span
                                                                    class="text-truncate text-secondary d-block">Complete
                                                                    offers on Coinhub and earn a lot!</span>
                                                            </div>
                                                            <div
                                                                class="card-footer justify-content-between border-0 pt-0 pb-2 p-0 text-start">
                                                                <div class="f-w-600 text-white">

                                                                    <span class="d-flex align-items-end fw-bold"
                                                                        style="font-size: 17px; line-height: 16px">$0.<span
                                                                            style="font-size: 14px; line-height: 12px"
                                                                            class="fw-bold">49</span>
                                                                    </span>

                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="">
                                                <div class="card m-auto"
                                                    style="width: 30rem; border-radius: 20px; max-width: 100%">
                                                    <div class="card-body" style="padding: 1.5rem !important;">
                                                        <div class="text-center">
                                                            <span class="text-body fs-4 fw-bold">Sign up for free</span>
                                                            <p class="text-secondary fw-medium">and Earn up to daily $50
                                                                for free</p>
                                                        </div>
                                                        <form method="POST" id="registerForm"
                                                            class="row g-3 needs-validation" novalidate>
                                                            <div id="registerStatus"></div>
                                                            <input type="hidden" id="registerToken"
                                                                value="<?php echo $token; ?>" />

                                                            <!-- Username -->
                                                            <div class="col-12">
                                                                <label for="regUser" class="form-label">Username</label>
                                                                <input type="text" class="form-control" id="regUser"
                                                                    name="username" required>
                                                            </div>

                                                            <!-- Email -->
                                                            <div class="col-12">
                                                                <label for="regEmail" class="form-label">Email</label>
                                                                <input type="email" class="form-control" id="regEmail"
                                                                    name="email" required>
                                                            </div>

                                                            <!-- Gender -->
                                                            <div class="col-12">
                                                                <label for="regGender" class="form-label">Gender</label>
                                                                <select class="form-control" id="regGender"
                                                                    name="gender" required>
                                                                    <option value="" disabled selected>-- Please Select
                                                                        --</option>
                                                                    <option value="1">Male</option>
                                                                    <option value="2">Female</option>
                                                                </select>
                                                            </div>

                                                            <!-- Password -->
                                                            <div class="col-12">
                                                                <label for="regPass" class="form-label">Password</label>
                                                                <input type="password" class="form-control" id="regPass"
                                                                    name="password" required>
                                                            </div>

                                                            <!-- Terms -->
                                                            <div class="col-12">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        id="tos" name="tos" value="1" required>
                                                                    <label class="form-check-label" for="tos">
                                                                        I agree with Terms & Conditions
                                                                    </label>
                                                                </div>
                                                            </div>

                                                            <!-- Submit -->
                                                            <div class="col-12">
                                                                <button type="submit"
                                                                    class="btn btn-primary w-100">Register</button>
                                                            </div>
                                                        </form>

                                                        <script
                                                            src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                                        <script>
                                                            $(function () {
                                                                $("#registerForm").on("submit", function (e) {
                                                                    e.preventDefault();

                                                                    $.ajax({
                                                                        url: "system/ajax.php",
                                                                        method: "POST",
                                                                        dataType: "json",
                                                                        data: {
                                                                            a: "register",
                                                                            username: $("#regUser").val(),
                                                                            email: $("#regEmail").val(),
                                                                            gender: $("#regGender").val(),
                                                                            password: $("#regPass").val(),
                                                                            tos: $("#tos").is(":checked") ? 1 : 0,
                                                                            token: $("#registerToken").val()
                                                                        },
                                                                        success: function (res) {
                                                                            $("#registerStatus").html(res.msg);

                                                                            if (res.status == 1 && res.loggedin == 1) {
                                                                                // لو التسجيل نجح وعمل login أوتوماتيك
                                                                                setTimeout(function () { window.location.href = "index.php"; }, 1500);
                                                                            } else if (res.status == 1 && res.loggedin == 0) {
                                                                                // لو محتاج تفعيل إيميل
                                                                                setTimeout(function () { window.location.href = "login.php"; }, 2000);
                                                                            }
                                                                        }
                                                                    });
                                                                });
                                                            });
                                                        </script>



                                                        <div class="divider my-2">
                                                            <div class="divider-text">or</div>
                                                        </div>

                                                        <a href="auth/google"
                                                            class="btn btn-dark d-flex align-items-center w-100 waves-effect waves-light">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="18"
                                                                height="18" viewBox="0 0 28 28" fill="none">
                                                                <g clip-path="url(#clip0_436_15312)">
                                                                    <path
                                                                        d="M6.20539 16.9208L5.23075 20.5592L1.66846 20.6346C0.603859 18.66 0 16.4008 0 14C0 11.6785 0.564594 9.48921 1.56537 7.56153L4.73758 8.14297L6.12686 11.2954C5.83609 12.1431 5.6776 13.0531 5.6776 14C5.67771 15.0277 5.86387 16.0123 6.20539 16.9208Z"
                                                                        fill="#FFC700"></path>
                                                                    <path
                                                                        d="M27.7554 11.3846C27.9162 12.2315 28 13.1061 28 14C28 15.0023 27.8946 15.98 27.6939 16.9231C27.0123 20.1323 25.2316 22.9346 22.7647 24.9177L22.7639 24.9169L18.7693 24.7131L18.2039 21.1839C19.8408 20.2239 21.1201 18.7216 21.794 16.9231H14.3078V11.3846H27.7554Z"
                                                                        fill="#518EF8"></path>
                                                                    <path
                                                                        d="M22.7639 24.9169L22.7647 24.9177C20.3655 26.8461 17.3177 28 14 28C8.66846 28 4.03309 25.02 1.66846 20.6346L6.20539 16.9208C7.38768 20.0761 10.4315 22.3223 14 22.3223C15.5338 22.3223 16.9709 21.9077 18.2039 21.1839L22.7639 24.9169Z"
                                                                        fill="#01D676"></path>
                                                                    <path
                                                                        d="M22.9362 3.22306L18.4008 6.93613C17.1246 6.13845 15.6161 5.67766 14 5.67766C10.3508 5.67766 7.24992 8.02687 6.12686 11.2954L1.56537 7.56153C3.89539 3.06923 8.58922 0 14 0C17.3969 0 20.5115 1.21002 22.9362 3.22306Z"
                                                                        fill="#C34646"></path>
                                                                </g>
                                                                <defs>
                                                                    <clipPath id="clip0_436_15312">
                                                                        <rect width="28" height="28" fill="white">
                                                                        </rect>
                                                                    </clipPath>
                                                                </defs>
                                                            </svg>
                                                            <span class="ms-2">Sign In with Google</span>
                                                        </a>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    </div>


                                    <div class="bg-b-csm">
                                        <img src="/assets/img/emojis-spliter.webp"
                                            style="width: 100%; height: 100%; object-fit: cover" alt="">
                                    </div>

                                    <div class="container">


                                       
                                        <div class="row" style="margin-top: 6rem;">
                                            <h2 class="text-center text-primary fw-bolder">Frequently Asked Questions
                                            </h2>
                                            <p class="text-center">Have a question? Check out our FAQ section to find
                                                answers to the most common
                                                questions.</p>

                                            <!-- Nav tabs -->
                                            <ul class="nav nav-pills" id="faqTab" role="tablist">
                                                <!--[if BLOCK]><![endif]-->
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link d-flex align-items-center active"
                                                        style="border-radius: 20px;" id="general-tab"
                                                        data-bs-toggle="tab" href="#general" role="tab"
                                                        aria-controls="general" aria-selected="true">
                                                        General
                                                    </button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link d-flex align-items-center "
                                                        style="border-radius: 20px;" id="earn-tab" data-bs-toggle="tab"
                                                        href="#earn" role="tab" aria-controls="earn"
                                                        aria-selected="false">
                                                        Earn
                                                    </button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link d-flex align-items-center "
                                                        style="border-radius: 20px;" id="withdraw-tab"
                                                        data-bs-toggle="tab" href="#withdraw" role="tab"
                                                        aria-controls="withdraw" aria-selected="false">
                                                        Withdraw
                                                    </button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link d-flex align-items-center "
                                                        style="border-radius: 20px;" id="account-tab"
                                                        data-bs-toggle="tab" href="#account" role="tab"
                                                        aria-controls="account" aria-selected="false">
                                                        Account
                                                    </button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link d-flex align-items-center "
                                                        style="border-radius: 20px;" id="policies-tab"
                                                        data-bs-toggle="tab" href="#policies" role="tab"
                                                        aria-controls="policies" aria-selected="false">
                                                        Policies
                                                    </button>
                                                </li>
                                                <!--[if ENDBLOCK]><![endif]-->
                                            </ul>

                                            <!-- Tab content -->
                                            <div class="tab-content p-0 mt-3 position-relative" id="faqTabContent">
                                                <!--[if BLOCK]><![endif]-->
                                                <div class="tab-pane fade show active" id="general" role="tabpanel"
                                                    aria-labelledby="general-tab">
                                                    <div class="accordion">
                                                        <!--[if BLOCK]><![endif]-->
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header">
                                                                <button class="accordion-button f-md text-white"
                                                                    type="button" style="border-radius: 20px;"
                                                                    data-bs-toggle="collapse" data-bs-target="#as-0">
                                                                    Are surveys reliable?
                                                                </button>
                                                            </h2>
                                                            <div id="as-0" class="accordion-collapse collapse show">
                                                                <div class="accordion-body small">
                                                                    All surveys on Coinhub are secure. Any information
                                                                    you provide in the surveys is kept anonymous, and
                                                                    the survey providers implement numerous measures to
                                                                    guarantee the safety of the surveys. We do not have
                                                                    access to the details you enter, as only the survey
                                                                    administrators can view and manage this information.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header">
                                                                <button class="accordion-button f-md text-white"
                                                                    type="button" style="border-radius: 20px;"
                                                                    data-bs-toggle="collapse" data-bs-target="#as-1">
                                                                    What steps do I need to take to begin?
                                                                </button>
                                                            </h2>
                                                            <div id="as-1" class="accordion-collapse collapse ">
                                                                <div class="accordion-body small">
                                                                    Getting started with Coinhub is simple and quick!
                                                                    You can register by entering your email or by using
                                                                    your Google or Steam account. Once registered,
                                                                    navigate to the "Tasks" page where you’ll find a
                                                                    variety of tasks to complete. Just pick the offers
                                                                    you wish to take on to begin.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header">
                                                                <button class="accordion-button f-md text-white"
                                                                    type="button" style="border-radius: 20px;"
                                                                    data-bs-toggle="collapse" data-bs-target="#as-2">
                                                                    What exactly are coins?
                                                                </button>
                                                            </h2>
                                                            <div id="as-2" class="accordion-collapse collapse ">
                                                                <div class="accordion-body small">
                                                                    coins serve as the currency within Coinhub,
                                                                    reflecting your account balance. They can also be
                                                                    represented in U.S. dollars, where 1000 coins equate
                                                                    to $1.00.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header">
                                                                <button class="accordion-button f-md text-white"
                                                                    type="button" style="border-radius: 20px;"
                                                                    data-bs-toggle="collapse" data-bs-target="#as-3">
                                                                    What are the rules for chat?
                                                                </button>
                                                            </h2>
                                                            <div id="as-3" class="accordion-collapse collapse ">
                                                                <div class="accordion-body small">
                                                                    Please refrain from advertising or spamming,
                                                                    including sharing referral links. Stick to English
                                                                    in the chat, except in designated language channels.
                                                                    Avoid harassment, insults, or provocation towards
                                                                    others. Do not share inappropriate links, and please
                                                                    do not beg or solicit money. Violating these chat
                                                                    guidelines could lead to your account being muted or
                                                                    even suspended temporarily or permanently.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header">
                                                                <button class="accordion-button f-md text-white"
                                                                    type="button" style="border-radius: 20px;"
                                                                    data-bs-toggle="collapse" data-bs-target="#as-4">
                                                                    What is Coinhub all about?
                                                                </button>
                                                            </h2>
                                                            <div id="as-4" class="accordion-collapse collapse ">
                                                                <div class="accordion-body small">
                                                                    Coinhub is an online platform that allows you to
                                                                    earn money by using applications and participating
                                                                    in surveys. We collaborate with top market research
                                                                    firms and apps to facilitate your online earning
                                                                    experience. coins you earn on EarnLab can be
                                                                    redeemed for PayPal credits, cryptocurrency, gift
                                                                    cards, and more.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header">
                                                                <button class="accordion-button f-md text-white"
                                                                    type="button" style="border-radius: 20px;"
                                                                    data-bs-toggle="collapse" data-bs-target="#as-5">
                                                                    Who manages the offer/survey walls displayed?
                                                                </button>
                                                            </h2>
                                                            <div id="as-5" class="accordion-collapse collapse ">
                                                                <div class="accordion-body small">
                                                                    Coinhub partners with leading market research firms
                                                                    to provide our users with a comprehensive array of
                                                                    offers and surveys. We act as a mediator, enabling
                                                                    you to earn money online effortlessly.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--[if ENDBLOCK]><![endif]-->
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade " id="earn" role="tabpanel"
                                                    aria-labelledby="earn-tab">
                                                    <div class="accordion">
                                                        <!--[if BLOCK]><![endif]-->
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header">
                                                                <button class="accordion-button f-md text-white"
                                                                    type="button" style="border-radius: 20px;"
                                                                    data-bs-toggle="collapse" data-bs-target="#as-0">
                                                                    What is the best way to earn coins?
                                                                </button>
                                                            </h2>
                                                            <div id="as-0" class="accordion-collapse collapse show">
                                                                <div class="accordion-body small">
                                                                    To maximize your coins earnings, we recommend
                                                                    focusing on our "Featured Tasks" which provide
                                                                    substantial rewards. Visit the "Tasks" page, where
                                                                    you can explore numerous tasks to complete. Choose
                                                                    the ones that interest you to get started.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header">
                                                                <button class="accordion-button f-md text-white"
                                                                    type="button" style="border-radius: 20px;"
                                                                    data-bs-toggle="collapse" data-bs-target="#as-1">
                                                                    Where can I fill out surveys?
                                                                </button>
                                                            </h2>
                                                            <div id="as-1" class="accordion-collapse collapse ">
                                                                <div class="accordion-body small">
                                                                    Surveys can be completed on both your PC and mobile
                                                                    devices. Simply head over to our "Earn" page to find
                                                                    all available survey providers.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header">
                                                                <button class="accordion-button f-md text-white"
                                                                    type="button" style="border-radius: 20px;"
                                                                    data-bs-toggle="collapse" data-bs-target="#as-2">
                                                                    Why did I receive fewer coins than promised?
                                                                </button>
                                                            </h2>
                                                            <div id="as-2" class="accordion-collapse collapse ">
                                                                <div class="accordion-body small">
                                                                    You might have been disqualified from completing a
                                                                    survey. Some offer walls still provide a few coins
                                                                    for your efforts, even if you don't qualify.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header">
                                                                <button class="accordion-button f-md text-white"
                                                                    type="button" style="border-radius: 20px;"
                                                                    data-bs-toggle="collapse" data-bs-target="#as-3">
                                                                    Why didn’t I receive any coins for my survey?
                                                                </button>
                                                            </h2>
                                                            <div id="as-3" class="accordion-collapse collapse ">
                                                                <div class="accordion-body small">
                                                                    Several factors could result in no coins being
                                                                    awarded. You may have been disqualified during the
                                                                    survey. If a survey was incorrectly configured, it
                                                                    may affect payment. Additionally, payouts might be
                                                                    delayed. Check your transaction history, and if you
                                                                    still haven't received your coins, reach out to the
                                                                    support team of the offer wall.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header">
                                                                <button class="accordion-button f-md text-white"
                                                                    type="button" style="border-radius: 20px;"
                                                                    data-bs-toggle="collapse" data-bs-target="#as-4">
                                                                    Why is my completed task on hold?
                                                                </button>
                                                            </h2>
                                                            <div id="as-4" class="accordion-collapse collapse ">
                                                                <div class="accordion-body small">
                                                                    Certain tasks may be automatically held based on
                                                                    various criteria like account status and task value.
                                                                    However, you can provide proof of completion through
                                                                    our live support to expedite the release of your
                                                                    hold.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--[if ENDBLOCK]><![endif]-->
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade " id="withdraw" role="tabpanel"
                                                    aria-labelledby="withdraw-tab">
                                                    <div class="accordion">
                                                        <!--[if BLOCK]><![endif]-->
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header">
                                                                <button class="accordion-button f-md text-white"
                                                                    type="button" style="border-radius: 20px;"
                                                                    data-bs-toggle="collapse" data-bs-target="#as-0">
                                                                    How do I withdraw my coins?
                                                                </button>
                                                            </h2>
                                                            <div id="as-0" class="accordion-collapse collapse show">
                                                                <div class="accordion-body small">
                                                                    To withdraw your coins, navigate to the "Withdraw"
                                                                    section in your account dashboard. From there,
                                                                    select your preferred withdrawal method, enter the
                                                                    required information, and confirm your withdrawal.
                                                                    Please ensure that your account is verified to
                                                                    facilitate the process.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header">
                                                                <button class="accordion-button f-md text-white"
                                                                    type="button" style="border-radius: 20px;"
                                                                    data-bs-toggle="collapse" data-bs-target="#as-1">
                                                                    How long does a withdrawal take?
                                                                </button>
                                                            </h2>
                                                            <div id="as-1" class="accordion-collapse collapse ">
                                                                <div class="accordion-body small">
                                                                    Withdrawal times vary depending on the method
                                                                    chosen. Typically, e-wallet withdrawals are
                                                                    processed within 24 hours, while bank transfers may
                                                                    take up to 3-5 business days. You can check the
                                                                    status of your withdrawal in the "Transaction
                                                                    History" section.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header">
                                                                <button class="accordion-button f-md text-white"
                                                                    type="button" style="border-radius: 20px;"
                                                                    data-bs-toggle="collapse" data-bs-target="#as-2">
                                                                    Where can I find my voucher codes?
                                                                </button>
                                                            </h2>
                                                            <div id="as-2" class="accordion-collapse collapse ">
                                                                <div class="accordion-body small">
                                                                    Your voucher codes can be found in the "Vouchers"
                                                                    section of your account. If you have received
                                                                    promotional codes through email or notifications,
                                                                    you can also view them in your inbox or
                                                                    notifications panel.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--[if ENDBLOCK]><![endif]-->
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade " id="account" role="tabpanel"
                                                    aria-labelledby="account-tab">
                                                    <div class="accordion">
                                                        <!--[if BLOCK]><![endif]-->
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header">
                                                                <button class="accordion-button f-md text-white"
                                                                    type="button" style="border-radius: 20px;"
                                                                    data-bs-toggle="collapse" data-bs-target="#as-0">
                                                                    How do I get verified?
                                                                </button>
                                                            </h2>
                                                            <div id="as-0" class="accordion-collapse collapse show">
                                                                <div class="accordion-body small">
                                                                    To get verified, you need to complete the
                                                                    verification process in your account settings. This
                                                                    usually involves providing personal information and
                                                                    uploading necessary documents such as a
                                                                    government-issued ID and proof of address. Once
                                                                    submitted, our team will review your application,
                                                                    and you will be notified of the status via email.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header">
                                                                <button class="accordion-button f-md text-white"
                                                                    type="button" style="border-radius: 20px;"
                                                                    data-bs-toggle="collapse" data-bs-target="#as-1">
                                                                    Why is my balance in the negatives (-)?
                                                                </button>
                                                            </h2>
                                                            <div id="as-1" class="accordion-collapse collapse ">
                                                                <div class="accordion-body small">
                                                                    A negative balance usually indicates that you have
                                                                    incurred fees or penalties that exceed your
                                                                    available balance. This could be due to recent
                                                                    transactions, withdrawals, or account maintenance
                                                                    fees. To resolve this, please review your
                                                                    transaction history and ensure that your account is
                                                                    in good standing.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--[if ENDBLOCK]><![endif]-->
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade " id="policies" role="tabpanel"
                                                    aria-labelledby="policies-tab">
                                                    <div class="accordion">
                                                        <!--[if BLOCK]><![endif]-->
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header">
                                                                <button class="accordion-button f-md text-white"
                                                                    type="button" style="border-radius: 20px;"
                                                                    data-bs-toggle="collapse" data-bs-target="#as-0">
                                                                    Am I authorized to have multiple accounts?
                                                                </button>
                                                            </h2>
                                                            <div id="as-0" class="accordion-collapse collapse show">
                                                                <div class="accordion-body small">
                                                                    Typically, having multiple accounts is against our
                                                                    policy as it can lead to unfair advantages and
                                                                    disrupt the integrity of our platform. If you have
                                                                    specific circumstances that require multiple
                                                                    accounts, please contact our support team for
                                                                    clarification and approval.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header">
                                                                <button class="accordion-button f-md text-white"
                                                                    type="button" style="border-radius: 20px;"
                                                                    data-bs-toggle="collapse" data-bs-target="#as-1">
                                                                    Can I run surveys on behalf of other users?
                                                                </button>
                                                            </h2>
                                                            <div id="as-1" class="accordion-collapse collapse ">
                                                                <div class="accordion-body small">
                                                                    Running surveys on behalf of other users is
                                                                    generally prohibited. Each user must complete
                                                                    surveys using their own account to ensure accurate
                                                                    and fair results. Violating this policy may result
                                                                    in account suspension or termination.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header">
                                                                <button class="accordion-button f-md text-white"
                                                                    type="button" style="border-radius: 20px;"
                                                                    data-bs-toggle="collapse" data-bs-target="#as-2">
                                                                    Am I allowed to use VPNs?
                                                                </button>
                                                            </h2>
                                                            <div id="as-2" class="accordion-collapse collapse ">
                                                                <div class="accordion-body small">
                                                                    Using VPNs is not allowed as it can lead to account
                                                                    verification issues and potential abuse of our
                                                                    platform. We recommend accessing our services from
                                                                    your original IP address to avoid any complications.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--[if ENDBLOCK]><![endif]-->
                                                    </div>
                                                </div>
                                                <!--[if ENDBLOCK]><![endif]-->
                                            </div>

                                        </div>

                                        <div class="row justify-content-center" style="margin-top: 6rem;">
                                            <div class="text-center">
                                                <h2 class="text-primary fw-bolder">Ready to earn? Here's how!</h2>
                                                <p class="text-body">Earning on Coinhub is a total blast watch your
                                                    profits
                                                    skyrocket
                                                    to new heights!</p>
                                            </div>

                                            <div class="col-md-12 col-lg-12 rounded">
                                                <div class="row justify-content-center row-gap-3">
                                                    <div class="col-md-4">
                                                        <div class="card h-100" style="border-radius: 25px;">
                                                            <div
                                                                class="card-body px-0 d-flex flex-column align-items-center justify-content-center gap-1 text-center">
                                                                <svg width="100px" height="100px" viewBox="0 0 24 24"
                                                                    fill="none" class="mb-2 pop-in"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                                        stroke-linejoin="round"></g>
                                                                    <g id="SVGRepo_iconCarrier">
                                                                        <path opacity="0.5"
                                                                            d="M3 10.4167C3 7.21907 3 5.62028 3.37752 5.08241C3.75503 4.54454 5.25832 4.02996 8.26491 3.00079L8.83772 2.80472C10.405 2.26824 11.1886 2 12 2C12.8114 2 13.595 2.26824 15.1623 2.80472L15.7351 3.00079C18.7417 4.02996 20.245 4.54454 20.6225 5.08241C21 5.62028 21 7.21907 21 10.4167V11.9914C21 17.6294 16.761 20.3655 14.1014 21.5273C13.38 21.8424 13.0193 22 12 22C10.9807 22 10.62 21.8424 9.89856 21.5273C7.23896 20.3655 3 17.6294 3 11.9914V10.4167Z"
                                                                            fill="var(--bs-primary)"></path>
                                                                        <path
                                                                            d="M14 9C14 10.1046 13.1046 11 12 11C10.8954 11 10 10.1046 10 9C10 7.89543 10.8954 7 12 7C13.1046 7 14 7.89543 14 9Z"
                                                                            fill="var(--bs-primary)"></path>
                                                                        <path
                                                                            d="M12 17C16 17 16 16.1046 16 15C16 13.8954 14.2091 13 12 13C9.79086 13 8 13.8954 8 15C8 16.1046 8 17 12 17Z"
                                                                            fill="var(--bs-primary)"></path>
                                                                    </g>
                                                                </svg>

                                                                <p class="text-white fw-medium fs-4">Create Account</p>
                                                                <p class="text-secondary" style="max-width: 95%">
                                                                    Sign up for free and become a part of our growing
                                                                    community. Start earning
                                                                    rewards right away!
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="card h-100" style="border-radius: 25px;">
                                                            <div
                                                                class="card-body px-0 d-flex flex-column align-items-center justify-content-center gap-1 text-center">
                                                                <svg width="100px" height="100px" viewBox="0 0 24 24"
                                                                    fill="none" class="mb-2 pop-in"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                                        stroke-linejoin="round"></g>
                                                                    <g id="SVGRepo_iconCarrier">
                                                                        <path opacity="0.5"
                                                                            d="M21 15.9983V9.99826C21 7.16983 21 5.75562 20.1213 4.87694C19.3529 4.10856 18.175 4.01211 16 4H8C5.82497 4.01211 4.64706 4.10856 3.87868 4.87694C3 5.75562 3 7.16983 3 9.99826V15.9983C3 18.8267 3 20.2409 3.87868 21.1196C4.75736 21.9983 6.17157 21.9983 9 21.9983H15C17.8284 21.9983 19.2426 21.9983 20.1213 21.1196C21 20.2409 21 18.8267 21 15.9983Z"
                                                                            fill="var(--bs-primary)"></path>
                                                                        <path
                                                                            d="M8 3.5C8 2.67157 8.67157 2 9.5 2H14.5C15.3284 2 16 2.67157 16 3.5V4.5C16 5.32843 15.3284 6 14.5 6H9.5C8.67157 6 8 5.32843 8 4.5V3.5Z"
                                                                            fill="var(--bs-primary)"></path>
                                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                                            d="M6.25 10.5C6.25 10.0858 6.58579 9.75 7 9.75H7.5C7.91421 9.75 8.25 10.0858 8.25 10.5C8.25 10.9142 7.91421 11.25 7.5 11.25H7C6.58579 11.25 6.25 10.9142 6.25 10.5ZM9.75 10.5C9.75 10.0858 10.0858 9.75 10.5 9.75H17C17.4142 9.75 17.75 10.0858 17.75 10.5C17.75 10.9142 17.4142 11.25 17 11.25H10.5C10.0858 11.25 9.75 10.9142 9.75 10.5ZM6.25 14C6.25 13.5858 6.58579 13.25 7 13.25H7.5C7.91421 13.25 8.25 13.5858 8.25 14C8.25 14.4142 7.91421 14.75 7.5 14.75H7C6.58579 14.75 6.25 14.4142 6.25 14ZM9.75 14C9.75 13.5858 10.0858 13.25 10.5 13.25H17C17.4142 13.25 17.75 13.5858 17.75 14C17.75 14.4142 17.4142 14.75 17 14.75H10.5C10.0858 14.75 9.75 14.4142 9.75 14ZM6.25 17.5C6.25 17.0858 6.58579 16.75 7 16.75H7.5C7.91421 16.75 8.25 17.0858 8.25 17.5C8.25 17.9142 7.91421 18.25 7.5 18.25H7C6.58579 18.25 6.25 17.9142 6.25 17.5ZM9.75 17.5C9.75 17.0858 10.0858 16.75 10.5 16.75H17C17.4142 16.75 17.75 17.0858 17.75 17.5C17.75 17.9142 17.4142 18.25 17 18.25H10.5C10.0858 18.25 9.75 17.9142 9.75 17.5Z"
                                                                            fill="var(--bs-primary)"></path>
                                                                    </g>
                                                                </svg>
                                                                <p class="text-white fw-medium fs-4">Complete Offers</p>
                                                                <p class="text-secondary" style="max-width: 95%">
                                                                    Choose from a wide variety of offers—play games,
                                                                    take surveys, or explore
                                                                    apps to start earning.
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="card h-100" style="border-radius: 25px;">
                                                            <div
                                                                class="card-body px-0 d-flex flex-column align-items-center justify-content-center gap-1 text-center">
                                                                <svg width="100px" height="100px" viewBox="0 0 24 24"
                                                                    fill="none" class="mb-2 pop-in"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                                        stroke-linejoin="round"></g>
                                                                    <g id="SVGRepo_iconCarrier">
                                                                        <path
                                                                            d="M5.75 7C5.33579 7 5 7.33579 5 7.75C5 8.16421 5.33579 8.5 5.75 8.5H9.75C10.1642 8.5 10.5 8.16421 10.5 7.75C10.5 7.33579 10.1642 7 9.75 7H5.75Z"
                                                                            fill="var(--bs-primary)"></path>
                                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                                            d="M21.1884 8.00377C21.1262 7.99995 21.0584 7.99998 20.9881 8L20.9706 8.00001H18.2149C15.9435 8.00001 14 9.73607 14 12C14 14.2639 15.9435 16 18.2149 16H20.9706L20.9881 16C21.0584 16 21.1262 16 21.1884 15.9962C22.111 15.9397 22.927 15.2386 22.9956 14.2594C23.0001 14.1952 23 14.126 23 14.0619L23 14.0444V9.95556L23 9.93815C23 9.874 23.0001 9.80479 22.9956 9.74058C22.927 8.76139 22.111 8.06034 21.1884 8.00377ZM17.9706 13.0667C18.5554 13.0667 19.0294 12.5891 19.0294 12C19.0294 11.4109 18.5554 10.9333 17.9706 10.9333C17.3858 10.9333 16.9118 11.4109 16.9118 12C16.9118 12.5891 17.3858 13.0667 17.9706 13.0667Z"
                                                                            fill="var(--bs-primary)"></path>
                                                                        <path opacity="0.5"
                                                                            d="M21.1394 8.00152C21.1394 6.82091 21.0965 5.55447 20.3418 4.64658C20.2689 4.55894 20.1914 4.47384 20.1088 4.39124C19.3604 3.64288 18.4114 3.31076 17.239 3.15314C16.0998 2.99997 14.6442 2.99999 12.8064 3H10.6936C8.85583 2.99999 7.40019 2.99997 6.26098 3.15314C5.08856 3.31076 4.13961 3.64288 3.39124 4.39124C2.64288 5.13961 2.31076 6.08856 2.15314 7.26098C1.99997 8.40019 1.99999 9.85581 2 11.6936V11.8064C1.99999 13.6442 1.99997 15.0998 2.15314 16.239C2.31076 17.4114 2.64288 18.3604 3.39124 19.1088C4.13961 19.8571 5.08856 20.1892 6.26098 20.3469C7.40018 20.5 8.8558 20.5 10.6935 20.5H12.8064C14.6442 20.5 16.0998 20.5 17.239 20.3469C18.4114 20.1892 19.3604 19.8571 20.1088 19.1088C20.3133 18.9042 20.487 18.6844 20.6346 18.4486C21.0851 17.7291 21.1394 16.8473 21.1394 15.9985C21.0912 16 21.0404 16 20.9882 16L18.2149 16C15.9435 16 14 14.2639 14 12C14 9.73607 15.9435 8.00001 18.2149 8.00001L20.9881 8.00001C21.0403 7.99999 21.0912 7.99997 21.1394 8.00152Z"
                                                                            fill="var(--bs-primary)"></path>
                                                                    </g>
                                                                </svg>
                                                                <p class="text-white fw-medium fs-4">Earn Coins</p>
                                                                <p class="text-secondary" style="max-width: 95%">
                                                                    Collect coins for every task you complete 1000 coins
                                                                    = $1 USD. Track your
                                                                    progress easily in your dashboard.
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>









                                        <div class="row justify-content-center" style="margin-top: 6rem;"
                                            wire:ignore="">
                                            <h2 class="text-center text-primary fw-bolder">Providers</h2>
                                            <p class="text-center">We work with the best providers to ensure you have
                                                the best experience</p>

                                            <div class="w-100" style="background: var(--bs-base); border-radius: 20px">

                                                <!-- Bootstrap Carousel -->
                                                <div class="partner-slider p-5">
                                                    <div class="partner-track">
                                                        <!--[if BLOCK]><![endif]-->
                                                        <div class="partner-logo">
                                                            <img src="storage/01JNVYNMWN7KRYN950QEVVJ1Y7.svg"
                                                                alt="Bitlabs">
                                                        </div>
                                                        <div class="partner-logo">
                                                            <img src="storage/01JNVYN2Q3HR3H0ER6T1NDGR8F.png"
                                                                alt="Torox">
                                                        </div>
                                                        <div class="partner-logo">
                                                            <img src="storage/01JNVYNYA7GF4V1P46MKYDG7GM.png"
                                                                alt="Monlix">
                                                        </div>
                                                        <div class="partner-logo">
                                                            <img src="storage/01JNVYP6SGFYBKP8V2E72TGVAC.png"
                                                                alt="Adgem">
                                                        </div>
                                                        <div class="partner-logo">
                                                            <img src="storage/01JNVYPFD4SZ54P3D19RYS6W77.png"
                                                                alt="Revu">
                                                        </div>
                                                        <div class="partner-logo">
                                                            <img src="storage/01JNVYPQZQT27S9GSNASF444QB.png"
                                                                alt="DigitalTurbine">
                                                        </div>
                                                        <div class="partner-logo">
                                                            <img src="storage/01JNVYNBX89YECEZA8MM1VX2TA.png"
                                                                alt="Notik">
                                                        </div>
                                                        <div class="partner-logo">
                                                            <img src="storage/01JQF2ZT62575WM9J2RWPAXGTX.png"
                                                                alt="Upwall">
                                                        </div>
                                                        <div class="partner-logo">
                                                            <img src="storage/01JQFZNA5EHMVD9TKNYC5EFAM0.png"
                                                                alt="Radient Wall">
                                                        </div>
                                                        <!--[if ENDBLOCK]><![endif]-->

                                                        <!-- Duplicate logos for smooth looping -->
                                                        <!--[if BLOCK]><![endif]-->
                                                        <div class="partner-logo">
                                                            <img src="storage/01JNVYNMWN7KRYN950QEVVJ1Y7.svg"
                                                                alt="Bitlabs">
                                                        </div>
                                                        <div class="partner-logo">
                                                            <img src="storage/01JNVYN2Q3HR3H0ER6T1NDGR8F.png"
                                                                alt="Torox">
                                                        </div>
                                                        <div class="partner-logo">
                                                            <img src="storage/01JNVYNYA7GF4V1P46MKYDG7GM.png"
                                                                alt="Monlix">
                                                        </div>
                                                        <div class="partner-logo">
                                                            <img src="storage/01JNVYP6SGFYBKP8V2E72TGVAC.png"
                                                                alt="Adgem">
                                                        </div>
                                                        <div class="partner-logo">
                                                            <img src="storage/01JNVYPFD4SZ54P3D19RYS6W77.png"
                                                                alt="Revu">
                                                        </div>
                                                        <div class="partner-logo">
                                                            <img src="storage/01JNVYPQZQT27S9GSNASF444QB.png"
                                                                alt="DigitalTurbine">
                                                        </div>
                                                        <div class="partner-logo">
                                                            <img src="storage/01JNVYNBX89YECEZA8MM1VX2TA.png"
                                                                alt="Notik">
                                                        </div>
                                                        <div class="partner-logo">
                                                            <img src="storage/01JQF2ZT62575WM9J2RWPAXGTX.png"
                                                                alt="Upwall">
                                                        </div>
                                                        <div class="partner-logo">
                                                            <img src="storage/01JQFZNA5EHMVD9TKNYC5EFAM0.png"
                                                                alt="Radient Wall">
                                                        </div>
                                                        <!--[if ENDBLOCK]><![endif]-->
                                                    </div>
                                                </div>













                                            </div>
                                        </div>





                                        <div class="row justify-content-center " style="margin-top: 6rem;"
                                            wire:ignore="">
                                            <div class="w-100 "
                                                style="background: var(--bs-base); border-radius: 20px;">
                                                <div
                                                    class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                                                    <!-- Left Column -->
                                                    <div class="d-flex flex-column p-3 py-5 p-md-5 col-md-6 col-12">
                                                        <div class="d-flex flex-column w-100 gap-4">
                                                            <!-- Heading -->
                                                            <div class="d-flex flex-wrap gap-3 text-white">
                                                                <div>
                                                                    <span class="text-primary fw-bolder fs-1">Start
                                                                        Making Money Today!</span>
                                                                </div>
                                                            </div>

                                                            <!-- Description -->
                                                            <div class="text-secondary fs-5 fw-light">
                                                                <p>Start earning money today by completing offers,
                                                                    playing games, and taking
                                                                    surveys.
                                                                    It's easy, fun, and rewarding!</p>
                                                            </div>
                                                        </div>

                                                        <!-- Button -->
                                                        <button
                                                            class="btn btn-primary d-flex align-items-center w-100 p-3 text-uppercase"
                                                            style="border-radius: 25px;" data-bs-target="#authModal"
                                                            data-bs-toggle="modal">
                                                            <span>Get Started</span>
                                                        </button>
                                                    </div>

                                                    <!-- Right Column (Image) -->
                                                    <div class="overflow-hidden ">






                                                        <img loading="lazy" src="/assets/img/games.avif"
                                                            alt="Start Earning" style="max-height: 300px;">
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- / Content -->

                        <footer class="content-footer footer small mt-4" style="background: var(--bs-base);">
                            <div class="container-fluid">
                                <div class="pt-5 pb-4 py-md-5" style="background: var(--bs-base);">
                                    <div class="row">
                                        <div
                                            class="col-md-4 text-center text-md-start mt-4 mt-md-0 order-last order-md-first">
                                            <div class="">
                                                <a class="" target="_blank" style="" href="">
                                                    <img src="/assets/img/homelogo.png" alt="" class="me-2"
                                                        style="max-width:300px;">

                                                </a>
                                            </div>
                                            <p class="footer-text small mt-2 mb-0"> Coinhub | All rights reserved
                                                © 2025
                                            </p>

                                        </div>

                                        <div class="col-md-8 mb-4">
                                            <div
                                                class="d-flex flex-wrap justify-content-md-around justify-content-sm-between justify-content-around row-gap-4">
                                                <div class=" text-md-start">
                                                    <h5 class="fw-bold text-white">About</h5>
                                                    <div class="d-flex flex-column justify-content-around gap-2">
                                                        <a href="terms-of-service" class="footer-link">
                                                            <svg width="18px" height="18px" class="me-1"
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                                fill="currentColor" aria-hidden="true" data-slot="icon">
                                                                <path fill-rule="evenodd"
                                                                    d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625ZM7.5 15a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 7.5 15Zm.75 2.25a.75.75 0 0 0 0 1.5H12a.75.75 0 0 0 0-1.5H8.25Z"
                                                                    clip-rule="evenodd"></path>
                                                                <path
                                                                    d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z">
                                                                </path>
                                                            </svg> Terms of Service
                                                        </a>

                                                        <a href="privacy-policy" class="footer-link">
                                                            <svg width="18px" height="18px" class="me-1"
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                                fill="currentColor" aria-hidden="true" data-slot="icon">
                                                                <path fill-rule="evenodd"
                                                                    d="M12.516 2.17a.75.75 0 0 0-1.032 0 11.209 11.209 0 0 1-7.877 3.08.75.75 0 0 0-.722.515A12.74 12.74 0 0 0 2.25 9.75c0 5.942 4.064 10.933 9.563 12.348a.749.749 0 0 0 .374 0c5.499-1.415 9.563-6.406 9.563-12.348 0-1.39-.223-2.73-.635-3.985a.75.75 0 0 0-.722-.516l-.143.001c-2.996 0-5.717-1.17-7.734-3.08Zm3.094 8.016a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z"
                                                                    clip-rule="evenodd"></path>
                                                            </svg> Privacy Policy
                                                        </a>
                                                    </div>
                                                </div>

                                                <div class=" text-md-start">
                                                    <h5 class="fw-bold text-white">Support</h5>
                                                    <div class="d-flex flex-column justify-content-around gap-2">
                                                        <a href="mailto:hello@example.com" class="footer-link">
                                                            <svg width="18px" height="18px" class="me-1"
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                                fill="currentColor" aria-hidden="true" data-slot="icon">
                                                                <path
                                                                    d="M1.5 8.67v8.58a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3V8.67l-8.928 5.493a3 3 0 0 1-3.144 0L1.5 8.67Z">
                                                                </path>
                                                                <path
                                                                    d="M22.5 6.908V6.75a3 3 0 0 0-3-3h-15a3 3 0 0 0-3 3v.158l9.714 5.978a1.5 1.5 0 0 0 1.572 0L22.5 6.908Z">
                                                                </path>
                                                            </svg> Contact Us
                                                        </a>

                                                        <a href="faq" class="footer-link">
                                                            <svg width="18px" height="18px" class="me-1"
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                                fill="currentColor" aria-hidden="true" data-slot="icon">
                                                                <path fill-rule="evenodd"
                                                                    d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm11.378-3.917c-.89-.777-2.366-.777-3.255 0a.75.75 0 0 1-.988-1.129c1.454-1.272 3.776-1.272 5.23 0 1.513 1.324 1.513 3.518 0 4.842a3.75 3.75 0 0 1-.837.552c-.676.328-1.028.774-1.028 1.152v.75a.75.75 0 0 1-1.5 0v-.75c0-1.279 1.06-2.107 1.875-2.502.182-.088.351-.199.503-.331.83-.727.83-1.857 0-2.584ZM12 18a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z"
                                                                    clip-rule="evenodd"></path>
                                                            </svg> FAQ
                                                        </a>
                                                    </div>
                                                </div>

                                                <div class="text-center text-md-start">
                                                    <h5 class="fw-bold text-white">Social media</h5>
                                                    <div class="d-flex flex-wrap justify-content-around gap-1">
                                                        <a class="btn btn-sm btn-label-secondary footer-link-btn"
                                                            target="_blank" href="">
                                                            <i class="fa-brands fa-discord"></i>
                                                        </a>

                                                        <a class="btn btn-sm btn-label-secondary footer-link-btn"
                                                            href="" target="_blank">
                                                            <i class="fa-brands fa-telegram"></i>
                                                        </a>

                                                        <a class="btn btn-sm btn-label-secondary footer-link-btn"
                                                            href="" target="_blank">
                                                            <i class="fa-brands fa-twitter"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </footer>


                        <div class="content-backdrop fade"></div>
                    </div>
                    <!-- Content wrapper -->

                </div>
                <!-- / Layout page -->
            </div>

            <!-- Overlay -->
            <div class="layout-overlay layout-menu-toggle"></div>

            <!-- Drag Target Area To SlideIn Menu On Small Screens -->
            <div class="drag-target"></div>

            <div wire:snapshot="{&quot;data&quot;:{&quot;email&quot;:&quot;admin@ziadt.dev&quot;,&quot;password&quot;:&quot;password&quot;,&quot;remember&quot;:false,&quot;acceptTerms&quot;:false,&quot;activeTab&quot;:1,&quot;token&quot;:null},&quot;memo&quot;:{&quot;id&quot;:&quot;rJDmxhkVLIZosFolWgr7&quot;,&quot;name&quot;:&quot;user.auth&quot;,&quot;path&quot;:&quot;\/&quot;,&quot;method&quot;:&quot;GET&quot;,&quot;children&quot;:[],&quot;scripts&quot;:[&quot;3602656461-0&quot;],&quot;assets&quot;:[],&quot;errors&quot;:[],&quot;locale&quot;:&quot;en&quot;},&quot;checksum&quot;:&quot;bd34316d2215868c997db6ed572dd98b219f61ece82ed249bd79bde03481fc80&quot;}"
                wire:effects="{&quot;scripts&quot;:{&quot;3602656461-0&quot;:&quot;&lt;script&gt;\n    document.getElementById('authModal').addEventListener('show.bs.modal', function () {\n        const button = event.relatedTarget\n        if (button.getAttribute('data-signup') === 'true')\n            document.querySelector(`button[data-bs-target='#tab-register']`).click();\n        else\n            document.querySelector(`button[data-bs-target='#tab-login']`).click();\n    });\n&lt;\/script&gt;\n    &quot;},&quot;listeners&quot;:[&quot;register&quot;]}"
                wire:id="rJDmxhkVLIZosFolWgr7">
                <div wire:ignore.self="" class="modal fade" id="authModal" tabindex="-1"
                    aria-labelledby="offerModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen-sm-down">
                        <div class="modal-content auth-width"
                            x-data="{ activeTab: window.Livewire.find('rJDmxhkVLIZosFolWgr7').entangle('activeTab') }">
                            <div class="modal-header">
                                <h5 class="modal-title text-body" x-text="activeTab === 1 ? 'Sign In' : 'Sign Up'">Sign
                                    In</h5>
                                <button type="button"
                                    class="btn-close bg-label-primary d-flex align-items-center justify-content-center"
                                    style="background: var(--bs-base); border: none; color: white; z-index: 999999;"
                                    data-bs-dismiss="modal" aria-label="Close">
                                    <i class="fa-solid fa-times" style="font-weight: 600"></i>
                                </button>
                            </div>
                            <div class="modal-body p-0 ps">
                                <div class="text-center mb-4">
                                    <h1 class="fw-bold"
                                        style="font-size: 2rem; background: #01d676; -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                                        Sign In
                                    </h1>
                                </div>
                                <div class="tab-content pt-1 " style="background-color: var(--bs-base) !important;">
                                    <div class="tab-pane fade active show" id="tab-login" role="tabpanel">
                                        <div class="d-flex col-12 align-items-center py-4">
                                            <div class="w-px-400 mx-auto">


                                                <p class="mb-4">Please sign-in to your account and start the adventure
                                                    🚀</p>
                                                <form id="loginForm" method="post" class="mb-3"
                                                    x-data="{ showPassword: false }">
                                                    <!-- Hidden token -->
                                                    <input type="hidden" id="loginToken"
                                                        value="<?php echo $_SESSION['token']; ?>">

                                                    <div id="loginStatus"></div>

                                                    <!-- Username -->
                                                    <div class="mb-3">
                                                        <label class="form-label text-body">Username</label>
                                                        <input class="form-control" id="userLogin" type="text"
                                                            placeholder="Enter your username" required>
                                                    </div>

                                                    <!-- Password -->
                                                    <div class="mb-3 form-password-toggle">
                                                        <div class="d-flex justify-content-between">
                                                            <label class="form-label text-body">Password</label>
                                                            <a href="javascript:" data-bs-target="#forgetPasswordModal"
                                                                data-bs-toggle="modal">
                                                                <small>Forgot Password?</small>
                                                            </a>
                                                        </div>
                                                        <div class="input-group input-group-merge has-validation">
                                                            <input id="userPass" class="form-control"
                                                                x-bind:type="showPassword ? 'text' : 'password'"
                                                                type="password" placeholder="············"
                                                                autocomplete="current-password" required>
                                                            <span class="input-group-text cursor-pointer"
                                                                x-on:click="showPassword = !showPassword">
                                                                <!-- eye icons  -->
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    if (!empty($config['recaptcha_pub'])) {
                                                        echo '<div class="g-recaptcha" style="margin-bottom:21px;" data-sitekey="' . $config['recaptcha_pub'] . '"></div>';
                                                    }
                                                    ?>

                                                    <!-- Remember -->
                                                    <div class="mb-3" >
                                                        <div class="form-check form-label text-body">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="remember">
                                                            <label class="form-check-label" >Remember Me</label>
                                                        </div>
                                                    </div>

                                                    <button class="btn btn-primary w-100" type="submit">Login</button>
                                                </form>



                                                <p class="text-center form-label">
                                                    <span class="text-body">New on our platform?</span>
                                                    <a
                                                        href="javascript: document.querySelector(`button[data-bs-target='#tab-register']`).click()">
                                                        <span>Create an account</span>
                                                    </a>
                                                </p>

                                                <div class="divider my-2">
                                                    <div class="divider-text">or</div>
                                                </div>

                                                <a href="auth/google"
                                                    class="btn btn-dark d-flex align-items-center w-100 waves-effect waves-light">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                        viewBox="0 0 28 28" fill="none">
                                                        <g clip-path="url(#clip0_436_15312)">
                                                            <path
                                                                d="M6.20539 16.9208L5.23075 20.5592L1.66846 20.6346C0.603859 18.66 0 16.4008 0 14C0 11.6785 0.564594 9.48921 1.56537 7.56153L4.73758 8.14297L6.12686 11.2954C5.83609 12.1431 5.6776 13.0531 5.6776 14C5.67771 15.0277 5.86387 16.0123 6.20539 16.9208Z"
                                                                fill="#FFC700"></path>
                                                            <path
                                                                d="M27.7554 11.3846C27.9162 12.2315 28 13.1061 28 14C28 15.0023 27.8946 15.98 27.6939 16.9231C27.0123 20.1323 25.2316 22.9346 22.7647 24.9177L22.7639 24.9169L18.7693 24.7131L18.2039 21.1839C19.8408 20.2239 21.1201 18.7216 21.794 16.9231H14.3078V11.3846H27.7554Z"
                                                                fill="#518EF8"></path>
                                                            <path
                                                                d="M22.7639 24.9169L22.7647 24.9177C20.3655 26.8461 17.3177 28 14 28C8.66846 28 4.03309 25.02 1.66846 20.6346L6.20539 16.9208C7.38768 20.0761 10.4315 22.3223 14 22.3223C15.5338 22.3223 16.9709 21.9077 18.2039 21.1839L22.7639 24.9169Z"
                                                                fill="#01D676"></path>
                                                            <path
                                                                d="M22.9362 3.22306L18.4008 6.93613C17.1246 6.13845 15.6161 5.67766 14 5.67766C10.3508 5.67766 7.24992 8.02687 6.12686 11.2954L1.56537 7.56153C3.89539 3.06923 8.58922 0 14 0C17.3969 0 20.5115 1.21002 22.9362 3.22306Z"
                                                                fill="#C34646"></path>
                                                        </g>
                                                        <defs>
                                                            <clipPath id="clip0_436_15312">
                                                                <rect width="28" height="28" fill="white"></rect>
                                                            </clipPath>
                                                        </defs>
                                                    </svg>
                                                    <span class="ms-2">Sign In with Google</span>
                                                </a>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                                    <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                                </div>
                                <div class="ps__rail-y" style="top: 0px; right: 0px;">
                                    <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal fade" id="forgetPasswordModal" tabindex="-1"
                    aria-labelledby="forgetPasswordModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header mb-0 pb-0">
                                <h5 class="modal-title f-md text-body" id="forgetPasswordModalLabel">Send Reset Mail
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                                <form method="POST" id="recoverPass">

                                    <div id="recoverStatus"></div>


                                    <input type="hidden" id="recoverToken" value="<?php echo $token; ?>" />

                                    <div class="mb-3">
                                        <label class="form-label text-body">Email</label>
                                        <input type="email" class="form-control" id="recoverEmail"
                                            placeholder="Enter your email" required>
                                    </div>


                                    <?php
                                    if (!empty($config['recaptcha_pub'])) {
                                        echo '<div class="g-recaptcha mb-3" data-sitekey="' . $config['recaptcha_pub'] . '"></div>';
                                    }
                                    ?>

                                    <button type="submit"
                                        class="btn btn-primary d-flex align-items-center w-100 waves-effect waves-light">
                                        Continue
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div wire:ignore.self="" x-data="{ show: false }"
                    x-init="if (show) { $('#resetPasswordModal').modal('show') }" class="modal fade"
                    id="resetPasswordModal" tabindex="-1" aria-labelledby="resetPasswordModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered ">
                        <div class="modal-content">
                            <div class="modal-header mb-0 pb-0">
                                <h5 class="modal-title f-md text-body" id="resetPasswordModalLabel">Reset Password</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-4">
                                <form wire:submit="resetPassword">
                                    <div class="mb-3">
                                        <label class="form-label text-body">Token</label>
                                        <input type="text" wire:model="token" class="form-control" disabled="">

                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-body">Email</label>
                                        <input type="text" name="email" autocomplete="email" wire:model="email"
                                            class="form-control" disabled="">

                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                    <div class="mb-3 form-password-toggle" x-data="{ showPassword: false }">
                                        <div class="d-flex justify-content-between">
                                            <label class="form-label text-body">New Password</label>
                                        </div>
                                        <div class="input-group input-group-merge has-validation">
                                            <input class="form-control" wire:model="password"
                                                x-bind:type="showPassword ? 'text' : 'password'" type="password"
                                                name="password" placeholder="············" aria-describedby="password"
                                                autocomplete="current-password">
                                            <span class="input-group-text cursor-pointer"
                                                x-on:click="showPassword = !showPassword">
                                                <svg x-show="!showPassword" width="20px"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" aria-hidden="true"
                                                    data-slot="icon">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88">
                                                    </path>
                                                </svg> <svg x-show="showPassword" width="20px"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" aria-hidden="true"
                                                    data-slot="icon" style="display: none;">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z">
                                                    </path>
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"></path>
                                                </svg> </span>

                                            <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                        </div>
                                    </div>
                                    <div class="d-flex gap-2 mt-4">
                                        <button type="submit"
                                            class="btn btn-primary d-flex align-items-center w-50 waves-effect waves-light">
                                            Continue
                                        </button>

                                        <a href="#"
                                            class="btn btn-danger d-flex align-items-center w-50 waves-effect waves-light">
                                            Close
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div wire:id="hQxLvGBGJExJTn2k6VVj" x-on:open-chat.window="isOpen = true" x-data="{isOpen: false}">


                <div class="custom-chat-container" :class="{ 'active': isOpen }">
                    <div class="custom-chat-box" x-init="$dispatch('chat-init')">
                        <!-- Chat Header -->
                        <div class="custom-card-header">
                            <p class="badge bg-label-primary d-flex align-items-center mb-0">
                                <svg style="width: 22px; height: 22px" class="me-1" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                    aria-hidden="true" data-slot="icon">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z">
                                    </path>
                                </svg>

                                <span id="online-users" class="f-md" x-data="{ onlineUsers: 0 }" x-init="() =&gt; {
                try {
                                } catch (e) {
                    //console.error('Failed to connect to Echo channel:', e);
                }}
              " x-text="onlineUsers">0</span>
                            </p>
                            <button type="button" class="custom-btn-primary btn-sm" @click="isOpen = false"
                                aria-label="Close chat">
                                <svg style="width: 24px; height: 24px" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" data-slot="icon">
                                    <path fill-rule="evenodd"
                                        d="M11.03 3.97a.75.75 0 0 1 0 1.06l-6.22 6.22H21a.75.75 0 0 1 0 1.5H4.81l6.22 6.22a.75.75 0 1 1-1.06 1.06l-7.5-7.5a.75.75 0 0 1 0-1.06l7.5-7.5a.75.75 0 0 1 1.06 0Z"
                                        clip-rule="evenodd"></path>
                                </svg> </button>
                        </div>

                        <!-- Chat Body (Scrollable area) -->
                        <div class="custom-card-body ps ps--active-y" style="overflow-y: auto;" wire:ignore.self="">
                            <!--[if BLOCK]><![endif]-->
                            <div
                                class="d-flex align-items-start gap-2 mb-2 bg-label-secondary py-2 px-3 rounded message">
                                <div style="cursor: pointer"
                                    @click="$('#activityModal').data('id', '15').modal('show')">


                                    <div class="progress-circle"
                                        style="background: conic-gradient(var(--bs-primary) 0% 100%, var(--bs-dark) 100% 100%);">
                                        <img src="/assets/avatars/memoji_3.png" alt="VileVillain" class="rounded-circle"
                                            style="width: 35px !important; height: 35px !important;">

                                        <div class="badge bg-primary rounded-circle text-white"
                                            style="position: absolute; bottom: 0; right: 0; font-size: 10px; padding: 2px 5px; z-index: 11">
                                            1
                                        </div>
                                    </div>



                                </div>
                                <div style="line-height: 1.2; width: 100%" x-data="{ showMention: false }"
                                    @mouseover="showMention = true" @mouseleave="showMention = false">
                                    <span class="d-flex align-items-center justify-content-between mb-1 text-white">
                                        <div style="cursor: pointer"
                                            @click="$('#activityModal').data('id', '15').modal('show')">
                                            VileVillain
                                            <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                        </div>

                                        <span class="text-secondary small text-end d-flex align-items-center"
                                            style="font-size: 10px !important;">
                                            04:42 AM

                                            <span class="mx-2 text-primary"
                                                style="font-size: 11px !important; cursor: pointer; display: none !important;"
                                                x-show.important="showMention" x-transition=""
                                                @click="document.getElementById('message-to-send').value += '@VileVillain'; document.getElementById('message-to-send').focus();">
                                                <i class="fas fa-at"></i>
                                            </span>
                                        </span>

                                    </span>
                                    <span class="text-body">

                                        <!--[if BLOCK]><![endif]--> hi
                                        <!--[if ENDBLOCK]><![endif]-->
                                    </span>
                                </div>
                            </div>
                            <div
                                class="d-flex align-items-start gap-2 mb-2 bg-label-secondary py-2 px-3 rounded message">
                                <div style="cursor: pointer"
                                    @click="$('#activityModal').data('id', '15').modal('show')">


                                    <div class="progress-circle"
                                        style="background: conic-gradient(var(--bs-primary) 0% 100%, var(--bs-dark) 100% 100%);">
                                        <img src="/assets/avatars/memoji_3.png" alt="VileVillain" class="rounded-circle"
                                            style="width: 35px !important; height: 35px !important;">

                                        <div class="badge bg-primary rounded-circle text-white"
                                            style="position: absolute; bottom: 0; right: 0; font-size: 10px; padding: 2px 5px; z-index: 11">
                                            1
                                        </div>
                                    </div>



                                </div>
                                <div style="line-height: 1.2; width: 100%" x-data="{ showMention: false }"
                                    @mouseover="showMention = true" @mouseleave="showMention = false">
                                    <span class="d-flex align-items-center justify-content-between mb-1 text-white">
                                        <div style="cursor: pointer"
                                            @click="$('#activityModal').data('id', '15').modal('show')">
                                            VileVillain
                                            <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                        </div>

                                        <span class="text-secondary small text-end d-flex align-items-center"
                                            style="font-size: 10px !important;">
                                            04:44 AM

                                            <span class="mx-2 text-primary"
                                                style="font-size: 11px !important; cursor: pointer; display: none !important;"
                                                x-show.important="showMention" x-transition=""
                                                @click="document.getElementById('message-to-send').value += '@VileVillain'; document.getElementById('message-to-send').focus();">
                                                <i class="fas fa-at"></i>
                                            </span>
                                        </span>

                                    </span>
                                    <span class="text-body">

                                        <!--[if BLOCK]><![endif]--> hi
                                        <!--[if ENDBLOCK]><![endif]-->
                                    </span>
                                </div>
                            </div>
                            <div
                                class="d-flex align-items-start gap-2 mb-2 bg-label-secondary py-2 px-3 rounded message">
                                <div style="cursor: pointer"
                                    @click="$('#activityModal').data('id', '16').modal('show')">


                                    <div class="progress-circle"
                                        style="background: conic-gradient(var(--bs-primary) 0% 100%, var(--bs-dark) 100% 100%);">
                                        <img src="/assets/avatars/memoji_33.png" alt="SneakyShadow"
                                            class="rounded-circle"
                                            style="width: 35px !important; height: 35px !important;">

                                        <div class="badge bg-primary rounded-circle text-white"
                                            style="position: absolute; bottom: 0; right: 0; font-size: 10px; padding: 2px 5px; z-index: 11">
                                            1
                                        </div>
                                    </div>



                                </div>
                                <div style="line-height: 1.2; width: 100%" x-data="{ showMention: false }"
                                    @mouseover="showMention = true" @mouseleave="showMention = false">
                                    <span class="d-flex align-items-center justify-content-between mb-1 text-white">
                                        <div style="cursor: pointer"
                                            @click="$('#activityModal').data('id', '16').modal('show')">
                                            SneakyShadow
                                            <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                        </div>

                                        <span class="text-secondary small text-end d-flex align-items-center"
                                            style="font-size: 10px !important;">
                                            01:30 PM

                                            <span class="mx-2 text-primary"
                                                style="font-size: 11px !important; cursor: pointer; display: none !important;"
                                                x-show.important="showMention" x-transition=""
                                                @click="document.getElementById('message-to-send').value += '@SneakyShadow'; document.getElementById('message-to-send').focus();">
                                                <i class="fas fa-at"></i>
                                            </span>
                                        </span>

                                    </span>
                                    <span class="text-body">

                                        <!--[if BLOCK]><![endif]--> Hh
                                        <!--[if ENDBLOCK]><![endif]-->
                                    </span>
                                </div>
                            </div>
                            <div
                                class="d-flex align-items-start gap-2 mb-2 bg-label-secondary py-2 px-3 rounded message">
                                <div style="cursor: pointer"
                                    @click="$('#activityModal').data('id', '16').modal('show')">


                                    <div class="progress-circle"
                                        style="background: conic-gradient(var(--bs-primary) 0% 100%, var(--bs-dark) 100% 100%);">
                                        <img src="/assets/avatars/memoji_33.png" alt="SneakyShadow"
                                            class="rounded-circle"
                                            style="width: 35px !important; height: 35px !important;">

                                        <div class="badge bg-primary rounded-circle text-white"
                                            style="position: absolute; bottom: 0; right: 0; font-size: 10px; padding: 2px 5px; z-index: 11">
                                            1
                                        </div>
                                    </div>



                                </div>
                                <div style="line-height: 1.2; width: 100%" x-data="{ showMention: false }"
                                    @mouseover="showMention = true" @mouseleave="showMention = false">
                                    <span class="d-flex align-items-center justify-content-between mb-1 text-white">
                                        <div style="cursor: pointer"
                                            @click="$('#activityModal').data('id', '16').modal('show')">
                                            SneakyShadow
                                            <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                        </div>

                                        <span class="text-secondary small text-end d-flex align-items-center"
                                            style="font-size: 10px !important;">
                                            12:59 PM

                                            <span class="mx-2 text-primary"
                                                style="font-size: 11px !important; cursor: pointer; display: none !important;"
                                                x-show.important="showMention" x-transition=""
                                                @click="document.getElementById('message-to-send').value += '@SneakyShadow'; document.getElementById('message-to-send').focus();">
                                                <i class="fas fa-at"></i>
                                            </span>
                                        </span>

                                    </span>
                                    <span class="text-body">

                                        <!--[if BLOCK]><![endif]--> 🚰
                                        <!--[if ENDBLOCK]><![endif]-->
                                    </span>
                                </div>
                            </div>
                            <div
                                class="d-flex align-items-start gap-2 mb-2 bg-label-secondary py-2 px-3 rounded message">
                                <div style="cursor: pointer"
                                    @click="$('#activityModal').data('id', '24').modal('show')">


                                    <div class="progress-circle"
                                        style="background: conic-gradient(var(--bs-primary) 0% 100%, var(--bs-dark) 100% 100%);">
                                        <img src="/assets/avatars/memoji_1.png" alt="VengefulVulture"
                                            class="rounded-circle"
                                            style="width: 35px !important; height: 35px !important;">

                                        <div class="badge bg-primary rounded-circle text-white"
                                            style="position: absolute; bottom: 0; right: 0; font-size: 10px; padding: 2px 5px; z-index: 11">
                                            1
                                        </div>
                                    </div>



                                </div>
                                <div style="line-height: 1.2; width: 100%" x-data="{ showMention: false }"
                                    @mouseover="showMention = true" @mouseleave="showMention = false">
                                    <span class="d-flex align-items-center justify-content-between mb-1 text-white">
                                        <div style="cursor: pointer"
                                            @click="$('#activityModal').data('id', '24').modal('show')">
                                            VengefulVulture
                                            <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                        </div>

                                        <span class="text-secondary small text-end d-flex align-items-center"
                                            style="font-size: 10px !important;">
                                            05:23 PM

                                            <span class="mx-2 text-primary"
                                                style="font-size: 11px !important; cursor: pointer; display: none !important;"
                                                x-show.important="showMention" x-transition=""
                                                @click="document.getElementById('message-to-send').value += '@VengefulVulture'; document.getElementById('message-to-send').focus();">
                                                <i class="fas fa-at"></i>
                                            </span>
                                        </span>

                                    </span>
                                    <span class="text-body">

                                        <!--[if BLOCK]><![endif]--> 👍
                                        <!--[if ENDBLOCK]><![endif]-->
                                    </span>
                                </div>
                            </div>
                            <div
                                class="d-flex align-items-start gap-2 mb-2 bg-label-secondary py-2 px-3 rounded message">
                                <div style="cursor: pointer"
                                    @click="$('#activityModal').data('id', '24').modal('show')">


                                    <div class="progress-circle"
                                        style="background: conic-gradient(var(--bs-primary) 0% 100%, var(--bs-dark) 100% 100%);">
                                        <img src="/assets/avatars/memoji_1.png" alt="VengefulVulture"
                                            class="rounded-circle"
                                            style="width: 35px !important; height: 35px !important;">

                                        <div class="badge bg-primary rounded-circle text-white"
                                            style="position: absolute; bottom: 0; right: 0; font-size: 10px; padding: 2px 5px; z-index: 11">
                                            1
                                        </div>
                                    </div>



                                </div>
                                <div style="line-height: 1.2; width: 100%" x-data="{ showMention: false }"
                                    @mouseover="showMention = true" @mouseleave="showMention = false">
                                    <span class="d-flex align-items-center justify-content-between mb-1 text-white">
                                        <div style="cursor: pointer"
                                            @click="$('#activityModal').data('id', '24').modal('show')">
                                            VengefulVulture
                                            <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                        </div>

                                        <span class="text-secondary small text-end d-flex align-items-center"
                                            style="font-size: 10px !important;">
                                            05:23 PM

                                            <span class="mx-2 text-primary"
                                                style="font-size: 11px !important; cursor: pointer; display: none !important;"
                                                x-show.important="showMention" x-transition=""
                                                @click="document.getElementById('message-to-send').value += '@VengefulVulture'; document.getElementById('message-to-send').focus();">
                                                <i class="fas fa-at"></i>
                                            </span>
                                        </span>

                                    </span>
                                    <span class="text-body">

                                        <!--[if BLOCK]><![endif]--> @AdminDemo👍
                                        <!--[if ENDBLOCK]><![endif]-->
                                    </span>
                                </div>
                            </div>
                            <div
                                class="d-flex align-items-start gap-2 mb-2 bg-label-secondary py-2 px-3 rounded message">
                                <div style="cursor: pointer"
                                    @click="$('#activityModal').data('id', '28').modal('show')">


                                    <div class="progress-circle"
                                        style="background: conic-gradient(var(--bs-primary) 0% 100%, var(--bs-dark) 100% 100%);">
                                        <img src="/assets/avatars/memoji_1.png" alt="SinisterSorcerer"
                                            class="rounded-circle"
                                            style="width: 35px !important; height: 35px !important;">

                                        <div class="badge bg-primary rounded-circle text-white"
                                            style="position: absolute; bottom: 0; right: 0; font-size: 10px; padding: 2px 5px; z-index: 11">
                                            1
                                        </div>
                                    </div>



                                </div>
                                <div style="line-height: 1.2; width: 100%" x-data="{ showMention: false }"
                                    @mouseover="showMention = true" @mouseleave="showMention = false">
                                    <span class="d-flex align-items-center justify-content-between mb-1 text-white">
                                        <div style="cursor: pointer"
                                            @click="$('#activityModal').data('id', '28').modal('show')">
                                            SinisterSorcerer
                                            <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                        </div>

                                        <span class="text-secondary small text-end d-flex align-items-center"
                                            style="font-size: 10px !important;">
                                            01:00 PM

                                            <span class="mx-2 text-primary"
                                                style="font-size: 11px !important; cursor: pointer; display: none !important;"
                                                x-show.important="showMention" x-transition=""
                                                @click="document.getElementById('message-to-send').value += '@SinisterSorcerer'; document.getElementById('message-to-send').focus();">
                                                <i class="fas fa-at"></i>
                                            </span>
                                        </span>

                                    </span>
                                    <span class="text-body">

                                        <!--[if BLOCK]><![endif]--> hi
                                        <!--[if ENDBLOCK]><![endif]-->
                                    </span>
                                </div>
                            </div>
                            <div
                                class="d-flex align-items-start gap-2 mb-2 bg-label-secondary py-2 px-3 rounded message">
                                <div style="cursor: pointer"
                                    @click="$('#activityModal').data('id', '37').modal('show')">


                                    <div class="progress-circle"
                                        style="background: conic-gradient(var(--bs-primary) 0% 100%, var(--bs-dark) 100% 100%);">
                                        <img src="/assets/avatars/memoji_17.png" alt="ViciousViper"
                                            class="rounded-circle"
                                            style="width: 35px !important; height: 35px !important;">

                                        <div class="badge bg-primary rounded-circle text-white"
                                            style="position: absolute; bottom: 0; right: 0; font-size: 10px; padding: 2px 5px; z-index: 11">
                                            1
                                        </div>
                                    </div>



                                </div>
                                <div style="line-height: 1.2; width: 100%" x-data="{ showMention: false }"
                                    @mouseover="showMention = true" @mouseleave="showMention = false">
                                    <span class="d-flex align-items-center justify-content-between mb-1 text-white">
                                        <div style="cursor: pointer"
                                            @click="$('#activityModal').data('id', '37').modal('show')">
                                            ViciousViper
                                            <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                        </div>

                                        <span class="text-secondary small text-end d-flex align-items-center"
                                            style="font-size: 10px !important;">
                                            09:01 PM

                                            <span class="mx-2 text-primary"
                                                style="font-size: 11px !important; cursor: pointer; display: none !important;"
                                                x-show.important="showMention" x-transition=""
                                                @click="document.getElementById('message-to-send').value += '@ViciousViper'; document.getElementById('message-to-send').focus();">
                                                <i class="fas fa-at"></i>
                                            </span>
                                        </span>

                                    </span>
                                    <span class="text-body">

                                        <!--[if BLOCK]><![endif]--> hi
                                        <!--[if ENDBLOCK]><![endif]-->
                                    </span>
                                </div>
                            </div>
                            <div
                                class="d-flex align-items-start gap-2 mb-2 bg-label-secondary py-2 px-3 rounded message">
                                <div style="cursor: pointer"
                                    @click="$('#activityModal').data('id', '52').modal('show')">


                                    <div class="progress-circle"
                                        style="background: conic-gradient(var(--bs-primary) 0% 100%, var(--bs-dark) 100% 100%);">
                                        <img src="/assets/avatars/memoji_1.png" alt="MysticMageq" class="rounded-circle"
                                            style="width: 35px !important; height: 35px !important;">

                                        <div class="badge bg-primary rounded-circle text-white"
                                            style="position: absolute; bottom: 0; right: 0; font-size: 10px; padding: 2px 5px; z-index: 11">
                                            1
                                        </div>
                                    </div>



                                </div>
                                <div style="line-height: 1.2; width: 100%" x-data="{ showMention: false }"
                                    @mouseover="showMention = true" @mouseleave="showMention = false">
                                    <span class="d-flex align-items-center justify-content-between mb-1 text-white">
                                        <div style="cursor: pointer"
                                            @click="$('#activityModal').data('id', '52').modal('show')">
                                            MysticMageq
                                            <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                        </div>

                                        <span class="text-secondary small text-end d-flex align-items-center"
                                            style="font-size: 10px !important;">
                                            04:34 AM

                                            <span class="mx-2 text-primary"
                                                style="font-size: 11px !important; cursor: pointer; display: none !important;"
                                                x-show.important="showMention" x-transition=""
                                                @click="document.getElementById('message-to-send').value += '@MysticMageq'; document.getElementById('message-to-send').focus();">
                                                <i class="fas fa-at"></i>
                                            </span>
                                        </span>

                                    </span>
                                    <span class="text-body">

                                        <!--[if BLOCK]><![endif]--> Merhaba
                                        <!--[if ENDBLOCK]><![endif]-->
                                    </span>
                                </div>
                            </div>
                            <div
                                class="d-flex align-items-start gap-2 mb-2 bg-label-secondary py-2 px-3 rounded message">
                                <div style="cursor: pointer"
                                    @click="$('#activityModal').data('id', '52').modal('show')">


                                    <div class="progress-circle"
                                        style="background: conic-gradient(var(--bs-primary) 0% 100%, var(--bs-dark) 100% 100%);">
                                        <img src="/assets/avatars/memoji_1.png" alt="MysticMageq" class="rounded-circle"
                                            style="width: 35px !important; height: 35px !important;">

                                        <div class="badge bg-primary rounded-circle text-white"
                                            style="position: absolute; bottom: 0; right: 0; font-size: 10px; padding: 2px 5px; z-index: 11">
                                            1
                                        </div>
                                    </div>



                                </div>
                                <div style="line-height: 1.2; width: 100%" x-data="{ showMention: false }"
                                    @mouseover="showMention = true" @mouseleave="showMention = false">
                                    <span class="d-flex align-items-center justify-content-between mb-1 text-white">
                                        <div style="cursor: pointer"
                                            @click="$('#activityModal').data('id', '52').modal('show')">
                                            MysticMageq
                                            <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                        </div>

                                        <span class="text-secondary small text-end d-flex align-items-center"
                                            style="font-size: 10px !important;">
                                            04:35 AM

                                            <span class="mx-2 text-primary"
                                                style="font-size: 11px !important; cursor: pointer; display: none !important;"
                                                x-show.important="showMention" x-transition=""
                                                @click="document.getElementById('message-to-send').value += '@MysticMageq'; document.getElementById('message-to-send').focus();">
                                                <i class="fas fa-at"></i>
                                            </span>
                                        </span>

                                    </span>
                                    <span class="text-body">

                                        <!--[if BLOCK]><![endif]--> I want to ask something, how long does it take to
                                        confirm cryptocurrency withdrawals? Could you please provide information on this
                                        matter?
                                        <!--[if ENDBLOCK]><![endif]-->
                                    </span>
                                </div>
                            </div>
                            <div
                                class="d-flex align-items-start gap-2 mb-2 bg-label-secondary py-2 px-3 rounded message">
                                <div style="cursor: pointer"
                                    @click="$('#activityModal').data('id', '33').modal('show')">


                                    <div class="progress-circle"
                                        style="background: conic-gradient(var(--bs-primary) 0% 4545%, var(--bs-dark) 4545% 100%);">
                                        <img src="/assets/avatars/memoji_15.png" alt="CrimsonDagger"
                                            class="rounded-circle"
                                            style="width: 35px !important; height: 35px !important;">

                                        <div class="badge bg-primary rounded-circle text-white"
                                            style="position: absolute; bottom: 0; right: 0; font-size: 10px; padding: 2px 5px; z-index: 11">
                                            4
                                        </div>
                                    </div>



                                </div>
                                <div style="line-height: 1.2; width: 100%" x-data="{ showMention: false }"
                                    @mouseover="showMention = true" @mouseleave="showMention = false">
                                    <span class="d-flex align-items-center justify-content-between mb-1 text-white">
                                        <div style="cursor: pointer"
                                            @click="$('#activityModal').data('id', '33').modal('show')">
                                            CrimsonDagger
                                            <!--[if BLOCK]><![endif]--> <i class="fas fa-shield"
                                                style="color: #da2d2d; font-size: 11px"></i>
                                            <span class="text-secondary"
                                                style="font-size: 10px !important;">Admin</span>
                                            <!--[if ENDBLOCK]><![endif]-->
                                        </div>

                                        <span class="text-secondary small text-end d-flex align-items-center"
                                            style="font-size: 10px !important;">
                                            07:01 PM

                                            <span class="mx-2 text-primary"
                                                style="font-size: 11px !important; cursor: pointer; display: none !important;"
                                                x-show.important="showMention" x-transition=""
                                                @click="document.getElementById('message-to-send').value += '@CrimsonDagger'; document.getElementById('message-to-send').focus();">
                                                <i class="fas fa-at"></i>
                                            </span>
                                        </span>

                                    </span>
                                    <span class="text-body">

                                        <!--[if BLOCK]><![endif]--> <span class="text-decoration-underline text-primary"
                                            style="cursor: pointer"
                                            @click="$('#activityModal').data('id', '52').modal('show')">@MysticMageq</span>

                                        less than a minute
                                        <!--[if ENDBLOCK]><![endif]-->
                                    </span>
                                </div>
                            </div>
                            <div
                                class="d-flex align-items-start gap-2 mb-2 bg-label-secondary py-2 px-3 rounded message">
                                <div style="cursor: pointer"
                                    @click="$('#activityModal').data('id', '33').modal('show')">


                                    <div class="progress-circle"
                                        style="background: conic-gradient(var(--bs-primary) 0% 4545%, var(--bs-dark) 4545% 100%);">
                                        <img src="/assets/avatars/memoji_15.png" alt="CrimsonDagger"
                                            class="rounded-circle"
                                            style="width: 35px !important; height: 35px !important;">

                                        <div class="badge bg-primary rounded-circle text-white"
                                            style="position: absolute; bottom: 0; right: 0; font-size: 10px; padding: 2px 5px; z-index: 11">
                                            4
                                        </div>
                                    </div>



                                </div>
                                <div style="line-height: 1.2; width: 100%" x-data="{ showMention: false }"
                                    @mouseover="showMention = true" @mouseleave="showMention = false">
                                    <span class="d-flex align-items-center justify-content-between mb-1 text-white">
                                        <div style="cursor: pointer"
                                            @click="$('#activityModal').data('id', '33').modal('show')">
                                            CrimsonDagger
                                            <!--[if BLOCK]><![endif]--> <i class="fas fa-shield"
                                                style="color: #da2d2d; font-size: 11px"></i>
                                            <span class="text-secondary"
                                                style="font-size: 10px !important;">Admin</span>
                                            <!--[if ENDBLOCK]><![endif]-->
                                        </div>

                                        <span class="text-secondary small text-end d-flex align-items-center"
                                            style="font-size: 10px !important;">
                                            12:44 PM

                                            <span class="mx-2 text-primary"
                                                style="font-size: 11px !important; cursor: pointer; display: none !important;"
                                                x-show.important="showMention" x-transition=""
                                                @click="document.getElementById('message-to-send').value += '@CrimsonDagger'; document.getElementById('message-to-send').focus();">
                                                <i class="fas fa-at"></i>
                                            </span>
                                        </span>

                                    </span>
                                    <span class="text-body">

                                        <!--[if BLOCK]><![endif]--> Hi
                                        <!--[if ENDBLOCK]><![endif]-->
                                    </span>
                                </div>
                            </div>
                            <div
                                class="d-flex align-items-start gap-2 mb-2 bg-label-secondary py-2 px-3 rounded message">
                                <div style="cursor: pointer"
                                    @click="$('#activityModal').data('id', '33').modal('show')">


                                    <div class="progress-circle"
                                        style="background: conic-gradient(var(--bs-primary) 0% 4545%, var(--bs-dark) 4545% 100%);">
                                        <img src="/assets/avatars/memoji_15.png" alt="CrimsonDagger"
                                            class="rounded-circle"
                                            style="width: 35px !important; height: 35px !important;">

                                        <div class="badge bg-primary rounded-circle text-white"
                                            style="position: absolute; bottom: 0; right: 0; font-size: 10px; padding: 2px 5px; z-index: 11">
                                            4
                                        </div>
                                    </div>



                                </div>
                                <div style="line-height: 1.2; width: 100%" x-data="{ showMention: false }"
                                    @mouseover="showMention = true" @mouseleave="showMention = false">
                                    <span class="d-flex align-items-center justify-content-between mb-1 text-white">
                                        <div style="cursor: pointer"
                                            @click="$('#activityModal').data('id', '33').modal('show')">
                                            CrimsonDagger
                                            <!--[if BLOCK]><![endif]--> <i class="fas fa-shield"
                                                style="color: #da2d2d; font-size: 11px"></i>
                                            <span class="text-secondary"
                                                style="font-size: 10px !important;">Admin</span>
                                            <!--[if ENDBLOCK]><![endif]-->
                                        </div>

                                        <span class="text-secondary small text-end d-flex align-items-center"
                                            style="font-size: 10px !important;">
                                            12:45 PM

                                            <span class="mx-2 text-primary"
                                                style="font-size: 11px !important; cursor: pointer; display: none !important;"
                                                x-show.important="showMention" x-transition=""
                                                @click="document.getElementById('message-to-send').value += '@CrimsonDagger'; document.getElementById('message-to-send').focus();">
                                                <i class="fas fa-at"></i>
                                            </span>
                                        </span>

                                    </span>
                                    <span class="text-body">

                                        <!--[if BLOCK]><![endif]--> <span class="text-decoration-underline text-primary"
                                            style="cursor: pointer"
                                            @click="$('#activityModal').data('id', '37').modal('show')">@ViciousViper</span>

                                        Gg
                                        <!--[if ENDBLOCK]><![endif]-->
                                    </span>
                                </div>
                            </div>
                            <div
                                class="d-flex align-items-start gap-2 mb-2 bg-label-secondary py-2 px-3 rounded message">
                                <div style="cursor: pointer"
                                    @click="$('#activityModal').data('id', '69').modal('show')">


                                    <div class="progress-circle"
                                        style="background: conic-gradient(var(--bs-primary) 0% 0%, var(--bs-dark) 0% 100%);">
                                        <img src="/assets/avatars/memoji_33.png" alt="CunningCobra1"
                                            class="rounded-circle"
                                            style="width: 35px !important; height: 35px !important;">

                                        <div class="badge bg-primary rounded-circle text-white"
                                            style="position: absolute; bottom: 0; right: 0; font-size: 10px; padding: 2px 5px; z-index: 11">
                                            13
                                        </div>
                                    </div>



                                </div>
                                <div style="line-height: 1.2; width: 100%" x-data="{ showMention: false }"
                                    @mouseover="showMention = true" @mouseleave="showMention = false">
                                    <span class="d-flex align-items-center justify-content-between mb-1 text-white">
                                        <div style="cursor: pointer"
                                            @click="$('#activityModal').data('id', '69').modal('show')">
                                            CunningCobra1
                                            <!--[if BLOCK]><![endif]--> <i class="fas fa-shield"
                                                style="color: #da2d2d; font-size: 11px"></i>
                                            <span class="text-secondary"
                                                style="font-size: 10px !important;">Admin</span>
                                            <!--[if ENDBLOCK]><![endif]-->
                                        </div>

                                        <span class="text-secondary small text-end d-flex align-items-center"
                                            style="font-size: 10px !important;">
                                            06:59 PM

                                            <span class="mx-2 text-primary"
                                                style="font-size: 11px !important; cursor: pointer; display: none !important;"
                                                x-show.important="showMention" x-transition=""
                                                @click="document.getElementById('message-to-send').value += '@CunningCobra1'; document.getElementById('message-to-send').focus();">
                                                <i class="fas fa-at"></i>
                                            </span>
                                        </span>

                                    </span>
                                    <span class="text-body">

                                        <!--[if BLOCK]><![endif]--> I want Buy this script
                                        <!--[if ENDBLOCK]><![endif]-->
                                    </span>
                                </div>
                            </div>
                            <div
                                class="d-flex align-items-start gap-2 mb-2 bg-label-secondary py-2 px-3 rounded message">
                                <div style="cursor: pointer"
                                    @click="$('#activityModal').data('id', '33').modal('show')">


                                    <div class="progress-circle"
                                        style="background: conic-gradient(var(--bs-primary) 0% 4545%, var(--bs-dark) 4545% 100%);">
                                        <img src="/assets/avatars/memoji_15.png" alt="CrimsonDagger"
                                            class="rounded-circle"
                                            style="width: 35px !important; height: 35px !important;">

                                        <div class="badge bg-primary rounded-circle text-white"
                                            style="position: absolute; bottom: 0; right: 0; font-size: 10px; padding: 2px 5px; z-index: 11">
                                            4
                                        </div>
                                    </div>



                                </div>
                                <div style="line-height: 1.2; width: 100%" x-data="{ showMention: false }"
                                    @mouseover="showMention = true" @mouseleave="showMention = false">
                                    <span class="d-flex align-items-center justify-content-between mb-1 text-white">
                                        <div style="cursor: pointer"
                                            @click="$('#activityModal').data('id', '33').modal('show')">
                                            CrimsonDagger
                                            <!--[if BLOCK]><![endif]--> <i class="fas fa-shield"
                                                style="color: #da2d2d; font-size: 11px"></i>
                                            <span class="text-secondary"
                                                style="font-size: 10px !important;">Admin</span>
                                            <!--[if ENDBLOCK]><![endif]-->
                                        </div>

                                        <span class="text-secondary small text-end d-flex align-items-center"
                                            style="font-size: 10px !important;">
                                            03:26 PM

                                            <span class="mx-2 text-primary"
                                                style="font-size: 11px !important; cursor: pointer; display: none !important;"
                                                x-show.important="showMention" x-transition=""
                                                @click="document.getElementById('message-to-send').value += '@CrimsonDagger'; document.getElementById('message-to-send').focus();">
                                                <i class="fas fa-at"></i>
                                            </span>
                                        </span>

                                    </span>
                                    <span class="text-body">

                                        <!--[if BLOCK]><![endif]--> hi
                                        <!--[if ENDBLOCK]><![endif]-->
                                    </span>
                                </div>
                            </div>
                            <div
                                class="d-flex align-items-start gap-2 mb-2 bg-label-secondary py-2 px-3 rounded message">
                                <div style="cursor: pointer"
                                    @click="$('#activityModal').data('id', '33').modal('show')">


                                    <div class="progress-circle"
                                        style="background: conic-gradient(var(--bs-primary) 0% 4545%, var(--bs-dark) 4545% 100%);">
                                        <img src="/assets/avatars/memoji_15.png" alt="CrimsonDagger"
                                            class="rounded-circle"
                                            style="width: 35px !important; height: 35px !important;">

                                        <div class="badge bg-primary rounded-circle text-white"
                                            style="position: absolute; bottom: 0; right: 0; font-size: 10px; padding: 2px 5px; z-index: 11">
                                            4
                                        </div>
                                    </div>



                                </div>
                                <div style="line-height: 1.2; width: 100%" x-data="{ showMention: false }"
                                    @mouseover="showMention = true" @mouseleave="showMention = false">
                                    <span class="d-flex align-items-center justify-content-between mb-1 text-white">
                                        <div style="cursor: pointer"
                                            @click="$('#activityModal').data('id', '33').modal('show')">
                                            CrimsonDagger
                                            <!--[if BLOCK]><![endif]--> <i class="fas fa-shield"
                                                style="color: #da2d2d; font-size: 11px"></i>
                                            <span class="text-secondary"
                                                style="font-size: 10px !important;">Admin</span>
                                            <!--[if ENDBLOCK]><![endif]-->
                                        </div>

                                        <span class="text-secondary small text-end d-flex align-items-center"
                                            style="font-size: 10px !important;">
                                            03:26 PM

                                            <span class="mx-2 text-primary"
                                                style="font-size: 11px !important; cursor: pointer; display: none !important;"
                                                x-show.important="showMention" x-transition=""
                                                @click="document.getElementById('message-to-send').value += '@CrimsonDagger'; document.getElementById('message-to-send').focus();">
                                                <i class="fas fa-at"></i>
                                            </span>
                                        </span>

                                    </span>
                                    <span class="text-body">

                                        <!--[if BLOCK]><![endif]--> hi
                                        <!--[if ENDBLOCK]><![endif]-->
                                    </span>
                                </div>
                            </div>
                            <div
                                class="d-flex align-items-start gap-2 mb-2 bg-label-secondary py-2 px-3 rounded message">
                                <div style="cursor: pointer"
                                    @click="$('#activityModal').data('id', '33').modal('show')">


                                    <div class="progress-circle"
                                        style="background: conic-gradient(var(--bs-primary) 0% 4545%, var(--bs-dark) 4545% 100%);">
                                        <img src="/assets/avatars/memoji_15.png" alt="CrimsonDagger"
                                            class="rounded-circle"
                                            style="width: 35px !important; height: 35px !important;">

                                        <div class="badge bg-primary rounded-circle text-white"
                                            style="position: absolute; bottom: 0; right: 0; font-size: 10px; padding: 2px 5px; z-index: 11">
                                            4
                                        </div>
                                    </div>



                                </div>
                                <div style="line-height: 1.2; width: 100%" x-data="{ showMention: false }"
                                    @mouseover="showMention = true" @mouseleave="showMention = false">
                                    <span class="d-flex align-items-center justify-content-between mb-1 text-white">
                                        <div style="cursor: pointer"
                                            @click="$('#activityModal').data('id', '33').modal('show')">
                                            CrimsonDagger
                                            <!--[if BLOCK]><![endif]--> <i class="fas fa-shield"
                                                style="color: #da2d2d; font-size: 11px"></i>
                                            <span class="text-secondary"
                                                style="font-size: 10px !important;">Admin</span>
                                            <!--[if ENDBLOCK]><![endif]-->
                                        </div>

                                        <span class="text-secondary small text-end d-flex align-items-center"
                                            style="font-size: 10px !important;">
                                            12:50 PM

                                            <span class="mx-2 text-primary"
                                                style="font-size: 11px !important; cursor: pointer; display: none !important;"
                                                x-show.important="showMention" x-transition=""
                                                @click="document.getElementById('message-to-send').value += '@CrimsonDagger'; document.getElementById('message-to-send').focus();">
                                                <i class="fas fa-at"></i>
                                            </span>
                                        </span>

                                    </span>
                                    <span class="text-body">

                                        <!--[if BLOCK]><![endif]--> 😆
                                        <!--[if ENDBLOCK]><![endif]-->
                                    </span>
                                </div>
                            </div>
                            <div
                                class="d-flex align-items-start gap-2 mb-2 bg-label-secondary py-2 px-3 rounded message">
                                <div style="cursor: pointer"
                                    @click="$('#activityModal').data('id', '33').modal('show')">


                                    <div class="progress-circle"
                                        style="background: conic-gradient(var(--bs-primary) 0% 4545%, var(--bs-dark) 4545% 100%);">
                                        <img src="/assets/avatars/memoji_15.png" alt="CrimsonDagger"
                                            class="rounded-circle"
                                            style="width: 35px !important; height: 35px !important;">

                                        <div class="badge bg-primary rounded-circle text-white"
                                            style="position: absolute; bottom: 0; right: 0; font-size: 10px; padding: 2px 5px; z-index: 11">
                                            4
                                        </div>
                                    </div>



                                </div>
                                <div style="line-height: 1.2; width: 100%" x-data="{ showMention: false }"
                                    @mouseover="showMention = true" @mouseleave="showMention = false">
                                    <span class="d-flex align-items-center justify-content-between mb-1 text-white">
                                        <div style="cursor: pointer"
                                            @click="$('#activityModal').data('id', '33').modal('show')">
                                            CrimsonDagger
                                            <!--[if BLOCK]><![endif]--> <i class="fas fa-shield"
                                                style="color: #da2d2d; font-size: 11px"></i>
                                            <span class="text-secondary"
                                                style="font-size: 10px !important;">Admin</span>
                                            <!--[if ENDBLOCK]><![endif]-->
                                        </div>

                                        <span class="text-secondary small text-end d-flex align-items-center"
                                            style="font-size: 10px !important;">
                                            12:58 PM

                                            <span class="mx-2 text-primary"
                                                style="font-size: 11px !important; cursor: pointer; display: none !important;"
                                                x-show.important="showMention" x-transition=""
                                                @click="document.getElementById('message-to-send').value += '@CrimsonDagger'; document.getElementById('message-to-send').focus();">
                                                <i class="fas fa-at"></i>
                                            </span>
                                        </span>

                                    </span>
                                    <span class="text-body">

                                        <!--[if BLOCK]><![endif]--> Uo
                                        <!--[if ENDBLOCK]><![endif]-->
                                    </span>
                                </div>
                            </div>
                            <!--[if ENDBLOCK]><![endif]-->
                            <div class="ps__rail-x" style="left: 0px; bottom: -732px;">
                                <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                            </div>
                            <div class="ps__rail-y" style="top: 732px; height: 593px; right: 0px;">
                                <div class="ps__thumb-y" tabindex="0" style="top: 328px; height: 265px;"></div>
                            </div>
                        </div>

                        <!-- Chat Input -->
                        <div class="custom-card-footer pt-3 pb-1 px-2">

                            <div class="d-flex position-absolute left-0"
                                style="bottom: 100px; z-index: 99999999; left: 0" wire:ignore="" id="emoji-picker">
                            </div>

                            <!--[if BLOCK]><![endif]--> <button class="btn btn-primary w-100" type="button"
                                data-bs-target="#authModal" data-bs-toggle="modal">
                                Login to chat
                            </button>
                            <!--[if ENDBLOCK]><![endif]-->
                        </div>
                    </div>
                </div>
            </div>
            <div wire:snapshot="{&quot;data&quot;:{&quot;show&quot;:false,&quot;user&quot;:null,&quot;paginators&quot;:[[],{&quot;s&quot;:&quot;arr&quot;}]},&quot;memo&quot;:{&quot;id&quot;:&quot;my1ZwsBSxH1q4HJOKiMW&quot;,&quot;name&quot;:&quot;user.activity-modal&quot;,&quot;path&quot;:&quot;\/&quot;,&quot;method&quot;:&quot;GET&quot;,&quot;children&quot;:[],&quot;scripts&quot;:[],&quot;assets&quot;:[&quot;357040923-0&quot;],&quot;errors&quot;:[],&quot;locale&quot;:&quot;en&quot;},&quot;checksum&quot;:&quot;850dc6d3758f0543dbc995550df8409f1d686e56c6e9965695ca8210e91566a2&quot;}"
                wire:effects="{&quot;listeners&quot;:[&quot;activity-open&quot;]}" wire:id="my1ZwsBSxH1q4HJOKiMW">
                <div wire:ignore.self="" class="modal fade" id="activityModal" tabindex="-1" x-data="{ loading: true }"
                    x-init="() =&gt; {
                $('#activityModal').on('show.bs.modal', function (event) {
                    let id = $(this).data('id');
                    $el._x_dataStack[0].loading = true;
                    window.Livewire.find('my1ZwsBSxH1q4HJOKiMW').openModel(id);
                });

                $(window).on('activity-modal-opened', function () {
                    $el._x_dataStack[0].loading = false;
                });
            }" style="z-index: 9999999999;">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen-sm-down">
                        <div class="modal-content">


                            <div class="modal-header mb-0 pb-0">
                                <div class="row align-items-center" x-show="!loading" style="display: none;">
                                    <div class="col-4 col-md-6 text-center">

                                        <div class="progress-circle"
                                            style="background: conic-gradient(var(--bs-primary) 0% 0%, var(--bs-dark) 0% 100%);">
                                            <img src="" alt="" class="rounded-circle" style="width: 100px;">
                                        </div>
                                        <div class="mt-2">
                                            <span class="badge bg-primary">Level </span>
                                        </div>
                                    </div>
                                    <div class="col-8 col-md-6 text-center">
                                        <h5 class="fw-bold mb-0 h2"></h5>
                                        <small class="text-secondary"></small>
                                    </div>
                                </div>


                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <div class="d-flex justify-content-center align-items-center p-4"
                                x-show.important="loading">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>

                            <div class="modal-body ps" x-show="!loading" style="display: none;">
                                <hr>
                                <div class="row text-center" x-show="!loading" style="display: none;">
                                    <h5 class="fw-bold text-start text-white">
                                        <i class="fa-solid fa-chart-simple text-secondary me-2"></i> Stats
                                    </h5>

                                    <!--[if BLOCK]><![endif]-->
                                    <div class="col">
                                        <h6 class="mb-2">Offers Completed</h6>
                                        <span></span>
                                    </div>
                                    <div class="col">
                                        <h6 class="mb-2">Coins Earned</h6>
                                        <p></p>
                                    </div>
                                    <div class="col">
                                        <h6 class="mb-2">Users Referred</h6>
                                        <p></p>
                                    </div>
                                    <!--[if ENDBLOCK]><![endif]-->
                                </div>

                                <hr>
                                <div class="row">
                                    <h5 class="fw-bold text-start text-white">
                                        <i class="fa-solid fa-rocket text-secondary me-2"></i> Activity
                                    </h5>

                                    <!--[if BLOCK]><![endif]-->
                                    <div class="table-responsive">
                                        <table class="table table-borderless small">
                                            <thead>
                                                <tr>
                                                    <th scope="col" style="text-transform: unset !important;">Name</th>
                                                    <th scope="col" style="text-transform: unset !important;">Time</th>
                                                    <th scope="col" style="text-transform: unset !important;">Reward
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!--[if BLOCK]><![endif]-->
                                                <tr>
                                                    <td colspan="3" class="text-center">No activity found</td>
                                                </tr>
                                                <!--[if ENDBLOCK]><![endif]-->
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                    <!--[if ENDBLOCK]><![endif]-->
                                </div>
                                <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                                    <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                                </div>
                                <div class="ps__rail-y" style="top: 0px; right: 0px;">
                                    <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div role="status" id="toaster"
            x-data="toasterHub([], JSON.parse('{\u0022alignment\u0022:\u0022bottom\u0022,\u0022duration\u0022:3000,\u0022replace\u0022:false,\u0022suppress\u0022:false}'))"
            style="z-index: 9999999999999999  !important;"
            class="position-fixed p-4 w-100 d-flex flex-column pe-none bottom-0 align-items-end rtl:items-start">
            <template x-for="toast in toasts" :key="toast.id">
                <div x-show="toast.isVisible" x-init="$nextTick(() =&gt; toast.show($el))"
                    x-transition:enter-start="translate-y-12 opacity-0"
                    x-transition:enter-end="translate-y-0 opacity-100" x-transition:leave-end="opacity-0 scale-90"
                    class="position-relative w-100 pe-auto"
                    style="max-width: 20rem; transition: all 0.3s ease-in-out !important">
                    <div class="toast align-items-center d-inline-block mb-2" role="alert" aria-live="assertive"
                        :class="toast.select({ error: 'bg-danger', info: 'bg-secondary', success: 'bg-success', warning: 'bg-warning' })"
                        aria-atomic="true">
                        <div class="d-flex">
                            <div class="toast-body"
                                :class="toast.select({ error: 'text-white', info: 'text-white', success: 'text-white', warning: 'text-white' })">
                                <i class="me-2 fa-solid"
                                    :class="toast.select({ error: 'fa-circle-exclamation',  info: 'fa-circle-info', success: 'fa-circle-check', warning: 'fa-triangle-exclamation'})"></i>
                                <span x-text="toast.message"></span>
                            </div>
                            <button type="button" @click="toast.dispose()" class="btn-close me-2 m-auto"
                                data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            </template>
        </div>
        <!-- 👈 -->
        <div x-data="{ offer: null, is_coin: localStorage.getItem('isCoin') || '0' }"
            x-on:update-coins.window="is_coin = $event.detail.isCoin" x-on:open-offer-api-modal.window="
        offer = $event.detail;
        $nextTick(() =&gt; {
            $('#offerApiModal').modal('show');
        });
    " wire:ignore.self="" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="offerApiModal"
            style="z-index: 9999999">

            <div class="modal-dialog modal-dialog-scrollable modal-md modal-fullscreen-sm-down modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-body f-md" x-text="window.decodeHtml(offer?.title || 'Loading...')">
                            Loading...</h4>
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body ps">
                        <!-- Loading Indicator -->
                        <div x-show="!offer" class="text-center">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p>Loading info...</p>
                        </div>

                        <!-- Offer Details -->
                        <div x-show="offer" class="h-100" style="display: none;">

                            <!-- Offer Details -->
                            <div x-show="offer" class="d-flex flex-column h-100" style="display: none;">
                                <div class="flex-grow-1 overflow-auto">

                                    <!-- Offer Header -->
                                    <div class="d-flex">
                                        <div class="position-relative">
                                            <img :src="offer?.image || ''" width="149"
                                                style="aspect-ratio: 1 / 1; border-radius: 10px" alt="" src="">

                                            <!-- Devices -->
                                            <div class="badge bg-label-dark position-absolute"
                                                style="top: 3px; right: 3px; padding: 5px 8px; background-color: #18212fc9 !important">
                                                <div class="gap-2 d-flex align-items-center justify-content-center">
                                                    <span class="text-white fa-brands fa-android"
                                                        x-show="offer?.devices &amp;&amp; offer?.devices.includes('Android')"
                                                        style="display: none;"></span>
                                                    <span class="text-white fa-brands fa-apple"
                                                        x-show="offer?.devices &amp;&amp; offer?.devices.includes('iOS')"
                                                        style="display: none;"></span>
                                                    <span class="text-white fa-solid fa-laptop"
                                                        x-show="(offer?.devices &amp;&amp; offer?.devices.includes('Desktop')) || (offer?.devices.length === 0)"
                                                        style="display: none;"></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="gap-2 d-flex flex-column justify-content-start ms-3">
                                            <!-- Provider -->
                                            <span class="d-flex align-items-center badge bg-primary">
                                                <i class="fa-solid fa-rocket me-2"></i>
                                                <span x-text="offer?.provider || ''"></span>
                                            </span>

                                            <!-- Points or Coins -->
                                            <div>
                                                <span class="badge bg-dark">
                                                    <template x-if="is_coin == '0'">
                                                        <span class="d-flex align-items-end fw-bold"
                                                            style="font-size: 15px; line-height: 16px">
                                                            $<span x-text="Math.floor(offer?.points / 1000)"></span>.
                                                            <span style="font-size: 10px; line-height: 12px"
                                                                class="fw-bold"
                                                                x-text="(offer?.points / 1000).toFixed(2).substring(2)"></span>
                                                        </span>
                                                    </template>
                                                    <template x-if="is_coin == '1'">
                                                        <span class="d-flex align-items-center fw-medium"
                                                            style="font-size: 13px; line-height: 0">
                                                            <img src="/assets/img/coin.png" alt="" width="12px"
                                                                class="me-1">
                                                            <span
                                                                x-text="Number(offer?.points).toLocaleString()"></span>
                                                        </span>
                                                    </template><span class="d-flex align-items-center fw-medium"
                                                        style="font-size: 13px; line-height: 0">
                                                        <img src="/assets/img/coin.png" alt="" width="12px"
                                                            class="me-1">
                                                        <span x-text="Number(offer?.points).toLocaleString()">NaN</span>
                                                    </span>
                                                </span>
                                            </div>

                                            <!-- Categories -->
                                            <span class="badge bg-dark">
                                                <span x-text="offer?.categories ? offer?.categories[0] : ''"></span>
                                            </span>

                                            <!-- Status -->

                                        </div>
                                    </div>

                                    <!-- Start Offer Button -->
                                    <div class="mt-auto mt-md-4">
                                        <a class="btn btn-primary w-100"
                                            :href="offer?.link ? offer?.link.replace('{user_id}', '') : '#'"
                                            target="_blank" href="#">
                                            <i class="fa-solid fa-play me-2"></i>
                                            Start Offer
                                        </a>
                                    </div>

                                    <!-- Description -->
                                    <div class="mt-4">
                                        <div class="mt-2 px-4 p-2  bg-opacity-50 bg-dark" style="border-radius: 20px;">
                                            <p class="text-center text-body m-0 p-0" style="font-size: 11px"
                                                x-html="offer?.description || ''"></p>
                                        </div>
                                    </div>

                                    <!-- Rewards -->
                                    <div class="mt-4" x-show="offer?.events &amp;&amp; offer?.events?.length &gt; 0"
                                        style="display: none;">
                                        <p class="text-body fw-bold m-0 p-0 f-md"
                                            style="font-size: 14px; line-height: 160%">
                                            Rewards</p>
                                        <template x-for="event in offer?.events" :key="event?.name">
                                            <div class="mt-1 px-4 p-2 bg-opacity-50 bg-dark text-truncate"
                                                style="border-radius: 20px; font-size: 11px">
                                                <span class="badge bg-label-primary text-center rounded"
                                                    style="min-width: 60px; font-size: 11px">
                                                    <template x-if="is_coin == '1'">
                                                        <img src="/assets/img/coin.png" alt="" width="12px"
                                                            class="me-1">
                                                    </template>

                                                    <span
                                                        x-text="is_coin == '1' ? Number(event?.points).toLocaleString() : '$' + event?.points.toFixed(2)"></span>
                                                </span>
                                                <span class="text-body ms-1" x-text="event?.name || ''"></span>
                                            </div>
                                        </template>
                                    </div>

                                    <!-- Steps -->
                                    <div class="mt-4"
                                        x-show="offer?.instructions &amp;&amp; offer?.instructions.length &gt; 0"
                                        style="display: none;">
                                        <p class="fw-bold m-0 p-0 f-md" style="font-size: 14px; line-height: 160%">Steps
                                        </p>
                                        <template x-for="(instruction, index) in offer?.instructions" :key="index">
                                            <div class="mt-2 d-flex align-items-center">
                                                <span class="bg-label-secondary text-center rounded fw-medium"
                                                    style="font-size: 11px !important ; width: 18px"
                                                    x-text="index + 1"></span>
                                                <span class="small text-body ms-2" style="font-size: 11px"
                                                    x-text="instruction"></span>
                                            </div>
                                        </template>
                                    </div>
                                </div>

                            </div>


                        </div>
                        <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                            <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                        </div>
                        <div class="ps__rail-y" style="top: 0px; right: 0px;">
                            <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- لازم jQuery يجي قبل الكود اللي فيه Ajax -->
        <script src="/assets/vendor/jquery/jquery-3.3.1.min.js"></script>
        <script src="/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="/assets/vendor/apexcharts/apexcharts.min.js"></script>
        <script src="/assets/vendor/chart.js/chart.min.js"></script>
        <script src="/assets/vendor/echarts/echarts.min.js"></script>
        <script src="/assets/vendor/tinymce/tinymce.min.js"></script>
        <script src="/assets/js/main.js"></script>



        <link rel="modulepreload" href="/assets/js/jquery-Besvc1ch.js">
        <link rel="modulepreload" href="/assets/js/jquery-D4UJyEuM.js">
        <link rel="modulepreload" href="/assets/js/_commonjsHelpers.js">
        <link rel="modulepreload" href="/assets/js/bootstrap.js">
        <link rel="modulepreload" href="/assets/js/perfect-scrollbar.js">
        <link rel="modulepreload" href="/assets/js/typeahead-BMpJMo7v.js">
        <link rel="modulepreload" href="/assets/js/menu.js">
        <script type="module" src="/assets/js/jquery-Besvc1ch.js" data-navigate-track="reload"></script>
        <script type="module" src="/assets/js/bootstrap.js" data-navigate-track="reload"></script>
        <script type="module" src="/assets/js/perfect-scrollbar.js" data-navigate-track="reload"></script>
        <script type="module" src="/assets/js/typeahead-BMpJMo7v.js" data-navigate-track="reload"></script>
        <script type="module" src="/assets/js/menu.js" data-navigate-track="reload"></script>
        <link rel="modulepreload" href="/assets/js/main-DEznZHQ5.js">
        <script type="module" src="/assets/js/main-DEznZHQ5.js" data-navigate-track="reload"></script>
        <link rel="preload" as="style" href="/assets/css/app.css">
        <link rel="modulepreload" href="/assets/js/app-DVCFGZsK.js">
        <link rel="modulepreload" href="/assets/js/_commonjsHelpers.js">
        <link rel="stylesheet" href="/assets/css/app.css" data-navigate-track="reload">
        <script type="module" src="/assets/js/app-DVCFGZsK.js" data-navigate-track="reload"></script>
        <!-- كود الـ Ajax المضغوط أو المكتوب -->
        <?php
        if (!empty($js_code)) {
            $packer = new JavaScriptPacker($js_code, 'Normal', true, false);
            $packed = $packer->pack();
            echo '<script>' . $packed . '</script>';
        }
        ?> <!-- Livewire Scripts -->
        <script src="/vendor/livewire/livewire.js" data-csrf="35soLijFrQoKe47ooYTLPADiLQQ8zUkUEpOEBFMZ"
            data-update-uri="/livewire/update" data-navigate-once="true"></script>
        <?php
        if (!empty($config['recaptcha_pub'])) {
            echo '<script src="https://www.google.com/recaptcha/api.js" async></script>';
        }

        $js_code = '';
        if (isset($_GET['activate']) && !empty($_GET['activate'])) {
            $code = $db->EscapeString($_GET['activate']);
            if ($db->QueryGetNumRows("SELECT `id` FROM `users` WHERE `activate`='" . $code . "' LIMIT 1") > 0) {
                $db->Query("UPDATE `users` SET `activate`='0' WHERE `activate`='" . $code . "'");
                $js_code .= '$(document).ready(function() {$("#loginStatus").html(\'<div class="alert alert-success" role="alert">E-mail address was successfully verified!</div>\'); });';
            }
        }

        $js_code .= '$("#loginForm").on("submit", function(e) {
		e.preventDefault();
		$("#loginStatus").html(\'<div class="alert alert-info" role="alert">Please wait...</div>\');
		var token = $("#loginToken").val();
		var username = $("#userLogin").val();
		var password = $("#userPass").val();
		var remember = $("#remember").val();
		if(username == "") {
			$("#loginStatus").html(\'<div class="alert alert-danger" role="alert">Please complete your username or email address!</div>\');
		} else if(password == "") {
			$("#loginStatus").html(\'<div class="alert alert-danger" role="alert">Please complete your password!</div>\');
		} else if(token == "") {
			$("#loginStatus").html(\'<div class="alert alert-danger" role="alert">Session expired, please refresh this page and try again!</div>\');
		} else {
			var response = ' . (empty($config['recaptcha_pub']) ? 'null' : 'grecaptcha.getResponse(0)') . ';
			$.ajax({
				type: "POST",
				url: "../../system/ajax.php",
				data: {a: "login", token: token, username: username, password: password, remember: remember, recaptcha: response},
				dataType: "json",
				success: function(data) {
					if(data.status == 0){
						' . (empty($config['recaptcha_pub']) ? '' : 'grecaptcha.reset(0);') . '
						$("#loginStatus").html(data.msg).fadeIn("slow");
					}else{
						$("#loginStatus").html(data.msg).fadeIn("slow");
						window.setTimeout(function() {
							document.location.href = "' . $config['secure_url'] . '";
						}, 750);
					}
				}
			});
		}
	});';

        if (!$recover_key) {
            $js_code .= '$("#recoverPass").on("submit", function(e) {
				e.preventDefault();
				$("#recoverStatus").html(\'<div class="alert alert-info" role="alert">Please wait...</div>\');
				var token = $("#recoverToken").val();
				var email = $("#recoverEmail").val();
				if(email == "") {
					$("#recoverStatus").html(\'<div class="alert alert-danger" role="alert">Please complete your email address!</div>\');
				} else {
					var response = ' . (empty($config['recaptcha_pub']) ? 'null' : 'grecaptcha.getResponse(1)') . ';
					$.ajax({
						type: "POST",
						url: "../../system/ajax.php",
						data: {a: "recover", token: token, email: email, recaptcha: response},
						dataType: "json",
						success: function(data) {
							$("#recoverStatus").html(data.msg).fadeIn("slow");
						}
					});
				}
			});';
        } else {
            $js_code .= '$("#changePass").on("submit", function(e) {
				e.preventDefault();
				$("#recoverStatus").html(\'<div class="alert alert-info" role="alert">Please wait...</div>\');
				var token = $("#changePassToken").val();
				var pass1 = $("#newPassword").val();
				var pass2 = $("#confirmPassword").val();
				if(pass1 == "" || pass1.length < 8) {
					$("#recoverStatus").html(\'<div class="alert alert-danger" role="alert">Your password must contain at least 8 characters, 1 lowercase letter, 1 capital letter and 1 number!</div>\');
				} else if(pass1 != pass2) {
					$("#recoverStatus").html(\'<div class="alert alert-danger" role="alert">Your password confirmation is wrong!</div>\');
				} else {
					var response = ' . (empty($config['recaptcha_pub']) ? 'null' : 'grecaptcha.getResponse(1)') . ';
					$.ajax({
						type: "POST",
						url: "../../system/ajax.php",
						data: {a: "changePass", token: token, pass1: pass1, pass2: pass2, hash_key: "' . $getKey . '", recaptcha: response},
						dataType: "json",
						success: function(data) {
							if(data.status == 200) {
								$("#loginStatus").html(data.msg).fadeIn("slow");
								$("#recoverModal").modal("hide");
							} else {
								$("#recoverStatus").html(data.msg).fadeIn("slow");
							}
						}
					});
				}
			});';
        }

        $js_code .= ($recover_key ? '$(document).ready(function() {$("#recoverModal").modal("show");});' : '');

        if (!empty($js_code)) {
            $packer = new JavaScriptPacker($js_code, 'Normal', true, false);
            $packed = $packer->pack();

            echo '<script>' . $packed . '</script>';
        }

        if (!empty($config['analytics_id'])) {
            ?>
            <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $config['analytics_id']; ?>"></script>
            <script>
                window.dataLayer = window.dataLayer || [];
                function gtag() { dataLayer.push(arguments); }
                gtag('js', new Date());

                gtag('config', '<?php echo $config['analytics_id']; ?>');
            </script>
        <?php } ?>
</body>

</html>