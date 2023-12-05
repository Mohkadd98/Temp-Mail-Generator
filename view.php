<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Temp Mail Generator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src='https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js'></script>
    <script>
    tinymce.init({
        selector: "#editor"
    });
    </script>
</head>
<body style="background: #088F8F;">
<div class="container">
<?php
function extractEmailParts($email) {
    $parts = explode("@", $email);
    $username = $parts[0];
    $domain = $parts[1];

    return [
        'username' => $username,
        'domain' => $domain
    ];
}

function getEmailDetails($email) {
    $emailParts = extractEmailParts($email);
    $username = $emailParts['username'];
    $domain = $emailParts['domain'];

    $url = 'https://www.1secmail.com/api/v1/?action=getMessages&login='.$username.'&domain='.$domain;
    $json = file_get_contents($url);
    $data = json_decode($json, true);
    if (!empty($data)) {
    $id = $data[0]['id'];
    $from = $data[0]['from'];
    $subject = $data[0]['subject'];
    $date = $data[0]['date'];
    
    return [
        'id' => $id,
        'from' => $from,
        'subject' => $subject,
        'date' => $date,
    ];
    }
}


$email = $_GET['id'];
$details = getEmailDetails($email);

if (isset($details['id']) && !empty($details['id'])) {
    $emailParts = extractEmailParts($email);
    $username = $emailParts['username'];
    $domain = $emailParts['domain'];
    $id = $details['id'];
    echo '<div class="container">
          <div class="card" style="margin-top: 50px;">
          <div class="card-header">
          <h4 align="center">Temp Mail Generator</h4>
          </div>
          <div class="card-body">';    
    echo '<table class="table table-borderless"align="center" >';
    echo '  <tr>';
    echo '    <td><strong>From:</strong></td>';
    echo '    <td>'.$details['from'].'</td>';
    echo '  </tr>';
    echo '  <tr>';
    echo '    <td><strong>Subject:</strong></td>';
    echo '    <td>'.$details['subject'].'</td>';
    echo '  </tr>';
    echo '  <tr>';
    echo '    <td><strong>Date:</strong></td>';
    echo '    <td>'.$details['date'].'</td>';
    echo '  </tr>';
    echo '  <tr>';
    echo '    <td><strong>Action:</strong></td>';
    echo "<td><a id='viewlink'class='btn btn-primary' value='./read.php?login=$username&domain=$domain&id=$id' href='./read.php?login=$username&domain=$domain&id=$id'>view</a>  <button style='background: #088F8F;'class='btn btn-success'onclick='loadData();'>Open Email</button></td><td><button class='btn btn-secondary'onclick='location.reload();'>Refresh</button></td>";
    echo '  </tr>';
    echo '</table>';


    echo '<script>audio.play();</script>';
  }else{
   echo '<div class="container">
          <div class="card" style="margin-top: 50px;">
          <div class="card-header">
          <h4 align="center">Temp Mail Generator</h4>
          </div>
          <div class="card-body">';    
    echo '<h4 align="center">Automatic refresh every 5 seconds
    <h4>';
    echo '<meta http-equiv="Refresh" content="5">';
    echo '<table class="table table-borderless" align="center">';
    echo '  <tr>';
    echo '   <td>';
    echo '      <p>Data No Disponible</p>';
    echo '   <td>';
        echo "      <button style='background: #088F8F;' class='btn btn-success' onclick='location.reload();'>Refresh</button>";
    echo '  <tr>';
    echo '</table>';
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Waiting email...</title>
</head>
<body>

<audio id="myAudio">
  <source src="./sound/notify.mp3" type="audio/mpeg">
</audio>

<script>
  var audio = document.getElementById("myAudio");
  function loadData() {
    var xhr = new XMLHttpRequest();
    let element = document.querySelector("#viewlink");
    let hrefValue = element.getAttribute("href");

    xhr.open('GET', hrefValue, true);

    xhr.onreadystatechange = function() {
      if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
        document.getElementById('dataContainer').innerHTML = xhr.responseText;
      }
    };

    xhr.send();
  }
</script>


<div class="container" id="dataContainer"></div>




</body>
</html>


