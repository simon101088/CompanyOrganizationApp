
<?php
if(isset($_POST['btn-add']))
{
$uwagi = $_POST['uwagi']; 
$value = $_POST['btn-add']; 
$MMean = $_POST['EAN'];  
$MMKod = $_POST['Kod'];  
$MMNazwa = $_POST['Nazwa'];  
$data = date ("Y-m-d");
$czas = date ("H:i:s");
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

 if(mysql_query("INSERT INTO `kacper7_cennik`.`Dokumenty_MM` (`ID`, `EAN`, `KOD`, `Nazwa`, `MM_Mag_zrodlowy`, `MM_Mag_docelowy`, `Data_wyst`, `Czas_wyst`, `user_id`, `Export`, `Cofniete`, `Uwagi`)  VALUES ('','$MMean','$MMKod','$MMNazwa','$operatorMag','$value','$data', '$czas','$operatorID','','','$uwagi')"))


	 {
	?>
     
         <div class="alertok">
			<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
			Prawidłowo dodano do listy MM
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
if(isset($_POST['btn-back']))
{
$uwagi = $_POST['uwagi']; 
$value = $_POST['Mag_zro']; 
$MMean = $_POST['EAN'];  
$MMKod = $_POST['Kod'];  
$MMNazwa = $_POST['Nazwa'];  
$data = date ("Y-m-d");
$operatorID = $userRow['user_id']; 
$operatorMag = $userRow['Mag_Zrodlowy']; 
$Id = $_POST['ID']; 

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

 if(mysql_query("INSERT INTO `kacper7_cennik`.`Dokumenty_MM` (`ID`, `EAN`, `KOD`, `Nazwa`, `MM_Mag_zrodlowy`, `MM_Mag_docelowy`, `Data_wyst`, `user_id`, `Export`, `Cofniete`, `Uwagi`)  VALUES ('','$MMean','$MMKod','$MMNazwa','$value','$operatorMag','$data','$operatorID','','1','$uwagi')"))


	 {
		 
		 
		 mysql_query ("UPDATE Dokumenty_MM SET Cofniete=1 WHERE ID=$ID");
	?>
     
         <div class="alertok">
			<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
			Prawidłowo cofnięto dokument MM
		</div>
		<?php
 }
 else
 {
  ?>
       <div class="alert">
			<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
			Błąd, cofnięto dokumentu
		</div>
        <?php
 }
 
}
}


?>