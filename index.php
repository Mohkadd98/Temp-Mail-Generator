<?php


if (isset($_GET['id'])) {
  $count =intval($_GET['id']) ;
}else{
$count = 0;

}

$default = 0;

if(!empty($count)){
  $default = 0+$count;
}

if(!empty($count)){

  $url = "https://www.1secmail.com/api/v1/?action=genRandomMailbox&count=$count";
  $json = file_get_contents($url);
  $data = json_decode($json, true);

}else if($count == NULL){
  $count = 1;
  $url = "https://www.1secmail.com/api/v1/?action=genRandomMailbox&count=$count";
  $json = file_get_contents($url);
  $data = json_decode($json, true);
  
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Temp Mail Generator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</head>
<body style="background: #088F8F;">
<div class="container">

<div class="card" style="margin-top: 50px;">
<div class="card-header">
<h4 align="center">Temp Mail Generator</h4>
</div>
 <div class="card-body">
<table  class="table table-borderless" style="justify-content: center" >
  <tr>
    <td>Login:</td>
    <td><input type="text" id="inputMail" class="form-control" placeholder="enter your email"></td>
    <td colspan="3" align="center"><button id="checkButton" style="background: #088F8F;"class="btn btn-success" type="submit">Check</button></td>
  </tr>
  <tr>
    <td><hr></td>
    <td><hr></td>
    <td><hr></td>
    <td><hr></td>
  </tr>
  
    <?php
      for ($i = 0; $i < $count; $i++) {
          echo '<tr><td>Email:</td>';
          echo '<td id="email-'.$i.'">' . $data[$i] . '</td>';
          echo '<td><button style="background: #088F8F;"class="btn btn-success btn-copy-'.$i.'" data-clipboard-target="#email-'.$i.'">Copy</button></td>
          <td><a  style="background: #088F8F;"href="./view.php?id=' . $data[$i] . '" class="btn btn-success">Check Mail</a></td></tr>';

          


          echo '<script src="https://cdn.jsdelivr.net/npm/clipboard@2/dist/clipboard.min.js"></script>';
          echo '<script> var clipboard = new ClipboardJS(".btn btn-success btn-copy-'.$i.'"); clipboard.on("success", function(e) { audio.play(); e.clearSelection(); }); </script>';
      }
    ?>

    
  <tr>
    <td>Mass:</td>    
    <td><input type="text" id="inMail" class="form-control" placeholder="example: 10"></td>   
    <td> </td> 
    <td  colspan="3" align="left"><button style="background: #088F8F;"id="genMail" class="btn btn-success custom-search-botton" type="submit">Generate</button></td>
  </tr>
</table>




</div>
</div>
<script>
  var audio = document.getElementById("myAudio");

  document.getElementById('checkButton').onclick = function() {
    window.location = "./view.php?id=" + document.getElementById('inputMail').value;
    return false;
      }
</script>
<script>
  document.getElementById('genMail').onclick = function() {
    window.location = "./?id=" + document.getElementById('inMail').value;
    return false;
      }
</script>
</body>
</html>
