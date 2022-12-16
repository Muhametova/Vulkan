<?php require "connectDB.php";

    $sql1 = "Select * from `Kontakt` ";

    $konts = mysqli_query($connect, $sql1);

    $konts = mysqli_fetch_all($konts);
?>

<?php 
    require "connectDB.php";

    $sql = "Select * from `Dishes` ";

    $dishes = mysqli_query($connect, $sql);

    $dishes = mysqli_fetch_all($dishes);

    error_reporting(-1);
    session_start();

    require_once __DIR__ . '/inc/db.php';
    require_once __DIR__ . '/inc/funcs.php';

    $products = get_products();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная страница</title>
    <link rel="icon" type="image/png" sizes="32x32" href="assets/favicon.png">

    <link rel="stylesheet" href="css1\style1.css">
    <link rel="stylesheet" href="css1\style_mod.css">
    <link rel="stylesheet" href="css1\kontaktsStyle.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">

</head>
<body  style="background-color: rgb(24, 24, 24);">
    <div class="zakrep">
        <header style="display:flex;">
            <div class="icon">
                <img src="resource/icon.png" alt="">
                <h1 style="font-size: 18px;">ВУЛКАН</h1>
            </div>

            <div class="naviga">
                <a style="text-align:center; font-size:20px;" href="index.php">Главная</a>
                <a style="text-align:center; font-size:20px;"  href="oNas.php">О нас</a>
                <a style="text-align:center; font-size:20px;"  href="kontakts.php">Контакты</a>
             </div>

            <div  class="searchBox">
                <form action="" style="margin-top: 33px;" method="GET">
                
                    <input type="text" class="searh" name="search" style="color:white;background-color: #0000006e; 
                        height:33px; width:232px; border-radius:5px; border:1px solid; border-color:aliceblue; padding-left: 9px;" 
                        value ="<?php if(isset ($_GET['search'])){echo $_GET['search']; } ?>" placeholder="Поиск">

                    <button type="submit" class="testRolls" style="margin-top:10px;">Поиск</button>
                </form>  
            </div>
         
            <li class="nav-item">
                <button id="get-cart" type="button" class="btn1 btn-primary" data-toggle="modal" data-target="#cart-modal">
                    Корзина <span class="badge badge-light mini-cart-qty"><?=$_SESSION['cart.qty'] ?? 0 ?></span>
                </button>
            </li>
        </header>
        <form action="" method="GET"></form>
            <div style="display:flex; margin-left:5%;">
                <?
                    $types = get_type();
                    foreach($types as $item):
                ?>
                    <div class="navbar" style="overflow:hidden;">
                        <a href="index.php?view=type&id=<?=$item['IdType'];?>"><?=$item[1];?></a>
                    </div>
                <?endforeach?>
            </div>
        </form>
    </div>
    <section class="dishes">
    <?php
        $con1=mysqli_connect("localhost","root","","Vulkan");
        if(isset($_GET['search']))
        {
            $filterValues=$_GET['search'];
            $query1= "select * from Dishes where concat(NameDish) LIKE '%$filterValues%'";
            $query_run=mysqli_query($con1,$query1);

            if(mysqli_num_rows($query_run)<0)
            {?>
                <script>alert("Нет данных для вывода", <?php $query_run?>);</script><?
            }
            if(mysqli_num_rows($query_run)>0)
            {
                foreach($query_run as $item): ?>
                    <div class="dish"> 
                        <div class="dish_img">
                            <img src="img/<?=$item['Image']?>" alt="<?=$item['Image']?>" />
                        </div>

                        <div class="zagolovok">
                            <h2 style="font-size: 1rem;"><?=$item['NameDish']?></h2>
                        </div>    

                        <div class="spa">   
                            <span><?=$item['Description']?></span>
                        </div>
        
                        <div class="price" style="height:11%; font-size:24px; background-color: #000000bd">
                            <h5 style="color: rgb(255, 255, 255); font-size: 18px; text-align:center; margin-bottom:10px" ><br>Цена: <?=$item['Price']?> р.</h5>
                            <a href="?cart=add&id=<?=$item['IdDish'] ?>" class="btn1 btn-info btn-block add-to-cart" data-id="<?= $item['IdDish'] ?>">
                                <i class="fas fa-cart-arrow-down"></i> Купить
                            </a>
                        </div>
                    </div> 
                <? endforeach; ?><?
            }
        }
       
        if(!isset($_GET['search'])){
            $query1= "select * from Dishes";
            $query_run=mysqli_query($con1,$query1);
            if(mysqli_num_rows($query_run)>0){
                foreach($query_run as $item): ?>
            
                    <div class="dish"> 
                        <div class="dish_img">
                            <img src="img/<?=$item['Image']?>" alt="<?=$item['Image']?>" />
                        </div>

                        <div class="zagolovok">
                            <h2 style="font-size: 1rem;"><?=$item['NameDish']?></h2>
                        </div>    

                        <div class="spa">   
                            <span><?=$item['Description']?></span>
                        </div>
        
                        <div class="price" style="height:11%; font-size:24px; background-color: #000000bd">
                            <h5 style="color: rgb(255, 255, 255); font-size: 18px; text-align:center; margin-bottom:10px" ><br>Цена: <?=$item['Price']?> р.</h5>
                            <a href="?cart=add&id=<?=$item['IdDish'] ?>" class="btn1 btn-info btn-block add-to-cart" data-id="<?= $item['IdDish'] ?>">
                                <i class="fas fa-cart-arrow-down"></i> Купить
                            </a>
                        </div>
                    </div> 
                <? endforeach; ?><?
                }
            }
        ?>
        </section>     
    </div>


    <!-- Modal Korzina -->
    <div class="modal fade cart-modal" id="cart-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Корзина</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-cart-content">


                </div>
            </div>
        </div>
    </div>


<!--???? -->
    <div>
        <div id="open" class="modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <!-- <h3 class="modal-title">Вход</h3> -->
                        <ul class="modal-title">
                            <li class="livx"><a class="avx" style="color: black;" href="#open"> Войти</a></li>
                            <li class="lizareg"><a class="azareg" href="#openModal1">Зарегистрироваться</a></li>
                        </ul>
                        <a href="#close" title="Close" class="close">×</a>
                    </div>
                        <div class="modal-body">    
                            <div class="recipe">
                                <form action="auth-db.php" method="post" class="cd-form">
                                    <input type="text" name="login" class="full-width has-padding has-border" id="login" placeholder="Логин"><br>
                                    <input type="text" name="pass" class="form-control" id="pass" placeholder="Пароль"><br>
                                    <button class="Autoriz" >Авторизоваться</button><br>

                                    
                                </form> 
                            </div>
                        </div>
                </div>
            </div>
        </div>
        <div id="openModal1" class="modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    
                        <!-- <h3 class="modal-title">Зарегистрироваться</h3>
                        <h3 class="modal-title"><a href="#open" >Войти</a></h3> -->
                        <ul class="modal-title1">
                              <li class="livx1"><a class="avx" style="color:black;" href="#open"> Войти</a></li>
                            <li class="lizareg1"><a class="azareg"  href="#openModal1">Зарегистрироваться</a></li>
                        </ul>
                        <a href="#close" title="Close" class="close">×</a>
                    </div>
                    <div class="modal-body">    
                        <div >
                            <form action="" method="post" class="cd-form">
                                <input type="text" name="surname" class="form-control" id="surnId" placeholder="Фамилия"><br>
                                <input type="text" name="name" class="form-control" id="nameId" placeholder="Имя"><br>
                                <input type="text" name="patronymyc" class="form-control" id="patronId" placeholder="Отчество"><br>
                                <input type="text" name="phoneNumber" class="form-control" id="phoneId" placeholder="Номер телефона"><br>
                                <input type="text" name="email" class="form-control" id="emailId" placeholder="E-mail"><br>
                                <input type="text" name="login" class="form-control" id="loginId" placeholder="Логин"><br>
                                <input type="text" name="password" class="form-control" id="passId" placeholder="Пароль"><br>
                                <button class="Autoriz" >Зарегистрироваться</button><br>
                            </form> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer>
    <section class="kontakts"  style="font-size:15px; margin-left:-180px; justify-content: space-around;" >
        <div class="flexy">
            <span style="font-size:23px; font-weight: bold;">Контактные номера</span>
            <?foreach($konts as $item): ?>
                <div class="displ">
                    <span class="text1"><?=$item[1]?></span>
                </div>
            <? endforeach; ?>
        </div>
        
        <div class="flexy" style="font-size:15px;">
            <span style="font-size:18px; font-weight: bold;">Адреса</span>
            <?foreach($konts as $item): ?>
                <div class="displ">
                    <span class="text1"><?=$item[2]?></span>
                </div>
            <? endforeach; ?>
        </div> <div class="graphic" >
        

        <div style="font-size:15px;">
        <div class="kontsText" style="font-size:20px; margin-top:-20px;">
            <br>График работы
        </div>
            <div class="weeks">
                <span class="text1">Понедельник</span>
                <span class="text1">09:00 - 23:00</span>
                <div class="spac"></div>
            </div>

            <div class="weeks">
                <span class="text1">Вторник</span>
                <span class="text1">09:00 - 23:00</span>
                <div class="spac"></div>
            </div>

            <div class="weeks">
                <span class="text1">Среда</span>
                <span class="text1">09:00 - 23:00</span>
                <div class="spac"></div>
            </div>

            <div class="weeks">
                <span class="text1">Четверг</span>
                <span class="text1">09:00 - 23:00</span>
                <div class="spac"></div>
            </div>

            
            
        </div>   
    </div> 
    <div style="margin-top:52px; margin-left: -189px;">
        <div class="weeks">
            <span class="text1">Пятница</span>
            <span class="text1">09:00 - 06:00</span>
            <div class="spac"></div>
        </div>

        <div class="weeks">
            <span class="text1">Суббота</span>
            <span class="text1">09:00 - 06:00</span>
            <div class="spac"></div>
        </div>

        <div class="weeks">
            <span class="text1">Воскресенье</span>
            <span class="text1">09:00 - 06:00</span>
            <div class="spac"></div>
        </div>
    </div>
    </section>
          
    
    </footer>



<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script> -->
<script src="assets/js1/main.js"></script>
</body>
</html>
