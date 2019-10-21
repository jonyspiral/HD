<?php
require_once 'funciones/autoload.php';
if(!estaElUsuarioLogeado()){
    header('location:login.php');
}

    $name= $_SESSION['name'];
    $lastName= $_SESSION['lastName'];
    $user= $_SESSION['user'];
    $email = $_SESSION['email'];
    $nombreArchivo = '';
    $errores=[];
    $resultado='';
      
    $avatar =  $_SESSION['avatar'];
    $newPass= '';
  //var_dump($_SESSION);exit;

if ($_POST){
  if (isset($_POST['user'])){
    $user= $_POST['user'];
  }else{
  $user=$_SESSION['user'];
  }
  if (isset($_POST['name'])){
    $name= $_POST['name'];
  }else{
  $name= $_SESSION['name'];
  }
  if (isset($_POST['lastName'])){
    $lastName= $_POST['lastName'];
  }else{
  $lastName=$_SESSION['lastName'];
  }

  $password='';

  if (isset($_POST['newPass'])){
    $newPass= $_POST['newPass'];
  }else{
  $newPass='';
  }
if (isset($_FILES['avatar'])){

        if ($_FILES['avatar']['error'] === 0) {
            $ext = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);

              if ($ext != 'png' && $ext != 'jpg' && $ext != 'jpeg') {

                  $errores['avatar']= 'Formato de archivo invalido';
                  } else {
                  $avatar = subirAvatar($_FILES['avatar'], $email);
                  $_SESSION['avatar']=$avatar;
                }
              }
              }else{
              $avatar= $_SESSION['avatar'];//creo que esta al pedo.
              }
              //validaciones
              if (strlen($user) === 0) {
             $errores['user'] = 'Escribe un usuario';
              }
              if (strlen($name) === 0) {
             $errores['name'] = 'Escribe un nombre';
              }
              if (strlen($lastName) === 0) {
             $errores['lastname'] = 'Escribe un Apellido';
              }

              if (isset($_POST['newPass'])){
                $usuario= buscarUsuarioEmail( $email);
                $password = $usuario['password'];

              if (password_verify($_POST['password'],$password)){

                $errores=validarPassword($_POST);//validar datos de newPass.
             //      if ($_POST['newPass']==$_POST['confirmPass']) {
             //   $errores['password'] = '';
             //   $newPass= $_POST['newPass'];
             // }else{
             //    $errores['password'] = 'Nuevos Passwords difieren';
             //  } //if end//

                }else {
                $errores['password'] = 'Password equivocado.';
              }
            }else{
              $newPass='';
            }

            if (!$errores) {
              $usuarioPost=  buscarUsuarioEmail( $email);//aca trae el usuario

                $usuarioPost ['user']= $user;
                $usuarioPost ['name']= $name;
                $usuarioPost ['lastName']= $lastName;
                $usuarioPost ['avatar']=$avatar;
                $usuarioPost['password']=password_hash($newPass, PASSWORD_DEFAULT);
//var_dump($_POST);exit;
                guardarUsuarioPorEmail($email,$usuarioPost);// aca lo guarda
                //y defino las nuevas $_SESSION
                 $_SESSION['name']=   $name;
                 $_SESSION['lastName']= $lastName;
                 $_SESSION['user']=  $user;
                 $_SESSION['avatar'] = $avatar ;

                $resultado ="los cambios estan ok";
                }//aca termina si hay errores
          }// termina el if de $_POST

// WARNING: probar!!!!


 ?>
 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
       <meta charset="utf-8">
       <meta name="viewport" content="width=device-width, initial-scale=1,shrink-to-fit=no">

     <title>Mi perfil</title>

     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
     <script src=”prefixfree.min.js” type="text/javascript"></script>
     <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


 <link rel="stylesheet" href="css/styles.css">
  <link rel="stylesheet" href="css/master.css">
  <link rel="stylesheet" href="css/login.css">
 </head>

  <body style=" display: block;  align-content: center;">
<?php require_once('partials/header.php') ?>
<div id="padre"  class="contPadreFlex" style="width: 96%; margin: 2%; overflow:hidden;" >
    <div id="main" class=" styleLogin padd2" style="  margin: 2%;" >


      <div class="containerExt" style="
    justify-content: center;
    display: flex;
    flex-direction: column;
    align-items: center;
">
  <h1 class="styleTitle center" >Bienvenido!</br> <?=($name.' '.$lastName) ?></h1>

          <div id="containerLogo">

            <img class=""src="img\avatar\<?=$avatar?>" alt="Yo"style=" ">
          </div>
<div class="">


      <form class="" action="miPerfil.php" method="post" enctype="multipart/form-data" >
          <input type="file" accept="img\avatar\<?=$avatar?>" name="avatar"  class=" borderRadiusUp file-input" id="avatar"style="width:100%;">
          <p> <?php /*(isset($errores) ? $errores : '') */?></p>


        <input type="text" class="form-control" id="user" placeholder="Enter user"   name="user" value="<?= $user ?>"  >
        <p> <?= (isset($errores['user']) ? $errores['user'] : '') ?></p>

        <label  class="center" name="email"  ><strong> <?= $email ?></strong> </label>
        <p> <?= (isset($errores['email']) ? $errores['email'] : '' ) ?></p>

        <input type="text" class="form-control" id="name" placeholder="Enter name"   name="name" value="<?= $name ?>" required >
        <p></p>

        <input type="text" class="form-control" id="lastName" placeholder="Enter lastName"   name="lastName" value="<?= $lastName ?>" required>
        <p></p>

    <div class="" style="margin-bottom:2%">

      <button class="center btn-primary btn"  type="submit" style="width:300px;">Enviar cambios</button>
    </div>

  </form>
</div>
<div class="">
  <form method='post' >

                <!-- <td>Old Password:</td> -->
                    <td><input class="form-control" name='password' type='password'  placeholder="Enter password"/></td>
                    <p> <?= (isset($errores['password']) ? $errores['password'] : '') ?></p>
                <tr>

                    <!-- <td>New Password:</td> -->
                    <td><input class="form-control" name='newPass' type='password'   placeholder="Enter new password"/></td>
                      <p> <?= (isset($errores['newPass']) ? $errores['newPass'] : '') ?></p>


                    <td><input class="form-control" name='confirmPassword' type='password'  placeholder="Confirm new password"/></td>
                    <p> <?= (isset($errores['confirmPassword']) ? $errores['confirmPassword'] : '') ?></p>
                    <td> <input class="center btn-primary btn" type='submit' value='Change Password'style="width:300px;" /></td>
                    <p> <?= (isset($resultado) ? $resultado : '') ?></p>
                </tr>
                 </form>
</div>

  <div class="">
        <ul class="center" style="padding-inline-start: 0px;">
          <li class=" btn-primary btn">
            Mis Compras
          </li>
          <li class=" btn-primary btn" >
            Favoritos
          </li>
            <li class=" btn-primary btn" >
            Envios
          </li>
        </ul>

      </div>

      </div>
</div>
</div>
        <?php require_once('partials/footer.php')?>

  </body>
</html>
