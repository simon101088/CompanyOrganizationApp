
<?php
if(isset($_POST['btn-add']))
{
$uwagi = $_POST['uwagi']; 
$value = $_POST['btn-add']; 
$MMean = $_POST['EAN'];  
$MMKod = $_POST['Kod'];  
$MMNazwa = $_POST['Nazwa'];  
$data = date ("Y-m-d");
$operatorID = $userRow['user_id']; 
$operatorMag = $userRow['Mag_Zrodlowy']; 

if($value == $operatorMag) 
{ 
  ?>
       <div class="alert">
			<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
			Nie można przerzucić pary na magazyn źródłowy
		</div>
        <?php
}
else {

 if(mysql_query("INSERT INTO `kacper7_cennik`.`Dokumenty_WZ` (`ID`, `EAN`, `KOD`, `Nazwa`, `WZ_Mag_zrodlowy`, `RodzajWZ`, `Data_wyst`, `user_id`, `Uwagi`)  VALUES ('','$MMean','$MMKod','$MMNazwa','$operatorMag','$value','$data','$operatorID','$uwagi')"))


	 {
	?>
     
         <div class="alertok">
			<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
			Prawidłowo dodano do listy WZ
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