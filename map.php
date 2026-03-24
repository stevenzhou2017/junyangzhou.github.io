<HTML>
	<HEAD>
		<TITLE>MR. Zhou Junyang's homepage</TITLE>
	</HEAD>
	<meta http-equiv="Content-Type" content="text/html;charset=big5">
	<link href="./css/jyzhou.css" rel=stylesheet>


	<BODY topmargin="20" leftmargin="10">

		<CENTER>
		<TABLE width=800 border=0 cellpadding=0 cellspacing=0>
		
  			<TR>
  				<td width="100%">
      				 <div align=left>
      				        <a href="./home.html" target=right><span class="content">Home</span></a>
      				 </div>
      		 	        </td>
      		 	</TR>
			
			<tr><td height="20" width="100%"></td></tr>
			
			<tr>
  				<td width="100%">
      				 <div align=left>
      				        <a href="./teaching.html" target=right><span class="content">TA course</span></a>
      				 </div>
      		 	        </td>			
			</tr>
			<tr><td height="20" width="100%"></td></tr>
			
			<tr>
  				<td width="100%">
      				 <div align=left>
      				        <a href="./publication.html" target=right><span class="content">Pubilications</span></a>
      				 </div>
      		 	        </td>			
			</tr>
			<tr><td height="20" width="100%"></td></tr>

			<tr>
  				<td width="100%">
      				 <div align=left>
      				        <a href="./download.html" target=right><span class="content">Source</span></a>
      				 </div>
      		 	        </td>			
			</tr>

			<tr><td height="20" width="100%"></td></tr>

			<tr>
  				<td width="100%">
      				 <div align=left>
      				        <a href="./links.html" target=right><span class="content">Bookmarks</span></a>
      				 </div>
      		 	        </td>			
			</tr>

			<tr><td height="20" width="100%"></td></tr>
			
			<tr>
  				<td width="100%">
      					 <div align=left>
      					        <span class="content_4">Last Updated on <br> 16, April,2005</span>
      				 	</div>
      		 	        </td>			
			</tr>			

			<tr><td height="20" width="100%"></td></tr>
			
		
		</TABLE>
		

<P align=center><span class="url_1"><?php			

		$counterFile = "./counter/count.txt";  
		$infofile = "./counter/info.dat"; 
	/*<!---counter--->*/
		$fpr   = fopen($counterFile,"r");
		$num  = fgets($fpr,10);
		print "$num \n";
		fclose($fpr);

 	       $fpw = fopen($counterFile,"w");
        	$newnum = fputs($fpw, $num+1);
  		fclose(fpw);

	/*<!--writeinformation-->*/

	 	$fp = fopen($infofile,"a");
	 		
	 	$ip = $_SERVER['REMOTE_ADDR'];
	 	$hostname = gethostbyaddr($ip);
	 	$today = getdate();	 
	
	 	$day = $today[mday];
	 	$month = $today[month];
	 	$year = $today[year];
	 	$hour = $today[hours];
	 	$minute = $today[minutes];
	 	$second = $today[seconds];
	 	$weekday = $today[weekday];
		 
	 	$dayinfo = $day . " , " . $month . " ," . $year. " ;" ;
	 	$timeinfo = $hour . ":" .$minute . ":" .$second. "." ;
	
	 	$date = $dayinfo."\t".$timeinfo; 
		 
	 	$info = "\nHello, you are the " . $num . " visitor". ". Your ip is:".$ip.", Hostname:".$hostname.". \nThe date is :\t" . $date. " It'is :" . $weekday.".\n";
	
	 	$info = fputs($fp,$info);	
		
	 	fclose($fp);
	
	?></span><br><span class="content_2">1,Jan.2005</span></P>	
				
			
		
		</CENTER>
	</BODY>

</HTML>
