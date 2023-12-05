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

 <div class="card" style="margin-top: 50px;">
   
<div class="card-header">
<h4 align="center">Temp Mail Generator</h4>
</div>
 <div class="card-body">

<?php

$login =htmlspecialchars($_GET['login']) ;
$domain =htmlspecialchars($_GET['domain']) ;
$id =htmlspecialchars($_GET['id']);

$url = 'https://www.1secmail.com/api/v1/?action=readMessage&login='.$login.'&domain='.$domain.'&id='.$id.'';
$json = file_get_contents($url);
$data = json_decode($json);

$html = '<div>';
$html .= '<td><strong>From:</strong> ' . $data->from . '</td>&nbsp;&nbsp;';
$html .= '<td><strong>Subject:</strong> ' . $data->subject . '</td>&nbsp;&nbsp;';
$html .= '<td><strong>Date:</strong> ' . $data->date . '</td>';

if (!empty($data->attachments)) {
    $html .= '<p><strong>Attachments:</strong></p>';
    $html .= '<ul>';
    foreach ($data->attachments as $attachment) {
        $html .= '<li>' . $attachment->filename . ' (' . $attachment->size . ' bytes)</li>';
    }
    $html .= '</ul>';
}

$html .= '<hr>';
$html .= '<textarea name="pctextarea" id="editor">' . nl2br($data->body) . '</textarea>';
$html .= '</div>';

echo $html;

?>
</div>
</div>
