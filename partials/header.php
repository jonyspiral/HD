<?php
require_once 'funciones/autoload.php';


if(estaElUsuarioLogeado()){
  $log= 'logout.php';
  $logTittle='Log out';
  }else{
  $log= 'login.php';
  $logTittle='Log in';
}


 ?>
 <!DOCTYPE html>
 <html lang="en" dir="ltr">


<header>
  <div  class="containerExt  ">

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">

    <a  href="index.php">
        <img src="img\logo.png" alt="" class="navbar-brand" style="width:50px; border-radius:15% padding: 2%;"   >
    </a>
    <a  href="cart.php">
          <img src="img\icons8-shopaholic-50.png" alt="" class="navbar-brand" style="width:50px; border-radius:15%"  >
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
  <ul id="headerMenuLi" class="navbar-nav mr-auto mt-2 mt-lg-0" style="">
    <li class="nav-item active">
      <a class="nav-link" href="teleAudio.php">Televisores y audio</a>
    </li>
  <li class="nav-item active">
      <a class="nav-link" href="celulares.php">Celulares</a>
    </li>
    <li class="nav-item active">
      <a class="nav-link" href="notebooks.php" >Notebooks</a>
    </li>
  </ul>
  <a class="navbar-brand" style="width: 100px; "  target="_blank" href="<?=$log?>"><?=$logTittle ?></a>

  <form class="center  form-inline my-2 my-lg-0" style="">
    <input class="form-control mr-sm-2" type="search" placeholder="Search">
    <button class="  btn-primary btn" type="submit"style=" width:100px">Search</button>
    <!-- <button class=" btn btn-outline-success my-2 my-sm-0" type="submit"style=" width:100px">Search</button> -->
  </form>
</div>
</nav>
</div>

</header>
  </html>
