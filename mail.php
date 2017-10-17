	<?php
	
	
	if(isset($_POST['btn-end-day']))
{
$LP = 1; 
$data = date ("Y-m-d");
$operatorID = $userRow['user_id']; 
$opEmail = $userRow['email']; 
$operatorMagazyn = $userRow['Mag_Zrodlowy']; 
$query  = ("SELECT * FROM Dokumenty_MM WHERE Data_wyst = CURDATE() AND user_id= $operatorID AND Cofniete = 0");
$result = mysql_query($query)
    or die("Query failed");
	
	
// multiple recipients
$to  = $opEmail . ', ';
$to .= 'info@sklepkamil.pl' . ', '; // note the comma
$to .= 'szymon.lyson@sklepkamil.pl';

// subject
$subject = $operatorMagazyn .' - Uwagi do raportu dziennego - '. $data;

// message

$message ='<b style="font-size: 16pt; color: #1f96c1;">'. $operatorMagazyn .'</b>-Uwagi do raportu dziennego-'. $data;
$message .= '<html><head>';
$message .= '<style type="text/css">
    body{
        margin:0;
        padding:0;
    }

	td {border-left: 2px solid #000; border-bottom: 1px solid #1f96c1; font-size: 11pt; height: 30px;}
	td.naglowek {border-bottom: 2px solid #000; text-align: center;}
	
</style>';



$message .= '</head><body>';
$message .= '<p></p>';
$message .= '<table style="width: 900px; border=2px solid black" cellpadding="0px" cellspacing="0px" >
			<tr>
			<td style="width: 3%;" class="naglowek"><b>Lp.</b></td>
			<td style="width: 10%;" class="naglowek"><b>EAN</b></td>
			<td style="width: 20%;" class="naglowek"><b>KOD</b></td>
			<td style="width: 34%;" class="naglowek"><b>Nazwa</b></td>
			<td style="width: 12%;" class="naglowek"><b>Na</b></td>
			<td style="width: 16%;" class="naglowek"><b>Uwagi</b></td>
			<td style="width: 16%;" class="naglowek"><b>Data</b></td>
			</tr>';
while ($row = mysql_fetch_array($result)) {
$message .= '<TR><TD>' . $LP++ .
		'</TD><TD>' . $row['EAN'] .
         '</TD><TD>' . $row['KOD'] .
		  '</TD><TD>' . $row['Nazwa'] .
		   '</TD><TD>' . $row['MM_Mag_docelowy'] .
		    '</TD><TD style="color: red">' . $row['Uwagi'] .
		    '</TD><TD>' . $row['Data_wyst'] .
			'</TD></TR>'
  ;

}
mysql_free_result($result);
$query  = ("SELECT * FROM Dokumenty_WZ WHERE Data_wyst = CURDATE() AND user_id= $operatorID");
$result = mysql_query($query)
    or die("Query failed");
while ($row = mysql_fetch_array($result)) {
$message .= '<TR><TD>' . $LP++ .
		'</TD><TD>' . $row['EAN'] .
         '</TD><TD>' . $row['KOD'] .
		  '</TD><TD>' . $row['Nazwa'] .
		   '</TD><TD style="color: red">' . $row['RodzajWZ'] .
		    '</TD><TD style="color: red">' . $row['Uwagi'] .
		    '</TD><TD>' . $row['Data_wyst'] .' '. $row['Czas_wyst'].
			'</TD></TR>'
  ;

}
	
$message .= 		'</table>';
$message .= '<p> <b>Zamówienia:</b></p>';
mysql_free_result($result);
$query  = ("SELECT * FROM Uwagi WHERE data = CURDATE() AND user_id= $operatorID");
$result = mysql_query($query)
    or die("Query failed");
while ($row = mysql_fetch_array($result)) {
$message .=  $row['Zamowienia'] . '<Br>';
}
$message .= '<p> <b>Uwagi:</b></p>';
mysql_free_result($result);
$query  = ("SELECT * FROM Uwagi WHERE data = CURDATE() AND user_id= $operatorID");
$result = mysql_query($query)
    or die("Query failed");
while ($row = mysql_fetch_array($result)) {
$message .=  $row['Uwagi'] . '<Br>';
}
$message .= '</body></html>';
mysql_free_result($result);
ob_end_flush();

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
$headers .= "From: dok@sklepkamil.pl" . "\r\n";
// Mail it
if (mail($to, $subject, $message, $headers))
 {
  ?>
     
         <div class="alertok">
			<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
			Prawidłowo wyłano e-mail z uwagami
		</div>
		<?php
 }
  else
 {
  ?>
        <div class="alert">
			<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
			Błąd, nie wysłano wiadomości e-mail
		</div>
        <?php
 }
}

?>
		