<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{block name=title}Blog{/block}</title>
    <link rel="stylesheet" href="/style.css">
</head>
<body>

<header class="header">
    <div class="container">
        <a class="header-link" href="/">Blog</a>
    </div>
</header>

<main>
    <div class="container">
        {block name=body}{/block}
    </div>
</main>

<footer class="footer">
    <div class="container">
        Blog
    </div>
</footer>
</body>
</html>