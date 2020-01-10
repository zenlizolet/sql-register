<?php
if (isset($_POST['registreer-submit'])){

  require 'dbh!.php';

  $voornaam = $POST['voornaam'];
  $achternaam = $POST['achternaam'];
  $email = $POST['email'];
  $ww = $POST['ww'];
  $wwh = $POST['ww-herhaal'];
}
  if(empty($voornaam)  || (empty($achternaam) || (empty($email) || (empty($ww) || (empty($wwh)){
    header("Location: registreer.php?error=emptyfields");
    exit();
  }
  else if( $ww !== $wwh){
    header("Location: registreer.php?error=wachtwoordcontrole");
    exit();
  }
  else {
    $sql = "SELECT *  FROM users WHERE id=?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: registreer.php?error=sqlerror");
    exit();
    }
  else {
      mysqli_stmt_bind_param($stmt,"s", $gebruikersnaam);
      mysqli_stmt_execute($stmt);
      mysql_stmt_store_result($stmt);
      $resultcheck = mysql_stmt_num_rows($stmt); 
      if($resultcheck > 0){
        header("Location: registreer.php?error=usertaken&mail=".$mail);
        exit();
      }
      else{
          $sql = "INSERT INTO users(voornaam, achternaam, email, wachtwoord) VALUES(?, ?, ?, ?)";
          $stmt = mysqli_stmt_init($conn);
          if (!mysqli_stmt_prepare($stmt, $sql)) {
             header("Location: registreer.php?error=sqlerror");
             exit();
          }
          else{
          $hashedww = password_hash($ww, PASSWORD_DEFAULT);
           mysqli_stmt_bind_param($stmt,"sssss", $voornaam, $achternaam, $hashedww);
           mysqli_stmt_execute($stmt);
           header("Location: registreer.php?registratie=succes");
          exit();
        }
      }
    }
  }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
                                                                     
   else{
           header("Location: registreer.php");
           exit();
         }      
         
