<?php
session_start();
// security check, not annonymous allowed in here.
if (!isset($_SESSION["uid"])){
    header("Location: login.html?error=2");
}
include("../../webservices/connClass.php");
include ("../../webservices/dataService.php");
$module = "";
$module = @$_GET['m'];
$dataServ = null;
$dataServ = new dataService();	
require_once '../../dompdf/autoload.inc.php';
// reference the Dompdf namespace
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();
$id = 0;
$id = $_GET["id"];
function get_content($URL){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $URL);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

$content = get_content(''.$id);

$dompdf->loadHtml($content);
// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();

$filename = "";
$filename = "declaracionviajero.pdf";

// Output the generated PDF to Browser
$dompdf->stream();
$dompdf->stream($filename);
?>
