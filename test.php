<HTML>
	<HEAD>
		<TITLE>MR. Zhou Junyang's homepage</TITLE>
	</HEAD>
	<meta http-equiv="Content-Type" content="text/html;charset=big5">
	<link href="./css/jyzhou.css" rel=stylesheet>

	<BODY>
		<CENTER>

		<p>This is a test page.</p>

		<img src=./images/0.gif>
		<img src=./images/1.gif>
		<img src=./images/2.gif>
		<img src=./images/3.gif>
		<img src=./images/4.gif>
		<img src=./images/5.gif>
		<img src=./images/6.gif>
		<img src=./images/7.gif>
		<img src=./images/8.gif>
		<img src=./images/9.gif>
		
		
		<p>hello</p>
		
<!--
/*
<?php			

	$counterFile = "/u/pg/jyzhou/public_html/counter/count.txt";  

	$infofile = "/u/pg/jyzhou/public_html/counter/info.txt"; 
	
	
	function displayCounter($counterFile) 
	{
  		$fpr   = fopen($counterFile,"r");
  		$num  = fgets($fpr,10);
  		
  		print "$num \n";
  		
  		
  		print strlen($num);
  		
  		
  		for ( $i=0; $i < strlen( $num ); $i++ )
		{
   			$number = substr( $num, $i, 1 );
   			echo "<img src=./images/$number.gif>";
		}
  		
  		  		
  		
		$num = $num+1;
		fclose(fpr);

                $fpw = fopen($counterFile,"w");
                $newnum = fputs($fpw, $num);
  	
	   	fclose(fpw);
	   	
	   	
	   	
	   	
	}


	displayCounter($infofile);
  	

?>
		
*/

-->		
	<?php
				$num=file("/u/pg/jyzhou/public_html/counter/info.txt"); // 讀取檔案
				$w=fopen("/u/pg/jyzhou/public_html/counter/info.txt","w"); // 設定寫檔的手柄
				print "$num[0] \n"; 
				fputs($w,$num[0]); // 寫入人數
				fclose($w); // 關閉檔案
                                print "$num[0] \n" ;
				echo $num[0]+1; // 印出瀏覽人數
				
				
				 $ip = $_SERVER['REMOTE_ADDR'];
				 $goodip = "127.0.0.1";
  				
 		 		$hostname = gethostbyaddr($ip);
 		 
 		 
 				$date = getdate();

				$pwd = getcwd();
				echo "$pwd \n";
				echo "$ip \n";
				
				$day = $date[mday];
				$month = $date[month];
				$year = $date[year];
				$hour = $date[hours];
				$minute = $date[minutes];
				$second = $date[seconds];
				$weekday = $date[weekday];
				
				/*print "Hello, Welcome,"."It's" . $day . "," . $month . "," . $year. "." . "The time is" . $hour . ":" $minute . ":" . $second ;
				*/
				
					print "date";
				print "$date";
				print "time";
				echo "$date[0] \n";
				print "he";
				echo "$second \n";
				echo "$minute \n";				
				echo "$hour \n";
				echo "$day \n";	
				echo "$month \n";	
				print "haha";			
				echo "$year \n";
				echo "$weekday \n";				
			
			        print "date";
				print $day . " , " . $month . "," . $year. "." ;
			        
			        $dayinfo = $day . " , " . $month . "," . $year. "." ;
			        print "time \n";
			        
			        $timeinfo = $hour . ":" .$minute . ":" .$second. "." ;
			        print $hour . ":" .$minute . ":" .$second. "." ;
			        
				echo "$ip \n";
		
				echo "$hostname \n";		
				echo $dayinfo.$timeinfo;	
	?>				
	
		</CENTER>
	</BODY>

</HTML>
