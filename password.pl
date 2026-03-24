#!/usr/local/bin/perl

$fullpath="./";
$passwd = "2006IS";
$cpasswd = crypt($passwd, YL);

open (errorlog1, ">>$fullpath/output.txt") or &error("unable to write to output.txt");
print errorlog1 "password: $passwd | encrypted password: $cpasswd\n\n";
close(errorlog1);
