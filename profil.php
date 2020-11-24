<?php
session_start();
require_once 'function.php';
if(!$user = is_not_loggin_in($_SESSION['email'])){
    set_flash_message('danger', 'Введите email и пароль.');
    redirect_to('page_login.php');
}
if($user['role'] === 'admin'){
    $date_user = get_user_by_id($_GET['id']);
    if(!$date_user[0]){
        set_flash_message('danger', 'Нет такого пользователя');
        redirect_to('users.php');
    }
}else{
    $result = is_author($user['id'], $_GET['id']);
    if(!$result){
        set_flash_message('danger', 'Вы не можете смотреть чужой профиль');
        redirect_to('users.php');
    }else{
        $date_user = get_user_by_id($_GET['id']);

    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Профиль пользователя</title>
    <meta name="description" content="Chartist.html">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
    <link id="vendorsbundle" rel="stylesheet" media="screen, print" href="css/vendors.bundle.css">
    <link id="appbundle" rel="stylesheet" media="screen, print" href="css/app.bundle.css">
    <link id="myskin" rel="stylesheet" media="screen, print" href="css/skins/skin-master.css">
    <link rel="stylesheet" media="screen, print" href="css/fa-solid.css">
    <link rel="stylesheet" media="screen, print" href="css/fa-brands.css">
    <link rel="stylesheet" media="screen, print" href="css/fa-regular.css">
</head>
    <body class="mod-bg-1 mod-nav-link">
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary bg-primary-gradient">
            <a class="navbar-brand d-flex align-items-center fw-500" href="users.php"><img alt="logo" class="d-inline-block align-top mr-2" src="img/logo.png"> Учебный проект</a> <button aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler" data-target="#navbarColor02" data-toggle="collapse" type="button"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarColor02">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Главная <span class="sr-only">(current)</span></a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="page_login.php">Войти</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="page_login.php">Выйти</a>
                    </li>
                </ul>
            </div>
        </nav>
        <main id="js-page-content" role="main" class="page-content mt-3">
        <?php if(isset($_SESSION['success'])){
                display_flash_message('success'); unset($_SESSION['success']);
            }elseif(isset($_SESSION['danger'])){
                display_flash_message('danger'); unset($_SESSION['danger']);
        }?>
            <div class="subheader">
                <h1 class="subheader-title">
                    <i class='subheader-icon fal fa-users'></i> Профиль пользователя
                </h1>
            </div>
        </main>
		<div class="col" id="js-contacts">
<?php foreach($date_user as $users){?>
<div class="container">
    <div class="row flex-row">
        <div class="col-3 col-sm-3">
            <div class="col-12 d-flex justify-content-center"> 
                <span class="rounded-circle profile-image d-block " style="background-image:url('<?php echo $users['imgProfil'];?>'); background-size: cover;">
                </span>
            </div>
            <div class="row flex-row">
                <div class="col-12 col-sm-6 col-md-4 p-2">
                    <a href="javascript:void(0);" class="mr-2 fs-xxl" style="color:#4680C2">
                        <i class="fab fa-vk"></i>
                    </a>
                </div>
                <div class="col-12 col-sm-6 col-md-4 p-2">
                    <a href="javascript:void(0);" class="mr-2 fs-xxl" style="color:#38A1F3">
                        <i class="fab fa-telegram"></i>
                    </a>
                </div>
                <div class="col-12 col-sm-6 col-md-4 p-2">
                    <a href="javascript:void(0);" class="mr-2 fs-xxl" style="color:#E1306C">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-9 col-sm-9">
            <div class="row">
                <div class="col-12">
                    <i class="fas fa-heart text-muted mr-2"></i><?php echo $users['fullName'];?>
                </div>
                <div class="col-12">
                    <i class="fas fa-briefcase text-muted mr-2"></i><?php echo $users['position'];?>
                </div>
                <div class="col-12">
                    <i class="fas fa-mobile-alt text-muted mr-2"></i><?php echo $users['phone'];?>
                </div>
                <div class="col-12">
                    <i class="fas fa-mouse-pointer text-muted mr-2"></i><?php echo $users['email'];?>
                </div>
                <div class="col-12">
                    <address class="fs-sm fw-400 mt-4 text-muted">
                        <i class="fas fa-map-pin mr-2"></i><?php echo $users['address']; ?>
                    </address>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>
		</div>
        </main>
        <!-- BEGIN Page Footer -->
        <footer class="page-footer" role="contentinfo">
            <div class="d-flex align-items-center flex-1 text-muted">
                <span class="hidden-md-down fw-700">2020 © Учебный проект</span>
            </div>
            <div>
                <ul class="list-table m-0">
                    <li><a href="intel_introduction.html" class="text-secondary fw-700">Home</a></li>
                    <li class="pl-3"><a href="info_app_licensing.html" class="text-secondary fw-700">About</a></li>
                </ul>
            </div>
        </footer>
        
    </body>

    <script src="js/vendors.bundle.js"></script>
    <script src="js/app.bundle.js"></script>
    <script>

        $(document).ready(function()
        {

            $('input[type=radio][name=contactview]').change(function()
                {
                    if (this.value == 'grid')
                    {
                        $('#js-contacts .card').removeClassPrefix('mb-').addClass('mb-g');
                        $('#js-contacts .col-xl-12').removeClassPrefix('col-xl-').addClass('col-xl-4');
                        $('#js-contacts .js-expand-btn').addClass('d-none');
                        $('#js-contacts .card-body + .card-body').addClass('show');

                    }
                    else if (this.value == 'table')
                    {
                        $('#js-contacts .card').removeClassPrefix('mb-').addClass('mb-1');
                        $('#js-contacts .col-xl-4').removeClassPrefix('col-xl-').addClass('col-xl-12');
                        $('#js-contacts .js-expand-btn').removeClass('d-none');
                        $('#js-contacts .card-body + .card-body').removeClass('show');
                    }

                });

                //initialize filter
                initApp.listFilter($('#js-contacts'), $('#js-filter-contacts'));
        });

    </script>
</html>