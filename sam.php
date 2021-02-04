<?php //Connecting, selecting database;

$link = mysqli_connect('localhost','root','','metube');
//Send query
$query = 'SELECT * FROM Categories';
$result = mysqli_query($link, $query) or die("Query error: ". mysqli_error($link)."\n");
// Printing results in HTML
echo "<table>\n";
while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)){
echo "\t<tr>\n";
foreach($line as $col_value){
echo "\t\t<td>$col_value</td>\n";
}
echo "\t</tr>\n";
}
echo "</table>\n";
// Free resultset

?> 