<?php 


if(isset($_POST['btn-del']))
{

$DELean = $_POST['EAN'];  
$DELID = $_POST['ID'];  
$data = date ("Y-m-d");
$operatorID = $userRow['user_id']; 

 if(mysql_query("DELETE FROM Dokumenty_MM Where EAN = $DELean AND ID= $DELID"))


	 {
  ?>
       <div class="alertok">
			<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
			Prawidłowo usunięto z bazy mm
		</div>
        <?php
 }
 else
 {
  ?>
        <div class="alert">
			<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
			Błąd, nie usunięto pozycji
		</div>
        <?php
 }
 
}




?>