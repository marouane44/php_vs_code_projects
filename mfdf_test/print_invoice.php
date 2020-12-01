<?php


function numberTowords($num)
{
    
    $f = new \NumberFormatter("fr", \NumberFormatter::SPELLOUT);
  
 return     $f ->format($num);
}




//print_invoice.php
if(isset($_GET["pdf"]) && isset($_GET["id"]))
{
 require_once 'pdf.php';
 include('database_connection.php');
 $output = '';
 $statement = $connect->prepare("
  SELECT * FROM tbl_order 
  WHERE order_id = :order_id
  LIMIT 1
 ");
 $statement->execute(
  array(
   ':order_id'       =>  $_GET["id"]
  )
 );
 $result = $statement->fetchAll();


 foreach($result as $row)
 {
  $output .= '
  <style>
  #footer p{
           margin: 0px;
        }
  
      </style>
  
  
  <div style="margin-left:-13px"
   >
     <table  style="margin-top: 0px;background-image: url(nmnmcm.png)" width="100%" border="1" cellpadding="5" cellspacing="0">
     
      <tr>
       <td colspan="2">
  
      <table width="100%" cellpadding="5">
         <tr>
          <td width="23%">
          <h2 style="margin-left: 27px;margin-bottom:0px;color:blue"> AFAYAD GROUPE </h2> <br />
           <p style="margin-top:-20px; font-size: 15px;color:blue">Etude-Pvention-Protection-Formation</p><br />
              <p style="margin-top:-38px;margin-left: 12px;color:blue">Matériel de Lutte Contre L incendie</p>
  <br />
            <p style="margin-top:-38px;margin-left: 39px;color:blue">Agree par les Assurances</p>
  <br />
           
          </td>
     <td width="5%">
  
  
  <img src="vvb.png">
  
  
  
         </td>
         <td width="33.5%" cellpadding="5" style="margin-top:-330px">
       <img src="nmnmm.png">
  
          </td>
         </tr>
        </table>
  
  
  
  
  
  
  
  
     <table  style="margin-top: 0px;" width="100%" border="1" cellpadding="5" cellspacing="0">
      <tr>
       <td colspan="2" align="center" style="font-size:18px"><b>Invoice</b></td>
      </tr>
      <tr>
       <td colspan="2">
        <table width="100%" cellpadding="5">
         <tr>
          <td width="65%">
           To,<br />
           <b>RECEIVER (BILL TO)</b><br />
           Name : '.$row["order_receiver_name"].'<br /> 
           Billing Address : '.$row["order_receiver_address"].'<br />
          </td>
          <td width="35%">
           Reverse Charge<br />
           Invoice No. : '.$row["order_no"].'<br />
           Invoice Date : '.$row["order_date"].'<br />
          </td>
         </tr>
        </table>
        <br />
        <table width="100%" border="1" cellpadding="5" cellspacing="0">
         <tr>
          <th>احمد</th>
          <th>Item Name</th>
          <th>Quantity</th>
          <th>Price</th>
          <th>Actual Amt.</th>
          <th colspan="2">Tax1 (%)</th>
          <th colspan="2">Tax2 (%)</th>
          <th colspan="2">Tax3 (%)</th>
          <th rowspan="2">Total</th>
         </tr>
         <tr>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th>Rate</th>
          <th>Amt.</th>
          <th>Rate</th>
          <th>Amt.</th>
          <th>Rate</th>
          <th>Amt.</th>
         </tr>';
    $statement = $connect->prepare(
     "SELECT * FROM tbl_order_item 
     WHERE order_id = :order_id"
    );
    $statement->execute(
     array(
      ':order_id'       =>  $_GET["id"]
     )
    );
    $item_result = $statement->fetchAll();
    $count = 0;
    foreach($item_result as $sub_row)
    {
     $count++;
     $output .= '
     <tr>
      <td>'.$count.'</td>
      <td>'.$sub_row["item_name"].'</td>
      <td>'.$sub_row["order_item_quantity"].'</td>
      <td>'.$sub_row["order_item_price"].'</td>
      <td>'.$sub_row["order_item_actual_amount"].'</td>
      <td>'.$sub_row["order_item_tax1_rate"].'</td>
      <td>'.$sub_row["order_item_tax1_amount"].'</td>
      <td>'.$sub_row["order_item_tax2_rate"].'</td>
      <td>'.$sub_row["order_item_tax2_amount"].'</td>
      <td>'.$sub_row["order_item_tax3_rate"].'</td>
      <td>'.$sub_row["order_item_tax3_amount"].'</td>
      <td>'.$sub_row["order_item_final_amount"].'</td>
     </tr>
     ';
    }
    $var3=$row["order_total_after_tax"];
    $output .= '
    <tr>
     <td align="right" colspan="11"><b>Total</b></td>
     <td align="right"><b>'.$row["order_total_after_tax"].'</b></td>
    </tr>
    <tr>
     <td colspan="11"><b>Total Amt. Before Tax :</b></td>
     <td align="right">'.$row["order_total_before_tax"].'</td>
    </tr>
    <tr>
     <td colspan="11">Add : Tax1 :</td>
     <td align="right">'.$row["order_total_tax1"].'</td>
    </tr>
    <tr>
     <td colspan="11">Add : Tax2 :</td>
     <td align="right">'.$row["order_total_tax2"].'</td>
    </tr>
    <tr>
     <td colspan="11">Add : Tax3 :</td>
     <td align="right">'.$row["order_total_tax3"].'</td>
    </tr>
    <tr>
     <td colspan="11"><b>Total Tax Amt.  :</b></td>
     <td align="right">'.$row["order_total_tax"].'</td>
    </tr>
    <tr>
     <td colspan="11"><b>Total Amt. After Tax :</b></td>
     <td align="right">'.$row["order_total_after_tax"].'</td>
    </tr>
     <tr>
     <td colspan="11" style="text-align: center; vertical-align: middle;"><b>Facture arretee a la somme de</b>      <br />
  
  <p>'.numberTowords($var3).'</p>
  </td>
   
    </tr>
  
    ';
    $output .= '
        </table>
       </td>
      </tr>
  
  <tr>
  <table  id="footer"   style="border-top-color: red">
           <tr>
              <td style="padding-right: 44px;
  ">
                 <p >26 Av ,Allal El Fassi</p>
                    <p>Bereau 30.4 eme Etage-</p>
           <p>Marrakech,c.p :40070</p>
           <p>www.afayadgroupe.com</p>
              </td>
              
              <td style="padding-right: 44px;
  ">
                 <p >Tel:05.24.30.83.34</p>
                    <p>GSM:06.63.63.08.08</p>
           <p>Fax:05.24.30.53.92</p>
           <p>afayadgroupe@hotmail.fr</p>
              </td>
                 <td style="padding-right: 44px;
  ">
                 <p >R.C:17437</p>
                    <p>Patente:45305248</p>
           <p>IF:06505761</p>
           <p>CNSS:76757449</p>
           <p>ICE001597032000031</p>
              </td>
              <td   style="padding-right: -23px;
  ">
                 <img  style="max-width: 130px" src="vvb.png" />
              </td>
           </tr>
        </table>
  
  </tr>
     </table>
  </div>

   
';
 }
 
 
 require_once __DIR__ . '/vendor/autoload.php';
 
 $mpdf = new \Mpdf\Mpdf();
 
 $mpdf->WriteHTML(utf8_encode($output));
 
 $mpdf->Output();

  
  
 
}
?>
