
<?php
if(isset($_POST['btn-uwagi']))
{
$uwagi = $_POST['uwagidzienne']; 
$zamowienia = $_POST['zamowieniadzienne']; 
$data = date ("Y-m-d");
$operatorID = $userRow['user_id']; 
$operatorMag = $userRow['Mag_Zrodlowy']; 

if($value == $operatorMag) 
{ 
  ?>
       <div class="alert">
			<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
			Błąd - Nie można zapisać uwagi.
		</div>
        <?php
}
else {

 if(mysql_query("INSERT INTO `kacper7_cennik`.`Uwagi` (`ID`, `Uwagi`, `Zamowienia`, `data`, `Magazyn`, `user_id`)  VALUES ('','$uwagi','$zamowienia', '$data','$operatorMag','$operatorID')"))


	 {
	?>
     
         <div class="alertok">
			<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
			Prawidłowo dodano uwagę
		</div>
		<?php
 }
 else
 {
  ?>
       <div class="alert">
			<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
			Błąd, nie dodano dokumentu
		</div>
        <?php
 }
 
}
}



?>