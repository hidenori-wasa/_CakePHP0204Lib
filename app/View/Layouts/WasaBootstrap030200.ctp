<!-- "WasaBootstrap030200" layout. -->

<!DOCTYPE html>
<html lang="ja">
    <head>
        <!-- Makes compatibility mode of Internet Explorer invalid because layout collapses. -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- For responsive web design, browser for smart phone is denied the display width change automatically. -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
        <?php
        // Loads "WasaGlobalErrorHandler" JavaScript.
        echo $this->Html->script('WasaGlobalErrorHandler');
        echo $this->fetch('script');

        ?>
        <title>
            <?php echo $title_for_layout; ?>
        </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <?php
        // Loads the Bootstrap 3.2.0 CSS.
        echo $this->Html->css('bootstrap-3.2.0.grid120.min');
        echo $this->Html->css('bootstrap-3.2.0-theme.min');
        echo $this->fetch('css');

        ?>
        <style>
            body {
                padding-top: 70px; /* 70px to make the container go all the way to the bottom of the topbar */
            }
            .affix {
                position: fixed;
                top: 60px;
                width: 220px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <?php
            echo $this->Session->flash();
            echo $this->fetch('content');

            ?>
        </div>

        <?php
        // Loads jQuery 1.10.2 JavaScript.
        echo $this->Html->script('jquery-1.10.2.min');
        // Loads the Bootstrap 3.2.0 JavaScript.
        echo $this->Html->script('bootstrap-3.2.0.min');
        // Loads "Wasa" JavaScript.
        echo $this->Html->script('Wasa');
        echo $this->fetch('script');
        echo $this->element('sql_dump');

        ?>
    </body>
</html>
