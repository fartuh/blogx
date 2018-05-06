<head>
    <?php // styles("main.css") ?>
</head>
<h1><?= get_title($page_id, $settings) ?></h1>
<h2><?= get_text($page_id, $settings) ?></h2>
<h3>Автор: <?= get_author($page_id, $settings)->access ?></h3>
