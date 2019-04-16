<?php
define('ga_email','sytyos1@gmail.com');
define('ga_password','dre030616');
define('ga_profile_id','57656470');

require 'gapi.class.php';

$ga = new gapi(ga_email,ga_password);
$filter = 'country == Mexico && browser == Firefox || browser == Chrome';



$ga->requestReportData(ga_profile_id,array('browser','browserVersion'),array('pageviews','visits'),'-visits',$filter);
?>
<table>
<tr>
  <th>Browser &amp; Browser Version</th>
  <th>Pageviews</th>
  <th>Visits</th>
</tr>
<?php
$pr = 0;
foreach($ga->getResults() as $result):
#if (strstr($result,'Chrome')) $cr++;
 $pr = $pr + $result->getPageviews();
?>
<tr>
  <td><?php echo $result ?></td>
  <td><?php echo $result->getPageviews() ?></td>
  <td><?php echo $result->getVisits() ?></td>
</tr>
<?php
endforeach;
echo $pr;
?>
</table>
<br />
<table>
<tr>
  <th>Total Results</th>
  <td><?php echo $ga->getTotalResults() ?></td>
</tr>
<tr>
  <th>Total Pageviews</th>
  <td><?php echo $ga->getPageviews() ?>
</tr>
<tr>
  <th>Total Visits</th>
  <td><?php echo $ga->getVisits() ?></td>
</tr>
<tr>
  <th>Results Updated</th>
  <td><?php echo $ga->getUpdated() ?></td>
</tr>
</table>
