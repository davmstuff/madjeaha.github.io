<!DOCTYPE html>
<html>
<head>
<title>Page Title</title>
</head>
<body>

<h1>This is a Heading</h1>
<p>Graph de notation des activites.</p>
<script src="Chart.js"></script>

<canvas id="myChart" width="200" height="50"></canvas>
<script>
<?php
include_once('connection.php');

function fromRGB($R, $G, $B)
{
$R = dechex($R);
if (strlen($R)<2)
$R = '0'.$R;

$G = dechex($G);
if (strlen($G)<2)
$G = '0'.$G;

$B = dechex($B);
if (strlen($B)<2)
$B = '0'.$B;

return '#' . $R . $G . $B;
}


$sql_request = 
"SELECT * FROM  Sell_Story";
$stmt = $conn->prepare($sql_request);
$stmt->execute();
$db_data = $stmt->fetchAll();
$AllData = array();
$TotalSells = 0;
$str_Drinks = "";
$val_Sell = "";
$val_Quantity = "";
$str_Color = "";
foreach ($db_data as $data) 
{
$sell_info = new stdClass();
$sell_info->name = $data['Produit'];
$sell_info->format = $data['Format'];
$sell_info->quantity = $data['Vendu'];
$sell_info->sell = $data['Total'];
$color = new stdClass();
$color->red = rand(10,255);
$color->green = rand(10,255);
$color->blue = rand(10,255);
$sell_info->color = $color;

$TotalSells += $sell_info->sell;
$AllData[] = $sell_info;

$str_Drinks = $str_Drinks.'"'.$sell_info->name.' '.$sell_info->format.'",';
$str_Color = $str_Color.'"'.fromRGB($color->red, $color->green, $color->blue).'",';
$val_Sell = $val_Sell.$sell_info->sell.',';
$val_Quantity = $val_Quantity.$sell_info->quantity.',';
}
$str_Drinks = rtrim($str_Drinks,",");
$val_Sell = rtrim($val_Sell,",");
$val_Quantity = rtrim($val_Quantity,",");
?>
var ctx = document.getElementById("myChart");
var myChart = new Chart(ctx, {
    type: 'bar',
    data:
	{
        labels:
 		[
		],
        datasets:
		[
		<?php
		foreach($AllData as $data)
		{ ?>
		    {
                label: "<?php echo $data->name.' '.$data->format; ?>",
                backgroundColor: "rgba(<?php echo $data->color->red; ?>,<?php echo $data->color->green; ?>,<?php echo $data->color->blue; ?>,0.2)",
                borderColor: "rgba(<?php echo $data->color->red; ?>,<?php echo $data->color->green; ?>,<?php echo $data->color->blue; ?>,1)",
                borderWidth: 1,
                hoverBackgroundColor: "rgba(<?php echo $data->color->red; ?>,<?php echo $data->color->green; ?>,<?php echo $data->color->blue; ?>,0.4)",
                hoverBorderColor: "rgba(<?php echo $data->color->red; ?>,<?php echo $data->color->green; ?>,<?php echo $data->color->blue; ?>,1)",
                data: [<?php echo $data->sell; ?>]
		    },
  <?php } ?>
		]
    },
	options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        },
		responsive: true,
		legend: {
			position: 'top',
		},
		title: {
			display: true,
			text: 'Recette par boisson en $CAN'
		}
	}
});
</script>

<p>Graph d evolution du nombre de review dans le temps(pour voir a partir de quels evenements les reviews ont ete publies ).</p>

<canvas id="myChart2" width="200" height="50"></canvas>

<script>
var ctx2 = document.getElementById("myChart2");
var myLineChart2 = new Chart(ctx2, {
    type: 'bar',
    data:
	{
        labels:
 		[
		],
        datasets:
		[
		<?php
		foreach($AllData as $data)
		{ ?>
		    {
                label: "<?php echo $data->name.' '.$data->format; ?>",
                backgroundColor: "rgba(<?php echo $data->color->red; ?>,<?php echo $data->color->green; ?>,<?php echo $data->color->blue; ?>,0.2)",
                borderColor: "rgba(<?php echo $data->color->red; ?>,<?php echo $data->color->green; ?>,<?php echo $data->color->blue; ?>,1)",
                borderWidth: 1,
                hoverBackgroundColor: "rgba(<?php echo $data->color->red; ?>,<?php echo $data->color->green; ?>,<?php echo $data->color->blue; ?>,0.4)",
                hoverBorderColor: "rgba(<?php echo $data->color->red; ?>,<?php echo $data->color->green; ?>,<?php echo $data->color->blue; ?>,1)",
                data: [<?php echo $data->quantity; ?>]
		    },
  <?php } ?>
		]
    },
	options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        },
		responsive: true,
		legend: {
			position: 'top',
		},
		title: {
			display: true,
			text: 'Nombre de boisson vendu'
		}
	}
});

</script>
<p>Representation des activites les plus cote suivant le nombre de review</p>
<canvas id="myChart3" width="200" height="50"></canvas>
<script>

var ctx3 = document.getElementById("myChart3");
var data2 = {
    labels: [<?php echo "$str_Drinks"; ?>],
    datasets: [
        {
            data: [<?php echo "$val_Sell"; ?>],
            backgroundColor: [<?php echo "$str_Color"; ?>],
            hoverBackgroundColor: [<?php echo "$str_Color"; ?>]			
        }]
};

var myDoughnutChart = new Chart(ctx3, {
    type: 'doughnut',
    data: data2
});
</script>
</body>
</html>