<?php
$title					= 'Lista de Projetos Locais';
$directory				= __DIR__;
$domain 				= '.test';
$show_project           = 'both'; // directory, domain, both
$scanned_directories	= array_diff(scandir($directory), array('..', '.'));
$skip_start_with		= array('.');
$skip_file_name		    = array('index.php', 'composer.phar');
if (!empty($_GET['q'])) {
    switch ($_GET['q']) {
        case 'info':
            phpinfo();
            exit;
            break;
    }
}
function startsWith($strings, $start_string) {
    foreach ($strings as $string) {
        $len_string = strlen($string);
        $hasString = substr($string, 0, $len_string) == substr($start_string, 0, $len_string);
        if ($hasString) {
            break;
        }
    }
    return $hasString;
}
function skipFile($strings, $filename) {
    foreach ($strings as $string) {
        $skip = $string == $filename;
        if ($skip) {
            break;
        }
    }
    return $skip;
}
function checkDirType($dirName) {
    switch($dirName) {
        case strpos($dirName, 'wp') !== false:
            return "wp";
            break;
        case strpos($dirName, 'laravel') !== false:
        case strpos($dirName, 'lara') !== false:
            return "lara";
            break;
        case strpos($dirName, 'git') !== false:
            return "git";
            break;
        case strpos($dirName, 'php') !== false:
            return "php";
            break;
        case strpos($dirName, 'app') !== false:
        case strpos($dirName, 'vue') !== false:
            return "vue";
            break;
        default:
            return "php";
            break;
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?=$title?></title>
        <link href="https://fonts.googleapis.com/css?family=Karla:400" rel="stylesheet" type="text/css">
        <style>
            body {
                background-image: url("https://user-images.githubusercontent.com/33905714/128099250-f32028cb-7d93-40db-8440-c059fd0def69.jpg");
                background-size: cover;
                margin: 0;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            }
            .info {
                color: whitesmoke;
            }
            .card-container {
                display: flex;
                justify-content: center;
                flex-wrap: wrap;
            }
            .card-width {
                height: 500px;
                width: 350px;
                margin: 50px;
                border-radius: 42px;
                box-shadow: 2px 2px 22px rgba(0, 0, 0, 0.2);
                transition: .3s box-shadow, .3s margin-top ease-in-out;
            }
            .card-width:hover {
                box-shadow: 2px 12px 32px rgba(0, 0, 0, 0.5);
                margin-top: 30px;
                cursor: pointer;
            }
            .btn-base {
                display: flex;
                width: 260px;
                height: 50px;
                border-radius: 50px;
                margin: 0 auto;
                margin-top: -25px;
                font-size: 30px;
                justify-content: center;
                align-items: center;
                color: white;
            }
            .btn-lara {
                background-color: #f44336;
            }
            .btn-php {
                background-color: #535353;
            }
            .btn-git {
                background-color: #641b16;
            }
            .btn-vue {
                background-color: #009771;
            }
            .btn-wp {
                background-color: #7595ff;
            }
            .btn-db {
                background-color: #fb9b10;
            }
            .card-lara {
                background-color: #f3a49e;
            }
            .card-php {
                background-color: #cecece;
            }
            .card-git {
                background-color: #d88c86;
            }
            .card-vue {
                background-color: #36f4c5;
            }
            .card-wp {
                background-color: #57c1ff;
            }
            .card-db {
                background-color: #fecc85;
            }
            .content {
                padding: 15px 35px;
                font-size: 16px;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            }
            a, a:visited {
                text-decoration: none;
                color: darkslategray;
            }
            .card-config {
                height: 500px;
                background-color: #ffffff;
            }
            .img-config {
                width: 350px;
                height: 300px;
                border-radius: 42px;
            }
            .img-lara {
                background: url('https://user-images.githubusercontent.com/33905714/128091045-e5cd2ef6-93d5-4a05-b854-b82d76c75a17.png') no-repeat;
                background-size: 130%;
                background-position-x: 50%;
            }
            .img-php {
                background: url('https://user-images.githubusercontent.com/33905714/128091058-4ee0c1d5-3bfd-4a28-943b-d91e854952d5.png') no-repeat;
                background-size: 130%;
                background-position-x: 50%;
            }
            .img-wp {
                background: url('https://user-images.githubusercontent.com/33905714/128091115-f71f937b-c220-4d33-8f50-a34112837584.png') no-repeat;
                background-size: 130%;
                background-position-x: 50%;
            }
            .img-git {
                background: url('https://user-images.githubusercontent.com/33905714/128091027-af4c6e89-3cd6-49e2-b04f-310b4c839940.png') no-repeat;
                background-size: 130%;
                background-position-x: 50%;
            }
            .img-vue {
                background: url('https://user-images.githubusercontent.com/33905714/128091095-477347e9-27b9-4151-9621-64099f86f0ff.png') no-repeat;
                background-size: 130%;
                background-position-x: 50%;
            }
            .img-db {
                background: url('https://user-images.githubusercontent.com/33905714/128100240-cc431629-fe3f-457a-a56d-198698c1eda5.png') no-repeat;
                background-size: 130%;
                background-position-x: 50%;
            }
            @media (max-width: 1314px) {
                .card-container {
                    flex-direction: row;
                    justify-content: center;
                    margin: 0 auto;
                    gap: 40px
                }
                .card-width {
                    margin: 0 auto;
                    margin-top: 25px;
                }
                .card-width:hover {
                    box-shadow: 2px 12px 32px rgba(0, 0, 0, 0.5);
                    cursor: pointer;
                }
            }
            
            .notification {
                position: relative;
                display: inline-block;
            }

            .notification .badge {
                position: absolute;
                top: -15px;
                right: -20px;
                padding: 10px 15px;
                border-radius: 25%;
                background-color: red;
                color: white;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="info"><br />
                    <?php print($_SERVER['SERVER_SOFTWARE']) ?><br />
                    PHP version: <?php print phpversion() ?>   <span><a title="phpinfo()" href="/?q=info">info</a></span><br />
                    Document Root: <?php print ($_SERVER['DOCUMENT_ROOT']); ?><br />
                    Laragon Docs: <a title="Getting Started" href="https://laragon.org/docs" target="_blank">Getting Started</a><br />
                    Owner: <a title="Hélder Lima de Jesus" href="https://helder.dev" target="_blank">Hélder</a><br />
                    <h1>Lista de Projetos:</h1>
                </div>
                <div class="card-container">
                    <a title="phpMyAdmin" href="/phpmyadmin" target="_blank">
                        <div class="card-db card-width">
                            <div class="img-db img-config"></div>
                            <div class="btn-base btn-db">
                                <p>phpMyAdmin</p>
                            </div>
                            <div class="content">
                                <p><b>Gerenciador de banco de dados.</b></p>

                            </div>
                        </div>
                    </a>
                    <?php foreach ($scanned_directories as $scanned_directory): ?>
                    <?php if (startsWith($skip_start_with, $scanned_directory) || skipFile($skip_file_name, $scanned_directory)): ?>
                    <?php continue ?>
                    <?php endif; ?>
                    <?php if (is_dir($scanned_directory)): ?>
                    <?php if (in_array($show_project, array('directory', 'both'))): ?>
                    <a href="<?=strtolower($scanned_directory)?>">
                        <?php $type = checkDirType($scanned_directory);?>
                        <?php $stat = stat($scanned_directory); ?>
                        <div class="card-<?= $type?> card-width notification">
                            <?php if(gmdate("d/m/Y", $stat['mtime']) <= date("d/m/Y")){?>
                            <span class="badge">hot</span>
                            <?php }?>
                            <div class="img-<?= $type?> img-config"></div>
                            <div class="btn-base btn-<?= $type?>">
                                <p><?=$scanned_directory?></p>
                            </div>
                            <div class="content">
                                <p><b>Ultima modificação</b>: <?=gmdate("d/m/Y", $stat['mtime'])?></p>
                                <p><b>Data Criação</b>: <?=gmdate("d/m/Y", $stat['ctime'])?></p>
                            </div>
                        </div>
                    </a>
                    <?php endif; ?>
                    <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </body>
</html>
