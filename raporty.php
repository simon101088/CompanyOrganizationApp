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



?>

 

<!DOCTYPE html>

<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<meta http-equiv="Content-Language" content="pl" />
	<meta http-equiv="Content-Type-Script" content="text/javascript" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta name="Robots" content="noindex, nofollow" /> 

 

<link rel="stylesheet" type="text/css" href="style.css">

<title>Witaj - <?php echo $userRow['email']; ?></title>
</head>


<body>

System Wspomagania sprzedaży SklepKamil 
<div id="top">
	<div class="top-left"><?php echo $userRow['Mag_Zrodlowy']; ?></div>
	<div class="top-right"><a href="logout.php?logout">Wyloguj</a>
	<!--<br>Data ostatniej synchronizacji: [[18-06-2016 15:05]]--> </div>
</div>

<?php require("nav.php")?>

<div id="container">
	
	
	<div id="content">
		<div class="MM">
		
	

<h2>Archiwum MM</h2>
			<?php

$operatorID = $userRow['user_id']; 
if ($operatorID == 0) {
$query  = ("SELECT * FROM Dokumenty_MM ORDER BY ID DESC LIMIT 40");
$result = mysql_query($query)
or die("Query failed");
	


?>
			<table>
			<tr>
			
			<td class="naglowki">EAN</td>
			<td class="naglowki">KOD</td>
			<td class="naglowki">Nazwa</td>
			<td class="naglowki">Z</td>
			<td class="naglowki">Na</td>
			<td class="naglowki">Data</td>
			<td class="naglowki">Uwagi</td>
			
			</tr>
				<?php
			
while ($row = mysql_fetch_array($result)) {

    echo
		'<TR><TD>' . $row['EAN'] .
         '</TD><TD><b>' . $row['KOD'] .
		  '</b></TD><TD>' . $row['Nazwa'] .
		  '</TD><TD>' . $row['MM_Mag_zrodlowy'] .
		   '</TD><TD>' . $row['MM_Mag_docelowy'] .
		    '</TD><TD>' . $row['Data_wyst'] .' '. $row['Czas_wyst'].
			  '</TD><TD style="color: #12B300;">' . $row['Uwagi'] 
			?>
			
			</TD></TR>
       <?php } ?>

			</table>

	 <?php
}
else {
$query  = ("SELECT * FROM Dokumenty_MM WHERE user_id= $operatorID");
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
			
			</tr>
				<?php
			
while ($row = mysql_fetch_array($result)) {

    echo '<TR><TD>' . $LP++ .
		'</TD><TD>' . $row['EAN'] .
         '</TD><TD><b>' . $row['KOD'] .
		  '</b></TD><TD>' . $row['Nazwa'] .
		   '</TD><TD>' . $row['MM_Mag_docelowy'] .
		    '</TD><TD>' . $row['Data_wyst'] .
			  '</TD><TD style="color: #12B300;">' . $row['Uwagi'] 
			?>
			
			</TD></TR>
	
		
			
       <?php
}
?>
	
			
			
			</table>
			
<?php
}
mysql_free_result($result);
ob_end_flush()

?>			
			
			<div style="clear: both;"></div>
		</div>
		
	</div>
	
	


</div>
<div id="footer">
ver.1.0
</div>





</body>


</html>