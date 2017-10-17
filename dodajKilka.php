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
			<input name="search_button" type="submit" value="Dodaj" class="button_search" > 
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

 <br/>
 
 
  <?PHP  
  

    while($row = mysql_fetch_array($sql_result_query))
    {
	$tablica[] = $row;
  
	  foreach($tablica as $klucz => $wartosc){
		  $operatorID = $userRow['user_id'];
	 $EANN =  $wartosc['EAN']; 
	 $KODD =  $wartosc['Kod']; 
	 $NAZWAA =  $wartosc['Nazwa']; 
	 $data = date ("Y-m-d");
$czas = date ("H:i:s");

 reset($tablica);}

$MAGZRO = $userRow['Mag_Zrodlowy'];
	  
mysql_query("INSERT INTO `kacper7_cennik`.`Dokumenty_MM` (`ID`, `EAN`, `KOD`, `Nazwa`, `MM_Mag_zrodlowy`, `MM_Mag_docelowy`, `Data_wyst`, `Czas_wyst`, `user_id`, `Export`, `Cofniete`, `Uwagi`, `Temp`)  VALUES ('','$EANN','$KODD','$NAZWAA','$MAGZRO','','$data','$czas','$operatorID','','','','1')");

	  
	  
}
?>

	
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
		
	

<h2>Tymczasowe dokumenty </h2>
	<form action="" method="post">
			<?php
$operatorID = $userRow['user_id']; 
$Mag_zro = $userRow['Mag_Zrodlowy']; 
$query  = ("SELECT * FROM Dokumenty_MM WHERE Data_wyst = CURDATE() AND user_id= $operatorID AND Cofniete = 0 AND Temp = 1" );
$result = mysql_query($query)
    or die("Query failed");
$LP = 1;
$i = 0;
?>
			<table>
			<tr>
			<td class="naglowki">Lp.</td>
			<td class="naglowki">EAN</td>
			<td class="naglowki">KOD</td>
			<td class="naglowki">Nazwa</td>
			<td class="naglowki">Na</td>
			<td class="naglowki">uwagi</td>

			</tr>
				<?php
			
while ($row = mysql_fetch_array($result)) {
	
	
	$tblID[] = $row['ID'];
    echo '<TR><TD>' . $LP++ .
		'</TD><TD>' . $row['EAN'] .
         '</TD><TD><b>' . $row['KOD'] .
		  '</b></TD><TD>' . $row['Nazwa'] .
		   '</TD><TD>
		   <select name="MAGDOCELOWY-'.$i++.'">
			<option value="">Wybierz</option>
			<option value="01Andrychow">A</option>
			<option value="02Kety">K</option>
			<option value="03Wadowice">W</option>
			<option value="04Sucha-Beskidzka">S</option>
			<option value="05Pasaz-AND">PH</option>
			<option value="00Magazyn">M</option>
			</select>' . $row['MM_Mag_docelowy'] .
		    '</TD><TD>' ;
			?>
			<input type="text" name="uwagi-<?php echo $i-1; ?>" value="" class="uwagi">

			
		
		

       <?php echo  "</TD></TR>";
	  
	   }
	   	
	   ?>
</table>
	<input type='hidden' name='LP' value='<?php echo $LP; ?>'>
<?php for ( $i = 0; $i < $LP; $i++ )
      {
    
		   
		   echo '<input type="hidden" name="ID-'. $i .'" value="' . $tblID[$i] . '">';
	
      }  ?>
<input name="btn-add-temp" type="submit" class="button" value="Wyślij">	
</form>		
<?php

if(isset($_POST['btn-add-temp']))
{
$LP = $_POST['LP']; 
$i = 0;
for ( $i = 0; $i < $LP; $i++ )
{
$Uwag[$i] = $_POST['uwagi-'.$i.'']; 
$MagDoc[$i] = $_POST['MAGDOCELOWY-'.$i.'']; 
$ID[$i] = $_POST['ID-'.$i.'']; 

	 mysql_query ('UPDATE Dokumenty_MM SET MM_Mag_docelowy="'.$MagDoc[$i].'" WHERE ID='.$ID[$i].'');
	  mysql_query ('UPDATE Dokumenty_MM SET Uwagi="'.$Uwag[$i].'" WHERE ID='.$ID[$i].'');
	 mysql_query ('UPDATE Dokumenty_MM SET Temp = 0 WHERE ID='.$ID[$i].'');


}
}
mysql_free_result($result);
ob_end_flush();

?>


			

			</div>

		
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