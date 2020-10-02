<?php
//custom wordpress importer script
//The script objective is to be able to import a database from a custom CMS to wordpress.
//This script imports all the pictures from the old media folder of the Custom CMS (the photos are not actually registered as pictures on the wordpress database)  to be displayed as an external url Picture.
//This script requires the plugin Featured image by URL by Kawat Team github.com/Knawat

//Config

//WP database we are manipulating posts.
$server = '';
$username = '';
$password = '';
$database = '';
$meta_id = '';
$media_url = ''; // Media Folder Location
//Behaivor.

$amount = '2000'; //Amount of posts to be imported per iteration. You can configure the amount of posts depending on what your server can handle.
$from = '0'; //Starting Amount. 

//1st step - Insert all the data from the we have on postmeta to the wp_posts table. We will use the wp_postmeta ID and we make sure to select the 

$query = "SELECT * from wp_postmeta where meta_key = '".$meta_id."' order by meta_id desc limit $from, $amount";

$connect = mysqli_connect($server, $username, $password, $database);
if(!$connect) {
echo "Can't make connection, Error No. ".mysqli_connect_errno()."";
}
else {
echo "Datbase connection, Success!";

}

$result = $connect->query($query);
while($row=$result->fetch_assoc())
{
if ($row['meta_value'] == "")
{
//jump result and dont insert anything	
}
else {
$insert = "insert into wp_postmeta (post_id, meta_key, meta_value) VALUES ($row[post_id], '_knawatfibu_url', 'https://$media_url/$row[meta_value]')";
$connect->query($insert);
print $insert;
echo "<br>";
echo "Query submitted. <br>";
}
}