<?php
date_default_timezone_set("America/Sao_Paulo");
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
            return "lara";
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
                background: rgb(238,174,202);
                background: radial-gradient(circle, rgba(238,174,202,1) 0%, rgba(148,187,233,1) 100%);
                margin: 0;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                /* width: 100%;
                height: 100vh; */
            }
           
     
        
          
           
      
           
        </style>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body>
        <div class="flex flex-col w-full h-full">
            <div class="p-4">
                <?php print($_SERVER['SERVER_SOFTWARE']) ?><br />
                PHP version: <?php print phpversion() ?>   <span ><a title="phpinfo()" href="/?q=info">info</a></span><br />
                Document Root: <?php print ($_SERVER['DOCUMENT_ROOT']); ?><br />
                Laragon Docs: <a title="Getting Started" href="https://laragon.org/docs" target="_blank">Getting Started</a><br />
                Owner: <a title="Hélder Lima de Jesus" href="https://helder.dev" target="_blank">Hélder</a><br />
                <h1>Lista de Projetos:</h1>
            </div>    
            <div class="p-4 flex flex-wrap justify-center gap-8">
                <a title="phpMyAdmin" style="background-color: #fecc85" class="h-48 w-32 rounded-lg shadow-sm hover:shadow-lg flex flex-col items-center justify-center text-center transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-110 duration-200" href="/phpmyadmin" target="_blank">
                    <div class="h-full w-full flex flex-col justify-between items-center relative">
                        <div class="h-1/2 w-full rounded-b-2xl rounded-t-lg shadow-sm bg-red-400 flex items-center justify-center bg-gradient-to-t from-pink-500 to-yellow-500">
                            <img src="https://user-images.githubusercontent.com/33905714/164336135-1d6c299c-303e-48ea-a36e-bc546d3be1bd.png" class="h-14 w-14" alt="phpmyadmin">
                        </div>
                        <span style="background-color: #fb9b10;" class="p-2 absolute rounded-full top-20 text-center">phpMyAdmin</span>
                        <div class="h-1/2 w-full flex items-center justify-center font-light">
                            Gerenciador de banco de dados
                        </div>
                    </div>
                </a>
                <?php foreach ($scanned_directories as $scanned_directory): ?>
                <?php if (startsWith($skip_start_with, $scanned_directory) || skipFile($skip_file_name, $scanned_directory)): ?>
                <?php continue ?>
                <?php endif; ?>
                <?php if (is_dir($scanned_directory)): ?>
                <?php if (in_array($show_project, array('directory', 'both'))): ?>
                <?php $type = checkDirType($scanned_directory);?>
                <?php 
                switch($type) {
                    case 'lara': 
                        $img = "https://user-images.githubusercontent.com/33905714/164338165-e558e99b-64ed-4f64-96ec-725c24de4d7b.png";
                        $cor1 = "#f3a49e";
                        $cor2 = "#f44336";
                        $bg = "";
                        $grad1 = "from-violet-400";
                        $grad2 = "to-orange-500";
                    break;
                    case 'vue':
                        $img = "https://user-images.githubusercontent.com/33905714/164338162-362c4e68-5121-439b-b312-5329061dbbec.png";
                        $cor1 = "#36f4c5";
                        $cor2 = "#009771";
                        $bg = "";
                        $grad1 = "from-violet-400";
                        $grad2 = "to-orange-500";
                    break;
                    case 'php':
                        $img = "https://user-images.githubusercontent.com/33905714/164338160-4053256f-bbc1-4324-b2c7-654aa3d2a1bd.png";
                        $cor1 = "#cecece";
                        $cor2 = "#868686";
                        $bg = "";
                        $grad1 = "from-rose-400";
                        $grad2 = "to-slate-500";
                    break;
                    case 'wp':
                        $img = "https://user-images.githubusercontent.com/33905714/164338163-17f3da24-e6bc-40b5-8315-a4fb35927391.png";
                        $cor1 = "#57c1ff";
                        $cor2 = "#7595ff";
                        $bg = "";
                        $grad1 = "from-violet-400";
                        $grad2 = "to-orange-500";
                    break;
                    case 'git':
                        $img = "https://user-images.githubusercontent.com/33905714/164341029-393f0ccd-b9a5-42bf-a962-e6defc898322.png";
                        $cor1 = "#641b16";
                        $cor2 = "#d88c86";
                        $bg = "";
                        $grad1 = "from-violet-400";
                        $grad2 = "to-orange-500";
                    break;
                }
                ?>

                <a href="https://<?=$scanned_directory?>.test/" style="background-color: <?= $cor1;?>" class="h-48 w-32 rounded-lg shadow-sm hover:shadow-lg flex flex-col items-center justify-center text-center transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-110 duration-200 relative">
                    <?php $stat = stat($scanned_directory); ?>
                    <div class="h-full w-full flex flex-col justify-between items-center relative">
                        <div class="h-1/2 w-full rounded-b-2xl rounded-t-lg shadow-sm flex items-center justify-center bg-gradient-to-t <?= $grad1;?> <?= $grad2;?>  ">
                            <img src="<?=$img;?>" class="h-14 w-14" alt="phpmyadmin">
                        </div>
                        <span style="background-color: <?= $cor2;?>;" class="p-2 absolute rounded-full top-20 text-center w-5/6"><?= (strlen($scanned_directory) > 12) ? substr($scanned_directory, 0, 8) . "..." : $scanned_directory ?></span>
                        <?php  $diff = date_diff(date_create(date("Y-m-d")), date_create(date("Y-m-d", $stat['mtime']))) ?>
                        <?php if ($diff->days < 3){?>
                            <span class="rounded-full w-10 h-10 p-4 absolute left-28 bg-amber-400 z-40 flex justify-center items-center">hot</span>
                        <?php }?>
                        <div class="h-1/2 w-full flex flex-col items-center justify-center font-light text-xs">
                            <!-- <p>Data Criação: <?=gmdate("d/m/Y", $stat['ctime'])?></p> -->
                            Ultima modificação: <span class="font-medium"><?=gmdate("d/m/Y", $stat['mtime'])?></span>
                        </div>
                    </div>
                </a>
                <?php endif; ?>
                <?php endif; ?>
                <?php endforeach; ?> 
            </div>    
            
        </div>
    </body>
</html>