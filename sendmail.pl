#!/usr/local/bin/perl


$file="./maillist1.txt";

open(FHD, "$file") || die "can not read.\n";

while (my $line=<FHD>) {

	chomp $line;

        #($stuid,$Sendto,$mark,$mean,$std)=split(/\t/,$line);
        #($stuid,$Sendto,$result,$comment)=split(/\t/,$line);
        #($stuid,$Sendto,$result)=split(/\t/,$line);
	($stuid,$Sendto)=split(/\t/,$line);
	
    	print "Hello,$stuid, your email address is $Sendto,  $comment\n";

	$regard = "Best Regards";
	$signature = "Zhou Junyang";
	$address = "Mailing Address: R716, Department of Computer Science, Hong Kong Baptist University, KL, HK";
	$website = "Website: http://www.comp.hkbu.edu.hk/~jyzhou";
	
	$comment = "The new timeslot for section2 is 14:30-15:30pm, Wednesday (12, April, 2006), W802D.\nSince some students have time conflict in this timeslot, we arrange a special section: 9:30-11:30am, Wednesday, (12, April, 2006), W802D. Please be reminded.";
	#$comment1 = "If you use the command \"cl filename ws2_32.lib\" to compile the examples in our labs, please try to use the partition which has installed the VC and set the right path(right click \"my computer\" and press \"properties\", then click \"advanced\" and set the environment variables.\n append the following text in the path item:\"C:\\Program Files\\Microsoft Visual Studio\\Common\\Tools\\WinNT;C:\\Program Files\\Microsoft Visual Studio\\Common\\MSDev98\\Bin;C:\\Program Files\\Microsoft Visual Studio\\Common\\Tools;C:\\Program Files\\Microsoft Visual Studio\\VC98\\bin\"). \n\nI have asked the technicians to help us solve the problem in the lab of FSC801D.\n If you have any problem, please never mind to let know.";
	#$text = "Hello,$stuid,\nResult: $result \nComment:$comment\n\n\n$comment1 \n\n$regard \n\n$signature \n\n$address \n\n$website\n";
	$text = "Hello,$stuid,\n\n$comment\n\n\n$regard \n\n$signature \n\n$address \n\n$website\n";
        #$text1 = "Hello, $stuid:\n You are required to demo MP3. I will submit your marks to Dr. Chu this friday (20, may, 2005). If you have not demoed your MP3, I will give you ZERO mark in MP3. Please contact me to demo your work these days. \nYou can find me in my office. ";
	$form = "jyzhou\@comp.hkbu.edu.hk";
	$subject = "New timeslot for section2";
	#$subject1 = "reminder";
	sendmail($Sendto, $subject, $text, $from);

	#sendmail('jyzhou@comp.hkbu.edu.hk', 'hello world', 'text...', 'Support <support@perl.org.il>');
}

close(FHD);


sub sendmail {
  my ($recipient, $subject, $text, $fromfield) = @_;
  my $mailprog = "/usr/lib/sendmail";
 
  open MAIL, "| $mailprog -t -n -oi";
  print MAIL "To: $recipient\n";
  print MAIL "From: $fromfield\n";
  print MAIL "Reply-To: $fromfield\n";
  print MAIL "Subject: $subject\n";
  print MAIL "\n";
  print MAIL "$text";
 
  print MAIL "\n";
  close MAIL;
  return ;
 }             
