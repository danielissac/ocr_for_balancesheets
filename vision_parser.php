<?php
	$string = file_get_contents("visionjson.json"); //give the input file that contains json extracted from the balancesheet using google vision api
	$parsed = json_decode($string,true);
	$strcoord = "";
	$value=0;
	$x=0;
	$y1=0;
	$y2=0;
	$mixedarray = array();
	$scannedstring = "";
	$prevx=-1;
	$prevy1=0;
	$prevy2=0;
	foreach($parsed["textAnnotations"] as $textAnnotations)
	{
		$x = $textAnnotations["boundingPoly"]["vertices"][0]["x"];$y1=$textAnnotations["boundingPoly"]["vertices"][0]["y"];
		$y2=$textAnnotations["boundingPoly"]["vertices"][3]["y"];
		if(($prevx==-1 || ($prevx<$x && $prevy1==$y1 && $prevy2==$y2)) && ctype_digit($textAnnotations["description"])==false)
		{
			$scannedstring .= $textAnnotations["description"];
			$prevx = $x;
			$prevy1 = $y1;
			$prevy2 = $y2;
		}
		else
		{
			$scannedstring = preg_replace('/[^A-Za-z0-9]/', '',$scannedstring);
			if(ctype_digit($scannedstring)==false)
			{
				//echo "<br>";
				//echo $scannedstring;
				push_to_array1($scannedstring,$prevx,$prevy1,$prevy2);
			}
			$scannedstring = $textAnnotations["description"];
			$prevx = $textAnnotations["boundingPoly"]["vertices"][0]["x"];$prevy1=$textAnnotations["boundingPoly"]["vertices"][0]["y"];
			$prevy2=$textAnnotations["boundingPoly"]["vertices"][3]["y"];
		}
	}
			function push_to_array1($key,$passx,$passy1,$passy2)
			{
				$scannedstring = "";
				$value = "";
				$fprevx=-1;
				foreach($GLOBALS["parsed"]["textAnnotations"] as $textAnnotations)
				{
					$fx = $textAnnotations["boundingPoly"]["vertices"][0]["x"];$fy1=$textAnnotations["boundingPoly"]["vertices"][0]["y"];
					$fy2=$textAnnotations["boundingPoly"]["vertices"][3]["y"];
					if($passy1-10<$fy1 && $passy2>$fy2-10 && $passx<$fx)
					{
						$scannedstring = $textAnnotations["description"];
						if($scannedstring=="," ||$scannedstring=="." || $scannedstring=="$")
						{
							$value .= $scannedstring;
							continue;
						}
						if(ctype_digit($scannedstring))
						{
							$value .= $scannedstring;
							continue;
						}
						if(ctype_digit($scannedstring)==false)
							break;
					}
				}
				if($value!="" && $key!="")
					$GLOBALS["mixedarray"][$key] = $value;
			}
	echo "<br><br><br><br><br><br>";
	//print_r($mixedarray);
	foreach($mixedarray as $key=>$value)
		echo $key."=>".$value."<br>";
	
?>