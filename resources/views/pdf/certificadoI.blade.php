<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title></title>
	<style>
     
	body {
		background-image: url("../public/Imagen1.png");
		background-repeat: no-repeat;
        background-attachment: fixed;
        background-position: center center;
        background-size: 100%;
    
    } 
	#cert {
  width: 75%;
  margin: 5% ;
}
	#inner {
  width: 90%;
  margin: 0% auto;
}

footer {
  
  margin: 5% ;
  width: 100%;
  height: 30px;
  text-align: left;
}
	</style>
</head>
<body>

	
     
	<div id="outer" >
		<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
		
		<div id="cert" >
			<h1>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				A: {{ $users->registration->participant->user->full_name}}</h1>
		</div>
		<div id="inner" >
			Por haber aprobado el curso de capacitación de: <b>{{ $users->detailPlanification->course->name}} </b> ,  realizado en el Centro Histórico de Quito del 08 al 31 de marzo del 2021, con una duración de 40 horas.
		</div>
		<div id="inner" >
			
		</div>
	</div>
	 <footer>
     <h6><br><br><br><br><br><br><br><br>Quito DM,20 de abril del 2021.<br>
	 Registro SENECYT No:{{ $users->code_certificate}} </h6>
    </footer> 
</body>
</html>