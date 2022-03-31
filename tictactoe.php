<?php
// I made this in school, im still learning how to program, so i know it looks like shit
// the variables are mostly dutch, so bear with me

  session_start(); // start session to save squares chosen etc.


  // variables
  $tekens = array("", "X", "O");
  $vakjes = array();
  $O = $tekens[2];
  $X = $tekens[1];
  $Xwins = false;
  $Owins = false;
  $j = 1;
  $wie;

  // makes all squares empty, unless one of them contains a value
  if(!isset($_SESSION['vakjes'])){

    $_SESSION['win'] = array("","","","","","","","","","");
    $vakjes = array("","","","","","","","","","");
    $wie = true;

  }else{
  $vakjes = $_SESSION['vakjes'];
  $_SESSION['win'] = array("","","","","","","","","","");

  $wie = $_SESSION['wie'];
  }

  // I use Z to not have to check both X and O in the winning conditions
  if(!isset($Z)){
  $Z = $O;
}

  // resets the game
  if(isset($_GET['reset'])){
    session_destroy();
    header("location:tictactoe.php");
  }


// makes it so that the if-statement for the CSS classes later on gets the right character to win
if(isset($_SESSION['won'])){
  if(!$wie){
    $Z = $X;
  }else{
    $Z = $O;
  }
}

// only makes you click if you havent won yet
if(!isset($_SESSION['won'])){
  if(isset($_GET['klik'])){
    if($wie){
      $teken = 1;
      $Z = $X;
    }else{
      $teken = 2;
      $Z = $O;
    }
      $vakjes[$_GET['klik']] = $tekens[$teken];
  }
}
  // makes it so that the session knows what square youve chosen
  $_SESSION['vakjes'] = $vakjes;

        // if-statements to check if you won.. i know it looks like shit
       if ($vakjes[1] == $Z && $vakjes[2] == $Z && $vakjes[3] == $Z) {
         $_SESSION['win'][1] = true;
         $_SESSION['win'][2] = true;
         $_SESSION['win'][3] = true;
         $_SESSION['won'] = $Z . " heeft gewonnen!!";
       }elseif ($vakjes[4] == $Z && $vakjes[5] == $Z && $vakjes[6] == $Z) {
         $_SESSION['win'][4] = true;
         $_SESSION['win'][5] = true;
         $_SESSION['win'][6] = true;
         $_SESSION['won'] = $Z . " heeft gewonnen!!";
       }elseif ($vakjes[7] == $Z && $vakjes[8] == $Z && $vakjes[9] == $Z) {
         $_SESSION['win'][7] = true;
         $_SESSION['win'][8] = true;
         $_SESSION['win'][9] = true;
         $_SESSION['won'] = $Z . " heeft gewonnen!!";
       }elseif($vakjes[1] == $Z && $vakjes[4] == $Z && $vakjes[7] == $Z){
         $_SESSION['win'][1] = true;
         $_SESSION['win'][4] = true;
         $_SESSION['win'][7] = true;
         $_SESSION['won'] = $Z . " heeft gewonnen!!";
       }elseif($vakjes[2] == $Z && $vakjes[5] == $Z && $vakjes[8] == $Z){
         $_SESSION['win'][2] = true;
         $_SESSION['win'][5] = true;
         $_SESSION['win'][8] = true;
         $_SESSION['won'] = $Z . " heeft gewonnen!!";
       }elseif($vakjes[3] == $Z && $vakjes[6] == $Z && $vakjes[9] == $Z){
         $_SESSION['win'][3] = true;
         $_SESSION['win'][6] = true;
         $_SESSION['win'][9] = true;
         $_SESSION['won'] = $Z . " heeft gewonnen!!";
       }elseif($vakjes[1] == $Z && $vakjes[5] == $Z && $vakjes[9] == $Z){
         $_SESSION['win'][1] = true;
         $_SESSION['win'][5] = true;
         $_SESSION['win'][9] = true;
         $_SESSION['won'] = $Z . " heeft gewonnen!!";
       }elseif($vakjes[3] == $Z && $vakjes[5] == $Z && $vakjes[7] == $Z){
         $_SESSION['win'][3] = true;
         $_SESSION['win'][5] = true;
         $_SESSION['win'][7] = true;
         $_SESSION['won'] = $Z . " heeft gewonnen!!";
       }


       ?>
       <!-- some html, nothing special -->
       <html lang="nl" dir="ltr" id="html">
         <head>
           <meta charset="utf-8">
           <title>TicTacToe - By CallMeRinChan</title>
           <style type="text/css">
           /* some boring css, i couldnt bother doing it in a different file */
           #html{
             background-color: rgb(220,220,220);
             font-size: 2em;
           }

            table{
              border: 3px solid black;
              background-color: grey;
              border-radius: 5px;
              padding: 5px;
            }

             td{
               width: 75px;
               height: 75px;
               border: 1px solid black;
               text-align: center;
               border-radius: 5px;
               background: rgb(211,211,211);
               font-size: 1.7em;
               color: rgb(75, 0, 250);
               font-family: "Lucida Console";
             }

             .win{
               background: lightgreen;
             }

           </style>
         </head>
         <body>
          <center>
            <!-- some stupid solution to make the game be more in the middle -->
            <br/>
            <br/>
            <br/>
            <br/>
             <table>
               <?php
               // both for-loops make the playing field
               for ($i=0; $i < 3; $i++) {
                   echo "<tr>";

                 for ($j=1; $j <= 3; $j++) {
                   // the squares check if they've been clicked yet, and if the game has been won... this line is absolute garbage (165)
                   $a = ($i * 3) + $j;
                   echo "<td ";  if($_SESSION['win'][$a]){echo "class = 'win' ";} if(!$vakjes[$a] && !isset($_SESSION['won'])){echo "onclick='window.location.href=`tictactoe.php?klik=". $a ."`;'";} echo ">"; echo $vakjes[$a]; echo "</td>";

                 }
                   echo"</tr>";

               }
               ?>
             </table>
             <br/>

             <?php
            // winning message
            if(isset($_SESSION['won'])){
              echo $_SESSION['won'];
            }

            // so that if you clicked, you get redirected back to the file without any additions to the URL so you cant reload to cheat.
             if(isset($_GET['klik'])){
              header("location:tictactoe.php");
              $_SESSION['wie'] = !$wie;
            }

          ?>
          <!-- text to reset the game -->
       <p><a href="?reset">Reset</a></p>
    </center>
   </body>
 </html>
