<?php
if(isset($_POST['btn-add']))
{
$dataSporzadzenia = $_POST['dataSporzadzenia']; 
$dataNabycia = $_POST['dataNabycia']; 
$imie = $_POST['imie']; 
$nazwisko = $_POST['nazwisko']; 
$miasto = $_POST['miasto']; 
$ulica = $_POST['ulica']; 
$nrDomu = $_POST['nrDomu']; 
$kodPocztowy = $_POST['kodPocztowy']; 
$telefon = $_POST['telefon']; 
$okreslenieWady = $_POST['okreslenieWady']; 
$dataStwierdzenia = $_POST['dataStwierdzenia']; 
$zadanieReklamujacego = $_POST['zadanieReklamujacego']; 
$ean = $_POST['EAN'];  
$Kod = $_POST['Kod'];  
$data = date("Y-m-d");
$operatorID = $userRow['user_id']; 
$operatorMag = $userRow['Mag_Zrodlowy']; 


 if(mysql_query("INSERT INTO `kacper7_cennik`.`Reklamacje` (`Id`, `EAN`, `KOD`, `Data_nabycia`, `Klient_imie`, `Klient_nazwisko`, `Klient_miasto`, `Klient_ulica`, `Klient_nrdomu`, `Klient_kodpocztowy`, `Klient_telefon`, `Opis_wady`, `Kiedy_stwierdzono`, `Zadanie_reklamujacego`, `Termin`, `Status`, `user_id`, `Data_sporzadzenia`) VALUES (NULL, '$ean', '$Kod', '$dataNabycia', '$imie', '$nazwisko', '$miasto', '$ulica', '$nrDomu', '$kodPocztowy', '$telefon', '$okreslenieWady', '$dataStwierdzenia', '$zadanieReklamujacego', '$data', 'Wprowadzone', '$operatorID', '$dataSporzadzenia')"))


	 {
	?>
     
         <div class="alertok">
			<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
			Prawidłowo dodano zgłoszenie reklamacji
		</div>
		<?php
 }
 else
 {
  ?>
       <div class="alert">
			<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
			Błąd, nie dodano zgłoszenia
			<?php echo mysql_errno() . ": " . mysql_error(). "\n";?>
		</div>
        <?php
 }
 

}

?>