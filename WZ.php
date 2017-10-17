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
require("dodajWZ.php");
require("usunWZ.php");
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
	
	<form action="" method="post">
	  <input name="Nazwa" type="text" value="">
	   <input name="btn-add" type="submit" value="Sprzedano nie zeskanowano" class="button_search">
	</form>
	
	
	
	
	
	
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
	
    <button type="submit" name="btn-add" value="WYD.ZA.REKL">WYD.ZA.REKL</button>
	    <button type="submit" name="btn-add" value="RP">RP</button>
		  <button type="submit" name="btn-add" value="POM.W.KART">POM.W.KART</button>
		    <button type="submit" name="btn-add" value="EKSP">EKSP</button>
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
		
	

<h2>Dzisiejsze dokumenty WZ </h2>
			<?php
$operatorID = $userRow['user_id']; 




$query  = ("SELECT * FROM Dokumenty_WZ WHERE Data_wyst = CURDATE() AND user_id= $operatorID");
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
			<td class="naglowki">Rodzaj</td>
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
		  '</TD><TD>' . $row['RodzajWZ'] .
		    '</TD><TD>' . $row['Data_wyst'] .
			  '</TD><TD style="color: #12B300;">' . $row['Uwagi'] ;
			?>
			
			</TD><TD>
	
			<form action="" method="post">
			<input type='hidden' name='EAN' value='<?php echo $row['EAN']; ?>'>
			<input type='hidden' name='ID' value='<?php echo $row['ID']; ?>'>
			<input name="btn-del" type="submit" class="button-del" value="Usun" onclick="return confirm('Czy na pewno chcesz usunąć WZ?');"> 


			
		</form>
			
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