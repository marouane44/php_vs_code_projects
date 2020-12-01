<?php
function numberTowords($num)
{
    
    $ones = array(
        0 =>"ZERO",
        1 => "un",
        2 => "deux",
        3 => "trois",
        4 => "quatre",
        5 => "cinq",
        6 => "SIX",
        7 => "sept",
        8 => "huit",
        9 => "neuf",
        10 => "dix",
        11 => "onze",
        12 => "douze",
        13 => "treize",
        14 => "quatorze",
        15 => "quinze",
        16 => "seize",
        17 => "dix-sept",
        18 => "dix-huit",
        19 => "dix-neuf",
        "014" => "quatorze"
    );
    $tens = array(
        0 => "ZERO",
        1 => "dix",
        2 => "vingt",
        3 => "trente ",
        4 => "quarante ",
        5 => "cinquante",
        6 => "soixante",
        7 => "soixante-dix",
        8 => "quatre-vingts",
        9 => "quatre-vingt-dix"
    );
    $hundreds = array(
        "cent",
        "mille",
        "MILLION",
        "BILLION",
        "TRILLION",
        "QUARDRILLION"
    ); /*limit t quadrillion */
    $num = number_format($num,2,".",",");
    $num_arr = explode(".",$num);
    $wholenum = $num_arr[0];
    $decnum = $num_arr[1];
    $whole_arr = array_reverse(explode(",",$wholenum));
    krsort($whole_arr,1);
    $rettxt = "";
    foreach($whole_arr as $key => $i){
        
        while(substr($i,0,1)=="0")
            $i=substr($i,1,5);
            if($i < 20){
                /* echo "getting:".$i; */
                $rettxt .= $ones[$i];
            }elseif($i < 100){
                if(substr($i,0,1)!="0")  $rettxt .= $tens[substr($i,0,1)];
                if(substr($i,1,1)!="0") $rettxt .= " ".$ones[substr($i,1,1)];
            }else{
                if(substr($i,0,1)!="0") $rettxt .= $ones[substr($i,0,1)]." ".$hundreds[0];
                if(substr($i,1,1)!="0")$rettxt .= " ".$tens[substr($i,1,1)];
                if(substr($i,2,1)!="0")$rettxt .= " ".$ones[substr($i,2,1)];
            }
            if($key > 0){
                $rettxt .= " ".$hundreds[$key]." ";
            }
    }
    if($decnum > 0){
        $rettxt .= " and ";
        if($decnum < 20){
            $rettxt .= $ones[$decnum];
        }elseif($decnum < 100){
            $rettxt .= $tens[substr($decnum,0,1)];
            $rettxt .= " ".$ones[substr($decnum,1,1)];
        }
    }
    return $rettxt;
}
extract($_POST);
if(isset($convert))
{
    echo "<p align='center' style='color:blue'>".numberTowords("$num")."</p>";
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Conver Number to Words in PHP</title>
	</head>
	<body>
		<form method="post">
			<table border="0" align="center">
				<tr>
				<td>Enter Your Numbers</td>
				<Td><input type="text" name="num" value="<?php if(isset($num)){echo $num;}?>"/></Td>
				</tr>
				<tr>
				<td colspan="2" align="center">
				<input type="submit" value="Conver Number to Words" name="convert"/>
				</td>
				</tr>
			</table>
        </form> 

	</body>
</html>