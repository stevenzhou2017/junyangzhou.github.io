#!/usr/local/bin/perl
print "Content-type:text/html\n\n";

$fullpath="./";
$Host = $ENV{'REMOTE_HOST'};
$IP = $ENV{'REMOTE_ADDR'};
$ctime = time();
#open a file count.txt to read the counter number

open( COUNTREAD, "count.txt" );
   $data = <COUNTREAD>;
   $data++;
close( COUNTREAD );

open( COUNTWRITE, ">count.txt" );
   print COUNTWRITE $data;
close( COUNTWRITE );

open(INF,">>info.dat");

print INF "The visitor".$Host."\t the number is:".$data. "\tIP is:".$IP."\t Visiting time:".$ctime."\n";

close(INF);

print header;
print "<CENTER>";
print "<STRONG>You are the visitor number</STRONG><BR>";
print $data;


print "</CENTER>";

