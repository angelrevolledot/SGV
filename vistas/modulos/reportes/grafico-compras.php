<?php

error_reporting(0);

if(isset($_GET["fechaInicial"])){

    $fechaInicial = $_GET["fechaInicial"];
    $fechaFinal = $_GET["fechaFinal"];

}else{

$fechaInicial = null;
$fechaFinal = null;

}

$respuesta = ControladorCompras::ctrRangoFechasCompras($fechaInicial, $fechaFinal);

$arrayFechas = array();
$arrayCompras = array();
$sumaPagosMes = array();

foreach ($respuesta as $key => $value) {

	#Capturamos sólo el año y el mes
	$fecha = substr($value["fecha"],0,7);

	#Introducir las fechas en arrayFechas
	array_push($arrayFechas, $fecha);

	#Capturamos las compras
	$arrayCompras = array($fecha => $value["total"]);

	#Sumamos los pagos que ocurrieron el mismo mes
	foreach ($arrayCompras as $key => $value) {
		
		$sumaPagosMes[$key] += $value;
	}

}


$noRepetirFechas = array_unique($arrayFechas);


?>

<!--=====================================
GRÁFICO DE VENTAS
======================================-->


<div class="box box-solid bg-teal-gradient">
	
	<div class="box-header">
		
 		<i class="fa fa-th"></i>

  		<h3 class="box-title">Gráfico de Compras</h3>

	</div>

	<div class="box-body border-radius-none nuevoGraficoCompras">

		<div class="chart" id="line-chart-compras" style="height: 250px;"></div>

  </div>

</div>

<script>
	
 var line = new Morris.Line({
    element          : 'line-chart-compras',
    resize           : true,
    data             : [

    <?php

    if($noRepetirFechas != null){

	    foreach($noRepetirFechas as $key){

	    	echo "{ y: '".$key."', compras: ".$sumaPagosMes[$key]." },";


	    }

	    echo "{y: '".$key."', compras: ".$sumaPagosMes[$key]." }";

    }else{

       echo "{ y: '0', compras: '0' }";

    }

    ?>

    ],
    xkey             : 'y',
    ykeys            : ['compras'],
    labels           : ['compras'],
    lineColors       : ['#efefef'],
    lineWidth        : 2,
    hideHover        : 'auto',
    gridTextColor    : '#fff',
    gridStrokeWidth  : 0.4,
    pointSize        : 4,
    pointStrokeColors: ['#efefef'],
    gridLineColor    : '#efefef',
    gridTextFamily   : 'Open Sans',
    preUnits         : '$',
    gridTextSize     : 10
  });

</script>
