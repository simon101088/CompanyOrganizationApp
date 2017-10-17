<?php
include_once 'dbconnect.php';
date_default_timezone_set('UTC');
$mag_z = array('00Magazyn','01Andrychow','02Kety','03Wadowice','04Sucha-Beskidzka','05Pasaz-AND');
$mag_d = array('00Magazyn','01Andrychow','02Kety','03Wadowice','04Sucha-Beskidzka','05Pasaz-AND');


for ( $mz = 1; $mz <= 6 ; $mz++ )
{
	for ( $md = 0; $md <= 6 ; $md++ )
	{
$query  = ("SELECT * FROM Dokumenty_MM WHERE Data_wyst = CURDATE() AND Export=0 AND MM_Mag_zrodlowy = '$mag_z[$mz]' AND MM_Mag_docelowy = '$mag_d[$md]'");
$result = mysql_query($query)
    or die("Query failed");
if (mysql_num_rows($result) > 0)


{
$export = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n"; 
$export .= "<ROOT xmlns='http://www.cdn.com.pl/optima/dokument'>";


$i = 0;
$LP = mysql_num_rows($result);
while ($row = mysql_fetch_array($result))
{   
	
	$data = date('Y-m-d H:i:s');
	$tblID[]=$row["ID"];
    $tblEAN[]=$row["EAN"];
    $tblkod[]=$row["KOD"];
	$tblnazwa[]=$row["Nazwa"];
	$tblmag_zro[]=$row["MM_Mag_zrodlowy"];
	$tblmag_doc[]=$row["MM_Mag_docelowy"];
	$tblData_wyst[]=$row["Data_wyst"];
	$tblUwagi[]=$row["Uwagi"];
}


$export = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n"; 
$export .= "<ROOT xmlns='http://www.cdn.com.pl/optima/dokument'>";
$export .= "<DOKUMENT>";
$export .= "<NAGLOWEK><GENERATOR>Comarch Opt!ma</GENERATOR><TYP_DOKUMENTU></TYP_DOKUMENTU><RODZAJ_DOKUMENTU></RODZAJ_DOKUMENTU><FV_MARZA>0</FV_MARZA><FV_MARZA_RODZAJ>0</FV_MARZA_RODZAJ><NUMER_PELNY></NUMER_PELNY><DATA_DOKUMENTU>$tblData_wyst[$i]</DATA_DOKUMENTU><DATA_WYSTAWIENIA>$tblData_wyst[$i]</DATA_WYSTAWIENIA><DATA_OPERACJI>$tblData_wyst[$i]</DATA_OPERACJI><TERMIN_ZWROTU_KAUCJI>$tblData_wyst[$i]</TERMIN_ZWROTU_KAUCJI><KOREKTA>0</KOREKTA><DETAL>0</DETAL><TYP_NETTO_BRUTTO>1</TYP_NETTO_BRUTTO><RABAT>0.00</RABAT>
<OPIS>$tblUwagi[$i]</OPIS><PLATNIK><KOD>!NIEOKREŚLONY!</KOD><NIP/><GLN/><NAZWA></NAZWA><ADRES><KOD_POCZTOWY></KOD_POCZTOWY><MIASTO></MIASTO><ULICA></ULICA><KRAJ/></ADRES></PLATNIK><ODBIORCA><KOD>!NIEOKREŚLONY!</KOD><NIP/><GLN/><NAZWA></NAZWA><ADRES><KOD_POCZTOWY></KOD_POCZTOWY><MIASTO></MIASTO><ULICA></ULICA><KRAJ/></ADRES></ODBIORCA><SPRZEDAWCA><NIP>551-101-86-99</NIP><GLN>0000000000000</GLN><NAZWA>F.H. Sklep Obuwniczo Przemysłowy KAMIL Tomasz Jarzyna</NAZWA><ADRES><KOD_POCZTOWY>34-120</KOD_POCZTOWY><MIASTO>Andrychów</MIASTO><ULICA>Garncarska 2A</ULICA><KRAJ>Polska</KRAJ></ADRES><NUMER_KONTA_BANKOWEGO/><NAZWA_BANKU/></SPRZEDAWCA><KATEGORIA><KOD/><OPIS/></KATEGORIA><PLATNOSC><FORMA>gotówka</FORMA><TERMIN>$tblData_wyst[$i]</TERMIN></PLATNOSC><WALUTA><SYMBOL>PLN</SYMBOL><KURS_L>1.00</KURS_L><KURS_M>1</KURS_M><PLAT_WAL_OD_PLN>0</PLAT_WAL_OD_PLN><KURS_NUMER>3</KURS_NUMER><KURS_DATA>$tblData_wyst[$i]</KURS_DATA></WALUTA><KWOTY><RAZEM_NETTO_WAL></RAZEM_NETTO_WAL><RAZEM_NETTO></RAZEM_NETTO><RAZEM_BRUTTO></RAZEM_BRUTTO><RAZEM_VAT></RAZEM_VAT></KWOTY>";
$export .= "
<MAGAZYN_ZRODLOWY>$mag_z[$mz]</MAGAZYN_ZRODLOWY>
<MAGAZYN_DOCELOWY>$mag_d[$md]</MAGAZYN_DOCELOWY>";
$export .= "
<KAUCJE_PLATNOSCI>0</KAUCJE_PLATNOSCI><BLOKADA_PLATNOSCI>1</BLOKADA_PLATNOSCI><VAT_DLA_DOK_WAL>0</VAT_DLA_DOK_WAL><TRYB_NETTO_VAT>0</TRYB_NETTO_VAT></NAGLOWEK><POZYCJE>";
	for ( $i = 0; $i < $LP ; $i++ )
	{
$export .= "<POZYCJA>
<LP></LP>
<TOWAR><KOD>$tblkod[$i]</KOD>
<NAZWA>$tblnazwa[$i]</NAZWA>
<OPIS></OPIS>
<EAN>$tblEAN[$i]</EAN>
<SWW/><NUMER_KATALOGOWY></NUMER_KATALOGOWY></TOWAR><STAWKA_VAT><STAWKA>23.00</STAWKA><FLAGA>2</FLAGA><ZRODLOWA>0.00</ZRODLOWA></STAWKA_VAT><CENY><POCZATKOWA_WAL_CENNIKA></POCZATKOWA_WAL_CENNIKA><POCZATKOWA_WAL_DOKUMENTU></POCZATKOWA_WAL_DOKUMENTU><PO_RABACIE_WAL_CENNIKA></PO_RABACIE_WAL_CENNIKA><PO_RABACIE_PLN></PO_RABACIE_PLN><PO_RABACIE_WAL_DOKUMENTU></PO_RABACIE_WAL_DOKUMENTU></CENY><WALUTA><SYMBOL>PLN</SYMBOL><KURS_L>1.00</KURS_L><KURS_M>1</KURS_M></WALUTA><RABAT>0.00</RABAT><WARTOSC_NETTO></WARTOSC_NETTO><WARTOSC_BRUTTO></WARTOSC_BRUTTO><WARTOSC_NETTO_WAL></WARTOSC_NETTO_WAL><WARTOSC_BRUTTO_WAL></WARTOSC_BRUTTO_WAL><ILOSC>              1.0000</ILOSC><JM>para</JM><JM_CALKOWITE>0.00</JM_CALKOWITE><JM_ZLOZONA><JMZ>para</JMZ><JM_PRZELICZNIK_L>1.00</JM_PRZELICZNIK_L><JM_PRZELICZNIK_M>1</JM_PRZELICZNIK_M></JM_ZLOZONA>
</POZYCJA>";
echo $i;
echo "----";
echo $tblID[$i];
echo "----";

mysql_query ("UPDATE Dokumenty_MM SET Export=1 WHERE id=$tblID[$i]");
mysql_query ("INSERT INTO `kacper7_cennik`.`Export` (`ID`, `EAN`, `KOD`, `data`)  VALUES ('','$tblEAN[$i]','$tblkod[$i]','$data')");

}

$export.="</POZYCJE><KAUCJE/><PLATNOSCI/><PLATNOSCI_KAUCJE/><TABELKA_VAT><LINIA_VAT><STAWKA_VAT><STAWKA>23.00</STAWKA><FLAGA>2</FLAGA><ZRODLOWA>0.00</ZRODLOWA></STAWKA_VAT>
<NETTO></NETTO><VAT></VAT><BRUTTO></BRUTTO><NETTO_WAL></NETTO_WAL><VAT_WAL></VAT_WAL><BRUTTO_WAL></BRUTTO_WAL></LINIA_VAT></TABELKA_VAT><ATRYBUTY/>
"; 
$export.="</DOKUMENT>";
$export .= "</ROOT>";


file_put_contents("MMxml/$tblData_wyst[0]-$mag_z[$mz]-$mag_d[$md].xml", $export);



echo $mag_z[$mz] . '->';
echo $mag_d[$md] . '-';
echo "<a href='MMxml/$tblData_wyst[0]-$mag_z[$mz]-$mag_d[$md].xml' target='_blank'>XML</a>";
	 	echo "<br>";
echo "<pre>";
print_r ($tblkod);
print_r ($tblnazwa);
unset($tblkod);
unset($tblnazwa);
unset($tblEAN);
unset($tblID);
mysql_free_result($result);
ob_end_flush();
echo "___________________________<br>";


}

}
}	



	

?> 