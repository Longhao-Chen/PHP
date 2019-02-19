<?php
/*
*用折线图显示CPU平均负载
*/
ob_start();
// 指定返回格式为 JSON 
if($_GET['sys']=="cpuone")
{
 header("Content-type: text/json"); 
 // 获取当前时间，PHP 时间戳是秒为单位的，JS 中则是毫秒，所以这里乘以 1000 
 $x = time() * 1000;
 $str = @file("/proc/loadavg");
 $str = explode(" ", implode("", $str));
 $str = array_chunk($str, 1);
 $y = implode(" ",$str[0]);
 $y = floatval($y);
 // 创建 PHP 数组，并最终用 json_encode 转换成 JSON 字符串 
 $ret = array($x, $y); 
 echo json_encode($ret); 
}else
if($_GET['sys']=="cpuf")
 {
  header("Content-type: text/json"); // 获取当前时间，PHP 时间戳是秒为单位的，JS 中则是毫秒，所以这里乘以 1000 
  $x = time() * 1000; // y 值为随机值 
  $str = @file("/proc/loadavg");
  $str = explode(" ", implode("", $str));
  $str = array_chunk($str, 4);
  $y = $str[0][1];
  $y = floatval($y);
  // 创建 PHP 数组，并最终用 json_encode 转换成 JSON 字符串 
  $ret = array($x, $y);
  echo json_encode($ret); 
}else
if($_GET['sys']=="cputf")
{
 header("Content-type: text/json"); // 获取当前时间，PHP 时间戳是秒为单位的，JS 中则是毫秒，所以这里乘以 1000 
 $x = time() * 1000; // y 值为随机值 
 $str = @file("/proc/loadavg");
 $str = explode(" ", implode("", $str));
 $str = array_chunk($str, 4);
 $y = $str[0][2];
 $y = floatval($y);
 // 创建 PHP 数组，并最终用 json_encode 转换成 JSON 字符串 
 $ret = array($x, $y);
 echo json_encode($ret); 
}
else{

?>
<!DOCTYPE HTML>
<meta charset="UTF-8" name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no,shrink-to-fit=no">
<html>
<head>
<script src="https://cdn.staticfile.org/jquery/3.2.1/jquery.min.js"></script>
<script src="https://img.hcharts.cn/highcharts/highcharts.js"></script>
<script src="https://img.hcharts.cn/highcharts/modules/exporting.js"></script>
<script src="https://img.hcharts.cn/highcharts-plugins/highcharts-zh_CN.js"></script>
</head>
<body>
<div id="container" style="min-width:400px;height:400px"></div>

<script>
var chart = null;
Highcharts.setOptions({
 global: 
 {
   useUTC: false;
 }
});

function activeLastPointToolip(chart) {
    var points = chart.series[0].points;
    chart.tooltip.refresh(points[points.length -1]);
}

var chart = Highcharts.chart('container', {
    chart: {
        type: 'line',
        marginRight: 10,
        events: {
            load: function () {
                setInterval(function () {
        $.ajax({ url:'sys.php?sys=cpuone',success: function(data) { 
        var series = chart.series[0], shift = series.data.length > 60;  
        series.addPoint(data, true, shift);
        } });
       
        $.ajax({ url:'sys.php?sys=cpuf',success: function(data) { 
        var series = chart.series[1], shift = series.data.length > 60;  
        series.addPoint(data, true, shift);
        } });
    
        $.ajax({ url:'sys.php?sys=cputf',success: function(data) { 
        var series = chart.series[2], shift = series.data.length > 60;  
        series.addPoint(data, true, shift);
        } });
                }, 1000); //更新时间，默认1000ms
            }
        }
    },
    title: {
        text: 'CPU平均负载'
    },
    xAxis: {
        type: 'time',
        tickPixelInterval: 150
    },

    yAxis: {
        title: {
            text: 'CPU平均负载'
        }
    },

plotOptions: {
        line: {
            dataLabels: {
                // 开启数据标签
                enabled: true
            },
            // 关闭鼠标跟踪，对应的提示框、点击事件会失效
            enableMouseTracking: false
        }
    },
    series: [{
        name: '1分钟CPU平均负载',
        data: []
    },{
    name:'5分钟CPU平均负载',
    data:[]
    },{
    name:'15分钟CPU平均负载',
    data:[]
    }]


});
</script>
    </body>
</html>
<?php } ?>