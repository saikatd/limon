<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<!-- import materialize.css -->
		<link rel="stylesheet" type="text/css" href="css/materialize.min.css"media="screen,projection"/>
		<!-- import jQuerry before material.js -->
		<script type="text/javascript" src="jquery/jquery-2.1.1.min.js"></script>
		<script type="text/javascript" src="js/materialize.min.js"></script>
		<script type="text/javascript" src="js/smoothie.js"></script>
	</head>

	<!-- updating the data to ip list -->
	 <?php
     if($_SERVER['REQUEST_METHOD'] === 'POST') {
	$ip_address = $_POST["ip_address"];
	$uname = $_POST["uname"];
	$password = $_POST["password"];

	$text="\n".$ip_address ." " .$uname ." " .$password;
	//echo $text;

	//$myfile = fopen("test.txt", "w") or die("Unable to open file!");
	//fwrite($myfile, $ip_address);
	file_put_contents("backend/ip_list", $text, FILE_APPEND);

	//fclose($myfile);
	header('Location:index.php');
	}
	?>

	<!-- reading the ip_list and providing the array of ip -->
	<?php

                $myfile = fopen("backend/ip_list", "r") or die("Unable to open file!");
                $no_of_lines=0;
                while(!feof($myfile)) 
                {
                                $line = fgets($myfile);
                                $pieces = explode(" ", $line); // substitute explode substr
                                $ip_list[$no_of_lines]=$pieces[0]; 
                                $no_of_lines++;
                }
   
   // $ip_array = array('172.21.207.135', '172.21.207.134');
    $ip_array = $ip_list;
	?>

	<body>	
    

	<!-- Modal Trigger -->
  <div class="row">
  	<div class="col 12 offset-s3">
  		<a class="waves-effect waves-light btn-large modal-trigger" onclick="openModal_helper()"><i class="mdi-content-add-circle"></i>Add Server to watch</a>
  		<a class="waves-effect waves-light btn-large red darken-4 modal-trigger" onclick=""><i class="mdi-content-remove-circle-outline"></i>Remove server from watch</a>
	</div>
</div>
  <!-- Modal Structure -->
  <div id="modal1" class="modal">
    <div class="modal-content">
      <h4>Enter the Server Details</h4>
      

		<div class="row">
      		<div class="col s6 offset-s3  ">
      			<div class="card blue-grey darken-1">
            		<div class="card-content white-text">
        				<form class="col s12"  method="post" action="<?=$_SERVER['PHP_SELF']?>">
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
					                <button class="btn waves-effect waves-light" type="submit" id="submit" name="submit" onclick="sendContactForm()">Submit<i class="mdi-content-send right"></i>
					                </button>			
		       					</div>
		      				</div>
   						</form>
      				</div>
    			</div>
  			</div>
  		</div>
    </div>
    <div class="modal-footer">
      <!-- <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Agree</a> -->
    </div>
  </div>

  	
		<div class="row">
			<div id="main">
			</div>
		</div>
	

		<script type="text/javascript">

var dashboard_count=0;

function openModal_helper(){
	$('#modal1').openModal();
}

function create_dashboard_obj(ip)
{
	//incrementing the dashboard count with object creation
	dashboard_count=dashboard_count+1;
	
	//object specifications
	this.ip_address = ip;
	this.dashboard_id=dashboard_count;
	
	//creating card related html elements
	var card_skeleton_container = $(document.createElement('div'));
	card_skeleton_container.attr("id","card_skeleton_container_"+this.dashboard_id);
	var card_skeleton="";
	card_skeleton+='<div class="col s3">';
	card_skeleton+='<div class="card red lighten-2"  id=card_'+this.dashboard_id+'>';
	card_skeleton+='<a class="btn-floating btn waves-effect waves-light red accent-4 right" onclick="remove_dashboard('+this.dashboard_id+')"><i class="mdi-navigation-cancel right"></i></a>';
	card_skeleton+='<div class="card-content white-text">';
	card_skeleton+='<span class="card-title">'+this.ip_address+'</span>';
	card_skeleton+='<p>Dashboard</p>';
	card_skeleton+='</div>';
	card_skeleton+='<div id=parameter_list_'+this.dashboard_id+'>';
	card_skeleton+='<ul class="collection">';
	card_skeleton+='</ul>';
	card_skeleton+='<div id=graph_div_'+this.dashboard_id+'>';
	card_skeleton+='<canvas id=graph_'+this.dashboard_id+' width="337" height="100"></canvas>';
	card_skeleton+='</div>';
	card_skeleton+='</div>';
	card_skeleton+='</div>';
	$(card_skeleton_container).append(card_skeleton);
	$('#main').append(card_skeleton_container).hide().fadeIn(800);;

	this.smoothie = new SmoothieChart({millisPerPixel:32,maxValue:10,minValue:0,timestampFormatter:SmoothieChart.timeFormatter});
	
	this.smoothie.streamTo(document.getElementById("graph_"+this.dashboard_id));
	// Data
	this.line = new TimeSeries();
	$('#graph_div_'+this.dashboard_id).hide();
}

function checker()
{
	alert("jhakaas");
}

ajax_function_generalized=function(dashboard_obj)
{
	
		$.ajax({
		url: 'backend/'+dashboard_obj.ip_address+'_details.json',
		datatype:"datatype",

		success: function(response){
			rowstring="";
			var hostname=response['hostname'];
			var used_memory=response['used memory'];
			var total_memory=response['total memory'];
			var percent_memory=used_memory/total_memory*100;
			var cpu=response['cpu usage'];
			var time=new Date($.now());
			

			//hostname
			rowstring+="<li class='collection-item avatar'>";
			rowstring+="<img src='images/Server-icon.png' alt='' class='circle'>";
			rowstring+="<span class=title'>Hostname</span>";
			rowstring+="<p>"+hostname+"</p>";
			rowstring+="</li>";
			//used_memory
			rowstring+="<li class='collection-item avatar'>";
			rowstring+="<img src='images/Ram-icon.png' alt='' class='circle'>";
			rowstring+="<span class=title'>Used Memory</span>";
			rowstring+="<p>"+used_memory+"/"+total_memory+"</p>";
			rowstring+="<div style='width:200px; height:8px;background-color: #F0ED00'>";
			rowstring+="<div style='width:"+percent_memory+"%;height:8px;background-color: #1BA612;'></div></div>";
			rowstring+="</li>";
			
			//current time stamp
			rowstring+="<li class='collection-item avatar'>";
			rowstring+="<img src='images/Clock-icon.png' alt='' class='circle'>";
			rowstring+="<span class=title'>Time</span>";
			rowstring+="<p>"+time+"</p>";
			rowstring+="</li>";

			//cpu
			rowstring+="<li class='collection-item avatar'>";
			rowstring+="<img src='images/Cpu-icon.png' alt='' class='circle'>";
			rowstring+="<span class=title'>Load</span>";
			rowstring+="<p>"+cpu+"</p>";
			rowstring+="</li>";
			$('#graph_div_'+dashboard_obj.dashboard_id).show();
			$('#parameter_list_'+dashboard_obj.dashboard_id+' ul').html(rowstring);
			$('#card_'+dashboard_obj.dashboard_id).removeClass("card red lighten-2").addClass("card purple darken-4");

			dashboard_obj.line.append(time, cpu);
			// Add to SmoothieChart
			dashboard_obj.smoothie.addTimeSeries(dashboard_obj.line, {lineWidth:2.0,strokeStyle:'#00ff00'});
			
		},

		error:function(){
			$('#card_'+dashboard_obj.dashboard_id).removeClass("card purple darken-4").addClass("card red lighten-2");
			$('#parameter_list_'+dashboard_obj.dashboard_id+' ul').html('');
			$('#graph_div_'+dashboard_obj.dashboard_id).hide();
			
		},
		cache:false
	});
}
var dashboards = [];

function remove_dashboard(dashboard_id)
{
	$('#card_skeleton_container_'+dashboard_id).delay(100).fadeOut(1000);
	
	dashboard_count-=1;
}

$(document).ready(function(){

	
	var no_of_lines = '<?php echo $no_of_lines; ?>';
	var ip_array = <?php echo json_encode($ip_array); ?>;

	

	var i;
	for (i = 0; i < no_of_lines ; i++) 
	{ 
    	dashboards.push(new create_dashboard_obj(ip_array[i]))
    }
    setInterval(function() 
    {
			 	for (i = 0; i < no_of_lines ; i++) 
				{ 
			    	ajax_function_generalized(dashboards[i]);
			    }
  	},2000);
});
		</script>
	</body>
</html>