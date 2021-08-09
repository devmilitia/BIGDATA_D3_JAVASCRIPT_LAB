<?php
include("mysqli.inc.php");
	
$link = mysqli_connect($cfg_servidor,$cfg_usuario,$cfg_password,$cfg_basephp1);
mysqli_set_charset($link,"utf8");
$sql = "SELECT DISTINCT `departamento`, COUNT(`departamento`) FROM `registro_nacional_de_accidentes_de_transito_formatocsv` GROUP BY `departamento` ORDER BY `departamento` ASC;";
//$_ausentismo_mes = mysqli_query($link,$sql);
$_transito = mysqli_query($link,$sql);

$i=0;

while ( $rows = $_transito->fetch_assoc() ) {
    //print_r($rows);//echo "{$row['field']}"; //impresion plana del arreglo que arroja la consulta MYSQL
	$data[$i] = $rows;
	$i++;
}

//echo "<pre>".print_r($data,true)."</pre>"; //impresion formateada del arreglo que arroja la consulta MYSQL
//            [departamento] => ANTIOQUIA
//            [COUNT(`departamento`)] => 54701
?>
<html>
<head>
<!-- Load c3.css -->
<link href="c3-0.6.7/c3.css" rel="stylesheet">

<!-- Load d3.js and c3.js -->
<script src="d3/d3.min.js" charset="utf-8"></script>
<script src="c3-0.6.7/c3.min.js"></script>
</head>
<body>
<div id="chart"></div>
<script>
var i;
var chart = c3.generate({
    data: {
        columns: [
            ['data1', 
			//30, 200, 100, 400, 150, 250
		<?php
		echo $data[0]['COUNT(`departamento`)'].",";
		$arr_length = count($data)-1;
        for($i=1;$i<$arr_length;$i++)
        {
	      echo $data[$i]['COUNT(`departamento`)'].",";
        }
		echo $data[$i]['COUNT(`departamento`)'];?>
		    ]
        ],
        types: {
            data1: 'bar',
        }
    },
    axis: {
        rotated: true,
      x: {
        tick: {
        multiline: false
        },
		height: 100,
        type: 'category',
        categories: 
		[
		<?php
		echo "'".$data[0]['departamento']."',";
		$arr_length = count($data)-1;
        for($i=1;$i<$arr_length;$i++)
        {
	      echo "'".$data[$i]['departamento']."',";
        }
		echo "'".$data[$i]['departamento']."'";?>
		]
      },
      y: {
        label: { // ADD
          text: 'Número de Eventos',
          position: 'outer-middle'
        }
      }
    }
});
</script>
</body>
</html>