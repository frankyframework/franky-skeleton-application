<?php
use Base\model\Mailing;
$MyMailing          = new Mailing;
$busca_b	= $MyRequest->getRequest('busca_b');


$MyMailing->setTampag(10000);
$MyMailing->setOrdensql("fecha DESC");

$result	 		= $MyMailing->getData($busca_b);
$total			= $MyMailing->getTotal();

if($total > 0 && $MySession->LoggedIn())
{
    while($registro = $MyMailing->getRows())
    {

        $lista_admin_data[] = array_merge($registro,array(
             "fecha"         => getFechaUI($registro["fecha"]),
         ));

    }
}

header("Pragma: ");
header('Cache-control: ');
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0″, false");
header("Content-type: application/vnd.ms-excel");
header("Content-disposition: attachment; filename=".date('Y-m-d')."-contactanos.xls");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Contácto</title>
</head>

<body>
    <table width="100%" border="1" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
      <tr>
         <th width="" ><strong>Fecha</strong></th>
         <th width="" ><strong>Email</strong></th>
     </tr>
    </table>

<table width="100%" border="1" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
<?php foreach($lista_admin_data as $data): ?>
    <tr>


        <td align="center">
       		<?php echo $data["fecha"]; ?>
        </td>
     
         <td align="left">
        	<?php echo $data["email"];?>
       	</td>

     

	</tr>
    <?php endforeach; ?>

</table>
</body>
</html>
