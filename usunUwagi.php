<?php 


if(isset($_POST['uwa-del']))
{  
$DELID = $_POST['ID'];  
$data = date ("Y-m-d");
$operatorID = $userRow['user_id']; 

 if(mysql_query("DELETE FROM Uwagi Where ID = '$DELID'"))


	 {
  ?>
       <div class="alertok">
			<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
			Prawidłowo usunięto uwagę
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