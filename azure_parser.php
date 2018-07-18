<?php
	$string = file_get_contents("azurejson.json"); //give the input file that contains json extracted from the balancesheet using Microsoft's azure api
	$parsed = json_decode($string,true);
	//print_r($parsed);
	//print_r ($parsed["regions"][4]["lines"][14]["words"][0]["text"]);
	$strcoord = "";
	$flag=0;
	$assets_array = array();
	$liabilities_array = array();
	$equity_array = array();
	$current_assets_array = array();
	$non_current_assets_array = array();
	$current_liabilities_array = array();
	$non_current_liabilites_array = array();
	foreach($parsed["regions"] as $region)
	{
		foreach($region["lines"] as $line)
		{
			$scannedstring = "";
			foreach($line["words"] as $words)
			{
				$scannedstring .= " ".$words["text"];
			}
			$scannedstring = preg_replace('/[^A-Za-z0-9\-]/', '', $scannedstring);
			$scannedstring = str_replace("-","",$scannedstring);
			if(strpos(strtolower($scannedstring),"assets")!==false)
			{
				$flag=1;
				if(strpos(strtolower($scannedstring),"currentassets")!==false || strpos(strtolower($scannedstring),"shorttermassets")!==false)
				{
					$flag=4;
				}
				if(strpos(strtolower($scannedstring),"noncurrentassets")!==false || strpos(strtolower($scannedstring),"fixedassets")!==false||strpos(strtolower($scannedstring),"longtermassets")!==false || strpos(strtolower($scannedstring),"intangibleassets")!==false)
				{
					$flag=5;
				}
			}
			if(strpos(strtolower($scannedstring),"liabilities")!==false || strpos(strtolower($scannedstring),"liabilitiesandstockholdersequity")!==false)
			{
				$flag=2;
				if(strpos(strtolower($scannedstring),"currentliabilities")!==false || strpos(strtolower($scannedstring),"shorttermliabilities")!==false)
				{
					$flag=6;
				}
				if(strpos(strtolower($scannedstring),"noncurrentliabilities")!==false || strpos(strtolower($scannedstring),"longtermliabilities")!==false)
				{
					$flag=7;
				}
				}
			if(strpos(strtolower($scannedstring),"equity")!==false ||strpos(strtolower($scannedstring),"stockholders'equity")!==false)
			{
				$flag=3;
			}
			if($flag==1)
			{
				//echo "<br>pattern matched<br>";
				//echo $line["boundingBox"];
				$key = $scannedstring;
				$strcoord = $line["boundingBox"];
				push_to_array($key,$strcoord,$flag);
			}
			if($flag==2)
			{
				//echo "<br>pattern matched<br>";
				//echo $line["boundingBox"];
				$key = $scannedstring;
				$strcoord = $line["boundingBox"];
				push_to_array($key,$strcoord,$flag);
			}
			if($flag==3)
			{
				//echo "<br>pattern matched<br>";
				//echo $line["boundingBox"];
				$key = $scannedstring;
				$strcoord = $line["boundingBox"];
				push_to_array($key,$strcoord,$flag);
			}
			if($flag==4)
			{
				//echo "<br>pattern matched<br>";
				//echo $line["boundingBox"];
				$key = $scannedstring;
				$strcoord = $line["boundingBox"];
				push_to_array($key,$strcoord,$flag);
			}
			if($flag==5)
			{
				//echo "<br>pattern matched<br>";
				//echo $line["boundingBox"];
				$key = $scannedstring;
				$strcoord = $line["boundingBox"];
				push_to_array($key,$strcoord,$flag);
			}
			if($flag==6)
			{
				//echo "<br>pattern matched<br>";
				//echo $line["boundingBox"];
				$key = $scannedstring;
				$strcoord = $line["boundingBox"];
				push_to_array($key,$strcoord,$flag);
			}
			if($flag==7)
			{
				//echo "<br>pattern matched<br>";
				//echo $line["boundingBox"];
				$key = $scannedstring;
				$strcoord = $line["boundingBox"];
				push_to_array($key,$strcoord,$flag);
			}
		}
	}
			function push_to_array($key,$strcoord,$flag)
			{
				
				$value = "";
				$strcoordarr =	split(",",$strcoord);
				//echo "<br>";
				//echo $strcoordarr[0]." ".$strcoordarr[1];
				$strleft = (int)$strcoordarr[0];
				$strtop = (int)$strcoordarr[1];
				$strheight = (int)$strcoordarr[3];
				$strrange = $strtop + $strheight;
				$flag1=0;
				foreach($GLOBALS["parsed"]["regions"] as $region)
				{
					foreach($region["lines"] as $line)
					{
						$numcoord = $line["boundingBox"];
						$numcoordarr = split(",",$numcoord);
						$numtop = (int)$numcoordarr[1];
						$numleft = (int)$numcoordarr[0];
						if($strleft<$numleft && $numtop<$strrange && $numtop>=$strtop-10)
						{
							$flag1=1;
							$num = "";
							foreach($line["words"] as $words)
							{
								$num .= $words["text"];
							}
							$num = preg_replace('/[^A-Za-z0-9\-]/', '', $num);
							$value = $num;
							break;
						}
					}
					if($flag1==1)
						break;
				}
					if($flag==1)
					{
						if(is_numeric($value))
							$GLOBALS["assets_array"][$key] = $value;
					}
					if($flag==2)
					{
						if(is_numeric($value))
							$GLOBALS["liabilities_array"][$key] = $value;
					}
					if($flag==3)
					{
						if(!ctype_digit($key)&&is_numeric($value))
							$GLOBALS["equity_array"][$key] = $value;
					}
					if($flag==4)
					{
						if(!ctype_digit($key)&&is_numeric($value))
							$GLOBALS["current_assets_array"][$key] = $value;
					}
					if($flag==5)
					{
						if(!ctype_digit($key)&&is_numeric($value))
							$GLOBALS["non_current_assets_array"][$key] = $value;
					}
					if($flag==6)
					{
						if(!ctype_digit($key)&&is_numeric($value))
							$GLOBALS["current_liabilities_array"][$key] = $value;
					}
					if($flag==7)
					{
						if(!ctype_digit($key)&&is_numeric($value))
							$GLOBALS["non_current_liabilites_array"][$key] = $value;
					}
			}
			echo "assets<br>";
			print_r($assets_array);
			echo "<br><br>";
			echo "current assets<br>";
			print_r($current_assets_array);
			echo "<br><br>";
			echo "non_current_assets<br>";
			print_r($non_current_assets_array);
			echo "<br><br>";
			echo "liabilities<br>";
			print_r($liabilities_array);
			echo "<br><br>";
			echo "current_liabilities<br>";
			print_r($current_liabilities_array);
			echo "<br><br>";
			echo "non_current_liabilites<br>";
			print_r($non_current_liabilites_array);
			echo "<br><br>";
			echo "equity<br>";
			print_r($equity_array);
			include 'vision_parser.php'; //including the parsed result of Google vision api
			$new_assets_array = array();
			$new_current_assets_array = array();
			$new_non_current_assets_array = array();
			$new_liabilities_array = array();
			$new_current_liabilities_array = array();
			$new_non_current_liabilites_array = array();
			$new_equity_array = array();
			foreach($assets_array as $key => $value)
			{
				finalclassification($key,$value,1);
			}
			foreach($current_assets_array as $key => $value)
			{
				finalclassification($key,$value,2);
			}
			foreach($non_current_assets_array as $key => $value)
			{
				finalclassification($key,$value,3);
			}
			foreach($liabilities_array as $key => $value)
			{
				finalclassification($key,$value,4);
			}
			foreach($current_liabilities_array as $key => $value)
			{
				finalclassification($key,$value,5);
			}
			foreach($non_current_liabilites_array as $key => $value)
			{
				finalclassification($key,$value,6);
			}
			foreach($equity_array as $key => $value)
			{
				finalclassification($key,$value,7);
			}
			function finalclassification($key,$value,$flag2)
			{
				$max = 300;
				$orgkey="";
				$orgval="";
				foreach($GLOBALS["mixedarray"] as $key1 => $value1)
				{
					similar_text($key,$key1,$percent);
					if(60<$percent)
					{
						$max = $percent;
						$orgkey = $key1;
						$orgval = $value1;
						break;
					}
					$assetsval = levenshtein($key,$key1);
					if($max>abs($assetsval))
					{
						$max = $assetsval;
						$orgkey = $key1;
						$orgval = $value1;
					}
				}
				$value = preg_replace('/[^A-Za-z0-9]/', '',$value);
				$orgval = preg_replace('/[^A-Za-z0-9]/', '',$orgval);
				$orgkey = strtolower($orgkey);
				if(metaphone($key,4)===metaphone($orgkey,4))
				{
					if($flag2==1)
						$GLOBALS["new_assets_array"][$orgkey] = $value;
					if($flag2==2)
						$GLOBALS["new_current_assets_array"][$orgkey] = $value;
					if($flag2==3)
						$GLOBALS["new_non_current_assets_array"][$orgkey] = $value;
					if($flag2==4)
						$GLOBALS["new_liabilities_array"][$orgkey] = $value;
					if($flag2==5)
						$GLOBALS["new_current_liabilities_array"][$orgkey] = $value;
					if($flag2==6)
						$GLOBALS["new_non_current_liabilites_array"][$orgkey] = $value;
					if($flag2==7)
						$GLOBALS["new_equity_array"][$orgkey] = $value;
				}
			}
			echo "<br><br>The final output of the entire program <br> The accuracy of output might be vary depends on the balancesheet clarity"
			echo "<br>new_assets_array<br>";
			print_r($new_assets_array);
			echo "<br>new_current_assets_array<br>";
			print_r($new_current_assets_array);
			echo "<br>new_non_current_assets_array<br>";
			print_r($new_non_current_assets_array);
			echo "<br>new_liabilities_array<br>";
			print_r($new_liabilities_array);
			echo "<br>new_current_liabilities_array<br>";
			print_r($new_current_liabilities_array);
			echo "<br>new_non_current_liabilites_array<br>";
			print_r($new_non_current_liabilites_array);
			echo "<br>new_equity_array<br>";
			print_r($new_equity_array);
?>