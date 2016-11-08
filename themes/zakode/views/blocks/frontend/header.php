<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo Modules::run('pref/_site_name').' | '.$template['title'] ?></title>
    <base href="<?php echo base_url(); ?>" />
    <?php
        foreach ($meta_data as $name => $content){
            echo "<meta name='$name' content='$content'>".PHP_EOL;
        }
        foreach ($stylesheets as $media => $files){
            foreach ($files as $file){
                $url = starts_with($file, 'http') ? $file : base_url($file);
                echo "<link href='$url' rel='stylesheet' media='$media'>".PHP_EOL;	
            }
        }
        foreach ($scripts['head'] as $file){
            $url = starts_with($file, 'http') ? $file : base_url($file);
            echo "<script src='$url'></script>".PHP_EOL;
        }
    ?>
    <link rel="shortcut icon" href="<?php echo img_url(); ?>favicon.ico" type="image/vnd.microsoft.icon" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>