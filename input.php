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
      <div class="col s6 offset-s3  ">
      <div class="card blue-grey darken-1">
            <div class="card-content white-text">

        	<form class="col s12"  method="POST" action="readfile.php">
      			<div class="row">
        			<div class="input-field col s12">
          				<input id="ip_address" name="ip_address" type="text" class="validate">
          				<label for="ip_address">Ip_Address</label>
       				</div>
      			</div>
      			<div class="row">
        			<div class="input-field col s6">
          				<input id="uname" name="uname" type="text" class="validate">
          				<label for="username">UserName</label>
        			</div>
        			<div class="input-field col s6">
          				<input id="password" type="password" name="password" class="validate">
          				<label for="password">Password</label>
        			</div>
      			</div>
      			<div class="row">
        			<div class="input-field col s12">
                
                <button class="btn waves-effect waves-light" type="submit" name="action">Submit<i class="mdi-content-send right"></i>
                </button>
  
						
       				</div>
      			</div>
      
   			</form>
      </div>
    </div>
  </div>
  		</div>
	</body>
</html>