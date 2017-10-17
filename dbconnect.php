<?php
if(!mysql_connect("localhost","kacper7_cennik","123qwe"))
{
     die('oops connection problem ! --> '.mysql_error());
}
if(!mysql_select_db("kacper7_cennik"))
{
     die('oops database selection problem ! --> '.mysql_error());
}
mysql_query("SET NAMES 'utf8' COLLATE 'utf8_general_ci'");
?>