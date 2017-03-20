<!doctype html>
<html class="no-js" lang="ko">
<head>
    <title>배명진의 포트폴리오</title>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <link rel="shortcut icon" type="image/x-icon" href="/portfolio/favicon.ico">
    <link rel="stylesheet" href="<?php echo ROOT_DIR;?>/css/main.css">
    <link rel="stylesheet" href="<?php echo ROOT_DIR;?>/css/mobile.css">
    <link rel="stylesheet" href="<?php echo ROOT_DIR;?>/css/web.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
</head>
<body>
<div class="header_upper">
    <div class="header_upper_title">
        <a href="/portfolio">Portfolio of Bae MyoungJin</a>
    </div>
    <nav class="top_menu">
        <ul>
            <?php $category_list = [
                    ['Development','dev','code'],
                    ['Design','des','paint-brush'],
                    ['About Me','profile','user'],
                    ['Write','edit','pencil']
            ];
            ?>
            <?php foreach($category_list as list ($cate,$link,$icon)):?>
                <li>
                    <a href="/portfolio/<?php echo $link;?>" title="<?php echo $cate;?>">
                    <span class="fa-stack fa-lg" style="font-size: 1em">
                        <i class="fa fa-circle fa-stack-2x"></i>
                        <i class="fa fa-<?php echo $icon;?> fa-stack-1x fa-inverse"></i>
                    </span>
                    <span class="nav_txt"><?php echo $cate;?></span>
                    </a>
                </li>
            <?php endforeach;?>
        </ul>
    </nav>
</div>
<div class="wrapper">
    <?php echo $list; ?>
</div>
</body>
</html>