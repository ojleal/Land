<?php
//session_start();

if(isset($_POST['B']) && !empty($_POST['B']) && !empty($_POST['G'])) {

$email=$_POST['email'];
$fbid=$_POST['google_id'];
$firstname=$_POST['firstname'];
$lastname=$_POST['lastname'];
$password='testapi';

$picture = $_POST['imageUrl'];
$backgroundimg = $_POST['imageUrl'];
echo "<script type='text/javascript'>alert('$email');</script>";
echo "<script type='text/javascript'>alert('$google_id');</script>";
echo "<script type='text/javascript'>alert('$firstname');</script>";
echo "<script type='text/javascript'>alert('$lastname');</script>";
return false;
}
?>