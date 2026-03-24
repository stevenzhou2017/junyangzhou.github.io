<?
$num=file("count.txt"); // 讀取檔案
$w=fopen("count.txt","w"); // 設定寫檔的手柄
fputs($w,$num[0]+1); // 寫入人數
fclose($w); // 關閉檔案
echo $num[0]+1; // 印出瀏覽人數
?>