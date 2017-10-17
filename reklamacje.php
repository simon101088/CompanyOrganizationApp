<?php

ob_start();
session_start();
include_once 'dbconnect.php';



if(!isset($_SESSION['user']))
{
 header("Location: index.php");
 
}
$res=mysql_query("SELECT * FROM users WHERE user_id=".$_SESSION['user']);
$userRow=mysql_fetch_array($res);

require("header.php");
require("dodajReklamacje.php");

?>

 




<body>

System Wspomagania sprzedaży SklepKamil 
<div id="top">
	<div class="top-left"><?php echo $userRow['Mag_Zrodlowy']; ?></div>
	<div class="top-right"><a href="logout.php?logout">Wyloguj</a>
	
	<?php
	 
$query = mysql_query("SELECT data FROM Export ORDER BY ID DESC LIMIT 1");
$row = mysql_fetch_array($query);
$synchdate = $row['data'];
	?>
	
	<br>Data ostatniej synchronizacji: <?php echo $synchdate; ?></div>
</div>
<?php require("nav.php")?>

<div id="container">
	<div class="search-box"> 
		<form action="" method="post">
		 
		  <input name="search_term" type="text" value="" autofocus>
			<input name="search_button" type="submit" value="Wyszukaj po EAN lub kodzie produktu" class="button_search" > 
		</form>
	
	<div style="border-bottom: 1px solid #fff; height: 5px;"></div>
	
	
	
	
	
	<?php
	$RESULTS_LIMIT=1;
if(isset($_POST['search_term']) && isset($_POST['search_button']))
{
      $search_term = $_POST['search_term'];
    if(!isset($first_pos))
    {
        $first_pos = "0";
    }

      //initializing MySQL Quary 

    $sql_query = mysql_query("SELECT * FROM Cennik WHERE MATCH(EAN,Kod) AGAINST('$search_term')");
    //additional check. Insurance method to re-search the database again in case of too many matches (too many matches cause returning of 0 results)
    
                  $sql = "SELECT * FROM Cennik WHERE (EAN LIKE '%".mysql_real_escape_string($search_term)."%' OR Kod LIKE '%".$search_term."%') ";
                  $sql_query = mysql_query($sql);
                  $results = mysql_num_rows($sql_query);
                  $sql_result_query = mysql_query("SELECT * FROM Cennik WHERE (EAN LIKE '%".$search_term."%' OR Kod LIKE '%".$search_term."%') LIMIT $first_pos, $RESULTS_LIMIT ");
}
?>
<?PHP
if($results != 0)
{
?>  
   <!-- Displaying of the results -->

Wyniki zapytania dla<?PHP echo "<i><b><font color=#000000>".$search_term."</font></b></i> "; ?>
 <br/>
  <form method="post" action="">
  <?PHP  
    while($row = mysql_fetch_array($sql_result_query))
    {
	$tablica[] = $row;
  
	  foreach($tablica as $klucz => $wartosc){  ?>
	<table>
      <tr>
        <td><?PHP echo $row['EAN']; ?></td>
		 <td class="search_result"><?PHP echo $row['Kod']; ?></td>
		 <td class="search_result"><?PHP echo $row['Nazwa']; ?></td>
		 
		<input type='hidden' name='EAN' value='<?php echo $wartosc['EAN']; ?>'>
		<input type='hidden' name='Kod' value='<?php echo $wartosc['Kod']; ?>'>

      </tr>
	  </table>
	  <?PHP   
	  reset($tablica);}

}
 
?>
<div class="reklamacje">
<table>

<tr><td>Data sporządzenia: </td><td><input type='text' name='dataSporzadzenia' value=''></td></tr>
<tr><td>Data nabycia:</td><td> <input type='text' name='dataNabycia' value=''></td></tr>
<tr><td>Imię:</td><td> <input type='text' name='imie' value=''></td></tr>
<tr><td>Nazwisko: </td><td><input type='text' name='nazwisko' value=''></td></tr>
<tr><td>Miasto:</td><td> <input type='text' name='miasto' value=''></td></tr>
<tr><td>Ulica: </td><td><input type='text' name='ulica' value=''></td></tr>
<tr><td>Nr domu:</td><td> <input type='text' name='nrDomu' value=''></td></tr>
<tr><td>Kod pocztowy: </td><td> <input type='text' name='kodPocztowy' value=''></td></tr>
<tr><td>Telefon:</td><td> <input type='text' name='telefon' value=''></td></tr>
<tr><td>Określenie wady: </td><td><input type='text' name='okreslenieWady' value=''></td></tr>
<tr><td>Kiedy stwierdzono wadę: </td><td><input type='text' name='dataStwierdzenia' value=''></td></tr>
<tr><td>Żądanie reklamującego:</td><td> <input type='text' name='zadanieReklamujacego' value=''></td></tr>
<tr><td colspan="2"><input type="submit" name="btn-add" value="wyslij zgłoszenie reklamacyjne"></td></tr> 
</table>
</div>
	 </form>

	
	
	
	
<?PHP
}
elseif($sql_query)
{
?>
 Brak wyników dla   <?PHP echo "<i><b><font color=#000000>".$search_term."</font></b></i> "; ?>
<?PHP
}
?>
   <!-- / Displaying of the results -->
	
	</div>
	
	<div id="content">
		<div class="MM">
		
	

<h2>Aktualne reklamacje</h2>
			<?php
$operatorID = $userRow['user_id']; 




$query  = ("SELECT * FROM Reklamacje WHERE user_id=$operatorID ORDER BY Termin DESC LIMIT 20");
$result = mysql_query($query)


    or die("Query failed");

?>

 
			<table>
			<tr>
			
			<td class="naglowki">ID</td>
			<td class="naglowki">EAN</td>
			<td class="naglowki">KOD</td>
			<td class="naglowki">Sporządzone</td>
			<td class="naglowki">Nabyte</td>
			<td class="naglowki">Imię</td>
			<td class="naglowki">Nazwisko</td>
			<td class="naglowki">Ulica</td>
				<td class="naglowki">Nr domu</td>
					<td class="naglowki">Kod pocztowy</td>
						<td class="naglowki">Miasto</td>

							<td class="naglowki">telefon</td>
								<td class="naglowki">Okreslenie wady</td>
									<td class="naglowki">Stwierdzono</td>
										<td class="naglowki">Żądanie reklamujacego</td>
											<td class="naglowki">Termin</td>
												<td class="naglowki">Status</td>
									
			</tr>
				<?php
			
while ($row = mysql_fetch_array($result)) {

    echo '<TR><TD>' . $row['Id'].
		'</TD><TD>' . $row['EAN'] .
         '</TD><TD><b>' . $row['KOD'] .
		  '</b></TD><TD>' . $row['Data_sporzadzenia'] .
		  '</TD><TD>' . $row['data_nabycia'] .
		    '</TD><TD>' . $row['Klient_imie'] .
			   '</TD><TD>' . $row['Klient_nazwisko'] .
			      '</TD><TD>' . $row['Klient_ulica'] .
				     '</TD><TD>' . $row['Klient_nrdomu'] .
					    '</TD><TD>' . $row['Klient_kodpocztowy'] .
						   '</TD><TD>' . $row['Klient_miasto'] .
						      '</TD><TD>' . $row['Klient_telefon'] .
							     '</TD><TD>' . $row['Opis_wady'] .
								    '</TD><TD>' . $row['Kiedy_stwierdzono'] .
									   '</TD><TD>' . $row['Zadanie_reklamujacego'] .
									   '</TD><TD>' . $row['Termin'] .
			  '</TD><TD>' . $row['Status'] ;
			?>
			
			</TD><TD>
	
			
			
       <?php
	
	   echo  "</TD></TR>";

}

?>
	
			
			
			</table>
			
<?php
mysql_free_result($result);
ob_end_flush()

?>			

	


</div>
<div id="footer">

</div>





</body>


</html>