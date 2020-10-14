<?php
$json = file_get_contents('https://polisen.se/api/events');
$obj = json_decode($json);
$stack = array();
$count = array();
 ?>


<html>
<head>
  <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
<link href="style.css?version=30" type="text/css" rel="stylesheet">
<script src="Chart.min.js"></script>
<script src="utils.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/list.js/1.5.0/list.min.js"></script>

</head>
<body>
<a href="landingpage.html" class="Home">Hem</a>
  <div id="test-list">
    <div class="header">
    <h1 id="header">Senaste 500 Händelser</h1>
    </div>
    <center>
      <a href="#myChart" id='goToCircleDiag'>Cirkel Diagram</a>
      <h4 id="searchH">Sök plats</h4>
      <input type="text" class="search" />
    </center>
      <ul class="list">
<?php
foreach($obj as $key => $value) {
   str_replace(' ', '', $value->location->name);
   if(!in_array($value->location->name,$stack,true)){
     array_push($stack,$value->location->name);

   }
   else if(in_array($value->location->name,$stack,true)){
        array_push($stack,$value->location->name);
   }
   echo "<li>";
   echo "<div class='event'>";
   echo "<h4>".$value->type."</h4>";
   
   echo "<h4 class='name'>".$value->location->name."</h4>";

   echo "<h6>".$value->datetime."</h6>";

   echo "<p>".$value->summary."</p>";
   echo "<a href='" . $value->url . "' id='goToEvent'>Gå till händelse</a>";
echo "</div>";
echo "</li>";

 }

?>
</ul>
<ul class="pagination"></ul>
</div>



<script>
var monkeyList = new List('test-list', {
  valueNames: ['name'],
  page: 4 ,
  pagination: true
});
</script>


<div class="chartParent">
<canvas id="myChart" width="400" height="400"></canvas>
</div>
<script>
var phpLabels = [];
var phpData = [];
var phpBackgroundColors = [];
var phpBorderColors = [];
<?php
$new_array=array_count_values($stack);
arsort($new_array);
while (list ($key, $val) = each ($new_array)) {
$rand1 = rand(1,255);
$rand2 = rand(1,255);
$rand3 = rand(1,255);
?>

phpData.push('<?php echo $val;?>');
phpLabels.push('<?php echo $key;?>');
phpBackgroundColors.push('<?php echo "rgba($rand1,$rand2,$rand3,1)"?>');
phpBorderColors.push('<?php echo "rgba($rand1,$rand2,$rand3,0.2)"?>');
<?php }?>
var ctx = document.getElementById('myChart');
var myChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels:[] = phpLabels,


        datasets: [{
            data: [] = phpData,
            backgroundColor:[]=phpBackgroundColors,
            borderColor:[]=phpBorderColors,
            borderWidth: 3,
            barThickness:10
        }]
    },
    options: {
        legend:{
          display:false
        },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});


</script>
</body>
</html>
