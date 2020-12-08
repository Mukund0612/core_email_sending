<?php $name = $_GET['name']; 
$name = explode('%20',$name)[0];

?>
<h1>WELLCOME TO <?php echo $name; ?> DASHBOARD</h1>