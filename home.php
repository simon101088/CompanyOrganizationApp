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
require("dodajMM.php");
require("usunMM.php");
require("dodajUwagi.php");
require("usunUwagi.php");
require("mail.php");


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
		  <td>  Uwagi: <input type="text" name="uwagi" value="" class="uwagi"></td>
		 <input type='hidden' name='EAN' value='<?php echo $wartosc['EAN']; ?>'>
		<input type='hidden' name='Kod' value='<?php echo $wartosc['Kod']; ?>'>
		<input type='hidden' name='Nazwa' value='<?php echo $wartosc['Nazwa']; ?>'>

      </tr>
	  </table>
	  <?PHP   
	  reset($tablica);}

}
?>
	
    <button type="submit" name="btn-add" value="01Andrychow">A</button>
	    <button type="submit" name="btn-add" value="02Kety">K</button>
		    <button type="submit" name="btn-add" value="03Wadowice">W</button>
			    <button type="submit" name="btn-add" value="04Sucha-Beskidzka">S</button>
				    <button type="submit" name="btn-add" value="05Pasaz-AND">PH</button>
					 <button type="submit" name="btn-add" value="00Magazyn">M</button>
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
		
	

<h2>Dzisiejsze dokumenty MM </h2>
<h5>Synchronizacja z systemem odbywa się co godzinę 10 minut(09:10; 10:10). Po udanej synchronizacji nie ma możliwości usunięcia przerzutki</h5>

			<?php
$operatorID = $userRow['user_id']; 
$Mag_zro = $userRow['Mag_Zrodlowy']; 
$query  = ("SELECT * FROM Dokumenty_MM WHERE Data_wyst = CURDATE() AND user_id= $operatorID AND Cofniete = 0" );
$result = mysql_query($query)
    or die("Query failed");
$LP = 1;

?>
			<table>
			<tr>
			<td class="naglowki">Lp.</td>
			<td class="naglowki">EAN</td>
			<td class="naglowki">KOD</td>
			<td class="naglowki">Nazwa</td>
			<td class="naglowki">Na</td>
			<td class="naglowki">Data</td>
			<td class="naglowki">Uwagi</td>
			<td class="naglowki">Operacje</td>
			</tr>
				<?php
			
while ($row = mysql_fetch_array($result)) {

    echo '<TR><TD>' . $LP++ .
		'</TD><TD>' . $row['EAN'] .
         '</TD><TD><b>' . $row['KOD'] .
		  '</b></TD><TD>' . $row['Nazwa'] .
		   '</TD><TD>' . $row['MM_Mag_docelowy'] .
		    '</TD><TD>' . $row['Data_wyst'] .
	
			  '</TD><TD style="color: #12B300;">' . $row['Uwagi'] ;
			?>
			
			</TD><TD>
	
			<form action="" method="post">
			<input type='hidden' name='EAN' value='<?php echo $row['EAN']; ?>'>
			<input type='hidden' name='ID' value='<?php echo $row['ID']; ?>'>
			
			<?php 
$Export = $row['Export'];
if($Export == 0) { ?>
			<input name="btn-del" type="submit" class="button-del" value="Usun" onclick="return confirm('Czy na pewno chcesz usunąć MM?');"> 
<?php } else { 


?>
<input type='hidden' name='uwagi' value='Cofnięcie dokumentu MM'>
<input type='hidden' name='Kod' value='<?php echo $row['KOD']; ?>'>
<input type='hidden' name='Nazwa' value='<?php echo $row['Nazwa']; ?>'>
<input type='hidden' name='Mag_zro' value='<?php echo $row['MM_Mag_docelowy']; ?>'>
<input name="btn-back" type="submit" class="button-back" value="Cofnij" onclick="return confirm('Czy na pewno chcesz cofnąć MM?');">

<?php } ?>
	
		</form>
       <?php echo  "</TD></TR>"; } ?>
</table>
			
<?php
mysql_free_result($result);
ob_end_flush()

?>



			
<div class="end-day">
			<form action="" method="post">
			Zamówienia:<input type="text"  value="" name="zamowieniadzienne" class="MailUwagi">
			Uwagi: <input type="text"  value="" name="uwagidzienne" class="MailUwagi">
			<input type="submit" class="button" value="Zapisz" name="btn-uwagi">
			
			</form>

<div style="clear: both;"></div>
<p class="title">Uwagi i zamówienia </p>
<?php
$uID = $userRow['user_id'];
$query  = ("SELECT * FROM Uwagi WHERE data = CURDATE() AND user_id = '$uID' ORDER BY ID DESC ");
$result = mysql_query($query)
    or die("Query failed");
$LP = 1;

?>
			<table>
			<tr>
			
			<td class="naglowki">Zamówienia</td>
			<td class="naglowki">Uwagi</td>
			<td class="naglowki">data</td>
			<td class="naglowki">Operacje</td>
			
			</tr>
				<?php
			
while ($row = mysql_fetch_array($result)) {

    echo '<TR><TD>' . $row['Zamowienia'] .
		'</TD><TD>' . $row['Uwagi'] .
         '</TD><TD><b>' . $row['data'] .
			  '</TD><TD style="color: #12B300;">';
			  
			?>
			
			<form action="" method="post">
			<input type='hidden' name='ID' value='<?php echo $row['ID']; ?>'>
			<input name="uwa-del" type="submit" class="button-del" value="Usun" onclick="return confirm('Czy na pewno chcesz tą Uwagę?');"> 
			
			</TD></TR>
	
			
       <?php } ?>
</table>
			
<?php
mysql_free_result($result);
ob_end_flush()

?>			

			
	<form action="" method="post">
			<input type="submit" class="button" value="Zakończenie dnia" name="btn-end-day" onclick="return confirm('Czy na pewno chcesz wysłać e-mail?');">	
	</form>		
</div>

			
			<div style="clear: both;"></div>
			<p class="title">Aktualnie przerzucane na <?php echo $userRow['Mag_Zrodlowy']; ?> </p>

			<?php
$Mag_docelowy = $userRow['Mag_Zrodlowy']; 
$query  = ("SELECT * FROM Dokumenty_MM WHERE Data_wyst = CURDATE() AND MM_Mag_docelowy= '$Mag_docelowy' AND Cofniete = 0 ORDER BY ID DESC ");
$result = mysql_query($query)
    or die("Query failed");
$LP = 1;

?>
			<table>
			<tr>
			<td class="naglowki">Lp.</td>
			<td class="naglowki">EAN</td>
			<td class="naglowki">KOD</td>
			<td class="naglowki">Nazwa</td>
			<td class="naglowki">Z</td>
			<td class="naglowki">Data</td>
			<td class="naglowki">Uwagi</td>
			
			</tr>
				<?php
			
while ($row = mysql_fetch_array($result)) {

    echo '<TR><TD>' . $LP++ .
		'</TD><TD>' . $row['EAN'] .
         '</TD><TD><b>' . $row['KOD'] .
		  '</b></TD><TD>' . $row['Nazwa'] .
		   '</TD><TD>' . $row['MM_Mag_zrodlowy'] .
		    '</TD><TD>' . $row['Data_wyst'] . ' '. $row['Czas_wyst'].
			  '</TD><TD style="color: #12B300;">' . $row['Uwagi'] ;
			?>
			
			</TD></TR>
	
			
       <?php } ?>
</table>
			
<?php
mysql_free_result($result);
ob_end_flush()

?>
		</div>
		<!-- zadania 
		<div id="works">
			<h2>ZADANIA:</h2>
			<table>
			<tr>
			<td class="naglowki">ID</td>
			<td class="naglowki">Nazwa</td>
			<td class="naglowki">Opis</td>
			<td class="naglowki">Termin</td>
			<td class="naglowki">Status</td>
			<td class="naglowki">Uwagi</td>
			<td class="naglowki">Operacje</td>
			</tr>	
			<tr>
			<td>1</td>
			<td>Kartony</td>
			<td>Spakować 5 kartonów mokasyny 2016</td>
			<td>18-06-2016</td>
			<td>Wprowadzone</td>
			<td>Uwagi</td>
			<td>Edytuj</td>
			</table>
		</div>
		/zadania -->
					<!-- reklamacje 
		<div id="complaints">
			<h2>REKLAMACJE:</h2>
			<p>Nadchodzące terminy reklamacji </p>
			
			
			<table>
			<tr>
			<td class="naglowki">Lp.</td>
			<td class="naglowki">EAN</td>
			<td class="naglowki">KOD</td>
			<td class="naglowki">Imię</td>
			<td class="naglowki">Nazwisko</td>
			<td class="naglowki">Miasto</td>
			<td class="naglowki">Telefon</td>
			<td class="naglowki">Opis wady</td>
			<td class="naglowki">Termin</td>
			<td class="naglowki">Status</td>
			<td class="naglowki">Operacje</td>
			</tr>
				<tr>
				<td>1</td>
			<td>12345678</td>
			<td>BAD-2159-036-40</td>
			<td>Szymon</td>
			<td>Lyson</td>
			<td>Rzyki</td>
			<td>600 706 623</td>
			<td>Pęknięta podeszwa w prawym bucie</td>
			<td>17-06-2016</td>
			<td>U producenta</td>
			<td>Edytuj</td>
			</tr>
				
			
			
			</table>
		</div>
	 /reklamacje -->
	</div>
	
	


</div>
<div id="footer">

</div>





</body>


</html>