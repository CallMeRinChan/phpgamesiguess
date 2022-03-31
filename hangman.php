<?php
// another school project of mine, i still cant do this stuff, but i made this myself, so thats nice i guess
// i still use dutch variables, so bear with me once again

session_start(); // i start a session to save stuff

echo "<center>";

// makes it so you can reset the game
if(isset($_GET['reset'])){
  session_destroy();
  header("location:hangman.php");
}

// if the game received an answer, it makes the session know it
if(isset($_REQUEST['antwoord'])){
  if(!isset($antwoord)){
    $antwoord = $_REQUEST['antwoord'];
    $_SESSION['antwoord'] = $antwoord;}
  for ($i= 0; $i < strlen($antwoord); $i++) {
  ($_SESSION['raadtekst'][$i] = "_");
  }
  header('location:hangman.php?letter=+'); // makes spaces appear
}

// if the answer is set, the variable grabs it out of the session and uses it for some other fancy stuff
if(isset($_SESSION['antwoord'])){
  $antwoord = $_SESSION['antwoord'];
  $raadwoord = str_split($antwoord, 1);
}

//sets the array for the word you guess
if (isset($_SESSION['raadtekst'])){
$raadtekst = $_SESSION['raadtekst'];
}elseif(!isset($_SESSION['raadtekst'])){
   $raadtekst = array("","","","","","","","","");
   $_SESSION['raadtekst'] = array("","","","","","","","","");
}

// variable declaration... i usually like to do it at the top, and idk why i didnt
$userinput = $_GET['letter'] ?? "";
$fouten = $_SESSION['fouten'] ?? array();
$lost = false;
$won = false;
$gameend = false;

// makes it so you can choose the word
if(!isset($_SESSION['chooseword'])){
  $_SESSION['chooseword'] = true;
  echo "Type een woord in om te raden!";
}

// some lives system
if(!isset($_SESSION['levens'])){
  $_SESSION['levens'] = 10;
}

// if lives are less than zero, you lose... L bozo
if(isset($antwoord)){
  if($_SESSION['levens'] > 0){
    echo "Je hebt " . $_SESSION['levens'] . " levens over.";
  }else{
    $lost = true;
  }


  if (strpos($antwoord, $userinput) !== false) { // if a letter is guessed right
    for ($i=0; $i <= (strlen($antwoord)-1); $i++) {// it loops checking each letter based on the string length
      if($userinput == $raadwoord[$i]){
        $_SESSION['raadtekst'][$i] = $userinput;
        ksort($_SESSION['raadtekst']); // retains original order of the array
      }
    }
}else{ // if you guessed wrongly, lives are subtracted, and it puts the mistakes in the mistakes array
    $_SESSION['levens']--;
    array_push($fouten, $userinput);
    $_SESSION['fouten'] = $fouten;
  }
}


// if the array for guessed letters matches the answer, you win
if(isset($antwoord)){
  if(implode($_SESSION['raadtekst']) == $antwoord){
    $won = true;
    echo "<h1> Je hebt gewonnen!! </h1>";
  }
}

// makes you go to the game end screen
if($won || $lost){
  $gameend = true;
}

 ?>
<!-- some html shenanigans -->
<!DOCTYPE html>
<html lang="nl" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Galgje Remake</title>
    <!-- i dislike CSS... so i didnt bother using it XD -->
  </head>
  <body
  <?php if($lost){ // the screen for losing
  echo "style='background-color: red;'";} echo ">";
  if($_SESSION['chooseword']){
    echo '<form action="hangman.php" method="post" autocomplete="off">';
      echo '<input type="text" name="antwoord">';
      echo'<input type="submit" value="Bevestig">';
    echo '</form>';
    $_SESSION['chooseword'] = false;
    $gameend = false;
  }elseif(!$gameend){ // the playscreen
      echo  '<form action="hangman.php" method="request" autocomplete="off">';
      echo    '<input type="text" name="letter" maxlength="1">';
      echo '<input type="submit" value="Bevestig">';
      echo '</form>';
      echo '<h1> Je hebt '; foreach($_SESSION['raadtekst'] as $raadpogingen){ echo $raadpogingen;} echo ' al geraden.</h1>';
      echo "<h1> Je hebt: " . $userinput . " ingevoerd.</h1>  </br>";
      echo "<h1> Fouten: "; foreach($fouten as $fout){echo $fout . ", ";} echo "</h1>";
    }

      if($lost){// text for if you lost
        echo "<p><a href='?reset' style='color:black; font-size:3em; text-decoration:none;'>Je hebt verloren, probeer opnieuw</a></p>";
      }elseif($won){ // text for if you won
        echo "<p><a href='?reset' style='color:black; font-size:2em; text-decoration:none;'>Je hebt gewonnen, klik hier om weer te spelen!</a></p>";
        echo "<p style='font-size: 2em;'>Het geraden woord was: &quot;" . $antwoord . "&quot;.</p>";
        echo "<img src='https://img.freepik.com/vrije-vector/winnaar-beker-gefeliciteerd-triumph-prijs-overwinning-icoon-illustratie_100456-1422.jpg?size=338&ext=jpg'/>";
      }else{ // text for while the game is still being played
        echo "<p><a href='?reset' style='color:black; text-decoration:none;'>Klik hier om opnieuw te beginnen</a></p>";
      }

      echo "</body>";
      echo "</html>";
      echo "</center>";

?>
