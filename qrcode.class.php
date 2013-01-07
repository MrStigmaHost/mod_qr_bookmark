<?php

// qrcode.class.php

// *************************************************************************
// *                                                                       *
// * (c) 2008-2010 Wolf Software Limited <info@wolf-software.com>          *
// * All Rights Reserved.                                                  *
// *                                                                       *
// * This program is free software: you can redistribute it and/or modify  *
// * it under the terms of the GNU General Public License as published by  *
// * the Free Software Foundation, either version 3 of the License, or     *
// * (at your option) any later version.                                   *
// *                                                                       *
// * This program is distributed in the hope that it will be useful,       *
// * but WITHOUT ANY WARRANTY; without even the implied warranty of        *
// * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the         *
// * GNU General Public License for more details.                          *
// *                                                                       *
// * You should have received a copy of the GNU General Public License     *
// * along with this program.  If not, see <http://www.gnu.org/licenses/>. *
// *                                                                       *
// *************************************************************************


class QrCode
{
  private $class_name    = "QrCode";
  private $class_version = "1.0.0";
  private $class_author  = "Wolf Software";
  private $class_source  = "http://www.wolf-software.com/Downloads/qrcode_class";

  private $data          = NULL;

  public function class_name()
    {
      return $this->class_name;
    }

  public function class_version()
    {
      return $this->class_version;
    }

  public function class_author()
    {
      return $this->class_author;
    }

  public function class_source()
    {
      return $this->class_source;
    }

  public function link($url)
    {
      if (preg_match('/^http:\/\//', $url) || preg_match('/^https:\/\//', $url)) 
        {
          $this->data = $url;
        }
      else
        {
          $this->data = "http://".$url;
        }
    }

  public function bookmark($title, $url)
    {
      $this->data = "MEBKM:TITLE:".$title.";URL:".$url.";;";
    }
    
  public function text($text)
    {
      $this->data = $text;
    }
    
  public function sms($phone, $text)
    {
      $this->data = "SMSTO:".$phone.":".$text;
    }
    
  public function phone_number($phone)
    {
      $this->data = "TEL:".$phone;
    }
    
  public function contact_info($name, $phone, $email, $url)
    {
      $this->data = "MECARD:N:".$name.";TEL:".$phone.";EMAIL:".$email.";URL:.".$url.";;";
    }

   public function business_card($first_name, $surname, $title, $company, $address, $phone, $email, $url)
    {
      $this->data = "BEGIN:VCARD|N:" . $first_name . ';' . $surname . "|ORG:" . $company . "|ADDRESS:" . $address . "|TITLE:" . $title . "|TEL:" . $phone . "|EMAIL:" . $email . "|URL:" . $url . "|END:VCARD";
    }


  public function email($email, $subject, $message)
    {
      $this->data = "MATMSG:TO:".$email.";SUB:".$subject.";BODY:".$message.";;";
    }

  public function geo($lat, $lon, $height)
    {
      $this->data = "GEO:".$lat.",".$lon.",".$height;
    }
    
  public function wifi($type, $ssid, $pass)
    {
      $this->data = "WIFI:S:".$ssid.";T:".$type.";P:".$pass.";;";
    }

  public function get_image($size = 150, $EC_level = 'L', $margin = '0')
    {
      $ch = curl_init();
      $this->data = urlencode($this->data); 
      curl_setopt($ch, CURLOPT_URL, 'http://chart.apis.google.com/chart');
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, 'chs='.$size.'x'.$size.'&cht=qr&chld='.$EC_level.'|'.$margin.'&chl='.$this->data);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HEADER, false);
      curl_setopt($ch, CURLOPT_TIMEOUT, 30);

      $response = curl_exec($ch);
      curl_close($ch);
      return $response;
    }
    
  public function get_link($size = 150, $EC_level = 'L', $margin = '0')
    {
      $this->data = urlencode($this->data); 
      return 'http://chart.apis.google.com/chart?chs='.$size.'x'.$size.'&cht=qr&chld='.$EC_level.'|'.$margin.'&chl='.$this->data;
    }
    
  public function download_image($file)
    {
      header('Content-Description: File Transfer');
      header('Content-Type: image/png');
      header('Content-Disposition: attachment; filename=QRcode.png');
      header('Content-Transfer-Encoding: binary');
      header('Expires: 0');
      header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
      header('Pragma: public');
      header('Content-Length: ' . filesize($file));
      ob_clean();
      flush();
      echo $file;
    }
}

?>
