<?php 
/*
*动态生成指定目录的文件列表
*/
$title='标题';//此界面的标题
$expl='说明';//此界面的说明
$pwd='.';//扫描目录
$pcname=array("要被排除的文件","index.html");//要被排除的文件或目录
?>
<!DOCTYPE html><meta charset="UTF-8" name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
<html>
<head>
<link href="/css/styles.css" rel="stylesheet">
<title><?php echo $title ?></title>
<link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/4.1.0/css/bootstrap.min.css">
<script src="https://cdn.staticfile.org/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdn.staticfile.org/popper.js/1.12.5/umd/popper.min.js"></script>
<script src="https://cdn.staticfile.org/twitter-bootstrap/4.1.0/js/bootstrap.min.js"></script>
</head>
<body class="container-fluid">
<center> 
<?php
@header("content-Type: text/html; charset=utf-8");
function pc($name,$pcname)//检测文件是否需要排除
{
    if(count($pcname)!=0)
    {
     $arrlength=count($pcname);
     for($x=0;$x<$arrlength;$x++)
     {
      if($pcname[$x]==$name)
      {
       return 0;
       break;
      }
     }
     return 1;
    }else
    {
     return 1;
    }
}

echo "<br><h1>$title</h1>";

if($expl=='')//判断是否有界面说明
{
 echo '<hr>';
}else
{
 echo '<hr>';
 echo $expl; //显示说明
 echo "<hr>";
}
$d=dir($pwd);
while(false !== ($e= $d->read()))
{
 if(($e!==".")&&($e!=="..")&&($e!=="index.php")&&(pc($e,$pcname)==1))
 {
  if(is_dir($e))
  {
   $basee=rawurlencode($e);
   echo "<a class='btn btn-ligtht' href=$basee/ >$e/</a>"."<br>";
  }
  else
  {
   $basee=rawurlencode($e);
   echo "<a class='btn btn-ligtht' href=$basee >$e</a>"."<br>";
  }
 }
}
$d->close();
?>
</body>