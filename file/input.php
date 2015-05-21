<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<!-- import materialize.css -->
		<link rel="stylesheet" type="text/css" href="css/materialize.min.css"media="screen,projection"/>
		<!-- import jQuerry before material.js -->
		<script type="text/javascript" src="jquery/jquery-2.1.1.min.js"></script>
		<script type="text/javascript" src="js/materialize.min.js"></script>

	</head>
	<body>
		<div class="row">
        	<form class="col s12"  method="post" action="readfile.php">
      			<div class="row">
        			<div class="input-field col s12">
          				<input placeholder="Placeholder" id="ip_address" name="ip_address" type="text" class="validate">
          				<label for="ip_address">Ip_Address</label>
       				</div>
      			</div>
      			<div class="row">
        			<div class="input-field col s6">
          				<input placeholder="Placeholder" id="uname" name="uname" type="text" class="validate">
          				<label for="username">UserName</label>
        			</div>
        			<div class="input-field col s6">
          				<input id="password" type="password" name="password" class="validate">
          				<label for="password">Password</label>
        			</div>
      			</div>
      			<div class="row">
        			<div class="input-field col s12">
                <input  type="submit" value="submit">
						<a class="waves-effect waves-light btn-large right" >Submit</a>
       				</div>
      			</div>
      
   			</form>
  		</div>
	</body>
</html>