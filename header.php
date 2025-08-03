<!DOCTYPE html> <!--header file used by most pages-->
<html lang="en">

<head>
    <title><?php echo $pageTitle?></title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="logo.svg">

    <link href="css/style.css" rel="stylesheet" > <!--Reference to style.css file -->
    <meta charset="UTF-8"> <!--SEO tags -->
    <meta name="author" content="Isaac Encina">
    <meta name="description" content="My clothes store front for comp 3340 project">
    <meta name="keywords" content="web dev, html, comp 3340, clothes, store">
    <script src="js/theme.js" defer></script>
</head>

<body >

    <audio id="bg-music" autoplay loop> <!-- looping background music -->
        <source src="media/theme-default.mp3" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>
    <button id="mute-toggle" title="Mute/Unmute" class="material-symbols-outlined" style="background: none; border: none; font-size: 24px; cursor: pointer; color: var(--text-color);">
        volume_up
    </button> <!--mute and unmute button-->
    
    
    <header>
        <div class="title">
            <a href="index.php" title="Home"> <!--logo also serves as home button-->
                <img src="logo.svg" alt="store logo" width="100" height="100">
            </a>
            <h1>Clothes Store</h1>
        </div>
        
        <nav class="nav-head"> <!-- icons for home, account and cart buttons -->
            <a href="index.php" class="material-symbols-outlined" title="Home">home</a>
            <a href="account.php" class="material-symbols-outlined" title="Account">account_circle</a>
            <a href="cart.php" class="material-symbols-outlined"title="Cart">shopping_cart</a>
        </nav>
    </header>