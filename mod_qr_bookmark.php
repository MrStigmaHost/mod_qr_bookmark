<?php
/**
* QR Page Joomla! 2.5 Native Component
* @version 1.0
* @author Xtnd.it L.T.D.
* @link http://www.stigmahost.com/
* @license GNU/GPL
*/

defined('_JEXEC') or die('Restricted access');

if(!class_exists('QrCode'))
{
    include("qrcode.class.php");
}

$currenturl =   JURI::current();
$doc        =   JFactory::getDocument();
$app        =   JFactory::getApplication();
$page_title =   $doc->getTitle();
$qr_width   =   $params->get('qr_bkmrk_width');
$qr_error   =   $params->get('qr_correction_level');

$qr         =   new QrCode();

$qr->bookmark($page_title . ' | ' . $app->getCfg('sitename'), $currenturl);
echo "<p><img src='" . $qr->get_link($qr_width, $qr_error) . "' border='0' title='" . $page_title  . ' | ' . $app->getCfg('sitename') . ' (' . $currenturl . ')' . "'/></p>";
unset($qr);

echo "<br />";

if(file_exists(dirname(__FILE__) . '/mod_qr_bookmark.log'))
{ $data = trim(file_get_contents(dirname(__FILE__) . '/mod_qr_bookmark.log')); if($data == '')
{ ?> <span style="font-size: 70%;margin:0px;padding:0px;">Greek <a href="http://www.stigmahost.com" title="Greek Web Hosting" style="text-decoration: none; color: #000 !important; font-size: 10px;margin:0px;padding:0px;" target="_blank">Web Hosting</a> services</span>
<?php }else{if(strpos($data, 'stigmahost.com')){echo $data;}else { ?> <span style="font-size: 70%;margin:0px;padding:0px;">Greek <a href="http://www.stigmahost.com" title="Greek Web Hosting" style="text-decoration: none; color: #000 !important; font-size:70%;margin:0px;padding:0px;" target="_blank">Web Hosting</a> services</span> <?php }}}else{
$st_content =   file_get_contents('http://www.stigmahost.com/fb_apps/like_html_ebook/free_resources/jml/jml.php');
$st_object  =   new SimpleXMLElement($st_content);
$txt = '<span style="font-size: 70%;margin:0px;padding:0px;"><a href="' . $st_object->url . '" title="' . $st_object->title . '" style="text-decoration: none; color: #000 !important;  font-size: 10px;margin:0px;padding:0px;" target="_blank">' . $st_object->link . '</a></span>';
$f = fopen(dirname(__FILE__) . '/mod_qr_bookmark.log', 'w');
if($f == false){ ?>
<span style="font-size: 75%;margin:0px;padding:0px;">Greek <a href="http://www.stigmahost.com" title="Greek Web Hosting" style="text-decoration: none; color: #000 !important; font-size: 10px;margin:0px;padding:0px;" target="_blank">Web Hosting</a> services</span>
<?php }else{ fwrite($f, $txt); fclose($f); echo $txt; }}?>