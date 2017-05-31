<?php

/**
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* @file cnmodule_content.php
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
* @package BlockModules
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* @subpackage CNImprintModule
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* @description
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* @note
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* @todo
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* @version 0.0.0-1
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* @author Cyberspace Networks <developer@cyberspace-networks.com>
* @license GNU General Public License
* @copyright Copyright (c) 2000-2015 Cyberspace Networks
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* The lastest version of Cyberspace Networks CoreSystem can be obtained from:
* https://github.com/CyberspaceNetworks/CoreSystem
* For questions, help, comments, discussion, etc. please visit
* http://www.cyberspace-networks.com
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
*/
?>

<h1><?=PA::$site_name?> <?= __("Imprint") ?></h1>
<p>Company informations:</p>
<table class="table table-striped table-hover ">
  <tbody>
    <tr>
      <td width="25%">Company:</td>
      <td width="75%"><?=PA::$site_company?></td>
    </tr>
    <tr>
      <td width="25%">CEO:</td>
      <td width="75%"><?=PA::$site_owner?></td>
    </tr>
    <tr>
      <td width="25%">Street:</td>
      <td width="75%"><?=PA::$site_company_street?></td>
    </tr>
    <tr>
      <td width="25%">Postal Code:</td>
      <td width="75%"><?=PA::$site_company_postalcode?></td>
    </tr>
    <tr>
      <td width="25%">City:</td>
      <td width="75%"><?=PA::$site_company_city?></td>
    </tr>
    <tr>
      <td width="25%">Country:</td>
      <td width="75%"><?=PA::$site_company_country?></td>
    </tr>    
  </tbody>
</table> 
<p>Company contakt:</p>
<table class="table table-striped table-hover ">
  <tbody>
    <tr>
      <td width="25%">FON:</td>
      <td width="75%"><?=PA::$site_company_fon?></td>
    </tr>
    <tr>
      <td width="25%">FAX:</td>
      <td width="75%"><?=PA::$site_company_fax?></td>
    </tr>
    <tr>
      <td width="25%">MAIL:</td>
      <td width="75%"><?=PA::$site_company_mail?></td>
    </tr>    
  </tbody>
</table> 
<p>Images and graphics:</p>
<table class="table table-striped table-hover ">
  <tbody>
    <tr>
      <td width="25%">AEBN:</td>
      <td width="75%"><a href="http://www.aebn.net/index.cfm?refid=AEBN067446&bannerid=7920&salesToolId=28">aebn.net</a></td>
    </tr>    
  </tbody>
</table> 
<!--
<h2>Registereintrag:</h2>
<p>Eintragung im Handelsregister. <br />Registergericht:Amtsgericht Musterstadt <br />Registernummer: AMS-999999</p>
<h2>Umsatzsteuer-ID:</h2>
<p>Umsatzsteuer-Identifikationsnummer gemäß §27 a Umsatzsteuergesetz:<br />
DE 999 999 999</p>
<h2>Aufsichtsbehörde:</h2>
<p>Landratsamt Musterstadt</p>
<h2>Verantwortlich für den Inhalt nach § 55 Abs. 2 RStV:</h2>
<p>Beate Beispielhaft<br />
<br />
Musterstraße 110<br />
Gebäude 33<br />
90210 Musterstadt</p>
-->