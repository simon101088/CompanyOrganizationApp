
<?php  
 $connect = mysqli_connect("localhost","kacper7_cennik","123qwe");  

 include ("PHPExcel/IOFactory.php");  
 $html="<table border='1'>";  
 $objPHPExcel = PHPExcel_IOFactory::load('cennik.xls');  
 foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)   
 {    
      $highestRow = $worksheet->getHighestRow();  
      for ($row=2; $row<=$highestRow; $row++)  
      {  
           $html.="<tr>";  
           $kod = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(0, $row)->getValue());  
           $nazwa = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(1, $row)->getValue());  
		   $grupa = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(2, $row)->getValue()); 
		   $ean = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(3, $row)->getValue());
$cenaAKWS = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(4, $row)->getValue());
	$walAKWS = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(5, $row)->getValue());
$cenaBAZ = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(6, $row)->getValue());
$walBAZ = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(7, $row)->getValue());	
$ID = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow(8, $row)->getValue());
			
           $sql = "INSERT INTO kacper7_cennik .Cennik (`Kod`, `Nazwa`, `Grupa`, `EAN`, `Cena A,K,W,S`, `Waluta Cena A,K,W,S`, `Cena bazowa`, `Waluta Cena bazowa`, `ID`) VALUES ('".$kod."', '".$nazwa."', '".$grupa."', '".$ean."', '".$cenaAKWS."', '".$walAKWS."', '".$cenaBAZ."', '".$walBAZ."', '".$ID."')";  
           $nam = "SET NAMES 'utf8' COLLATE 'utf8_general_ci'";
		   mysqli_query($connect, $nam);  
		   mysqli_query($connect, $sql);  
		   
           $html.= '<td>'.$kod.'</td>';  
           $html .= '<td>'.$ID.'</td>';  
           $html .= "</tr>";  
      }  
 }  
 $html .= '</table>';  
 echo $html;  
 echo '<br />Data Inserted';  
 ?>  
