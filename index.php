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
	<body>
		<div class="row">
		    <div class="col s3">
		    	
		      <div id="mini_1_large" class="card purple darken-4">
		        <div class="card-content white-text">
		        	<div id="ip_address1">
		          <span class="card-title"></span>
		          	</div>
		          <p>Dashboard</p>
		        </div>
		        <div id="mini_1">
			        <ul class="collection">
				    </ul>
				    <canvas id="graph1" width="337" height="100"></canvas>
				</div>
		        
		    </div>
		      </div>
		      <div class="col s3">
		    	
		      <div id="mini_2_large" class="card purple darken-4">
		        <div class="card-content white-text">
		        	<div id="ip_address2">
		          <span class="card-title"></span>
		          	</div>
		          <p>Dashboard</p>
		        </div>
		        <div id="mini_2">
			        <ul class="collection">
				    </ul>
				    <canvas id="graph2" width="337" height="100"></canvas>
				</div>
		        
		    </div>
		      </div>
		    </div>
		</div>
<script type="text/javascript">
//graph1
var smoothie1 = new SmoothieChart({millisPerPixel:32,maxValue:10,minValue:0,timestampFormatter:SmoothieChart.timeFormatter});
smoothie1.streamTo(document.getElementById("graph1"));
// Data
var line1 = new TimeSeries();

//graph2
var smoothie2 = new SmoothieChart({millisPerPixel:32,maxValue:10,minValue:0,timestampFormatter:SmoothieChart.timeFormatter});
smoothie2.streamTo(document.getElementById("graph2"));

var line2 = new TimeSeries();


function on_new_ip(ip) {
	// specs from ip
	dbObj = get_dashboard_obj(specs)
	dbObj.get_ajax_every(3)
}

function get_dashboard_obj(specs) {
	// returns a dashboard object
	// object has its own html, ajax call etc


	update_html(dbObj)
	return dbObj
}

function update_html(dbObj) {
	// use dbObj to fill in new html.
	// get dbObj id, name, ip, etc
}

function get_json_dashboard1()
{
	$.ajax({
		url: 'backend/135.243.94.118_details.json',
		datatype:"datatype",

		success: function(response){
			rowstring="";
			var hostname=response['hostname'];
			var used_memory=response['used memory'];
			var total_memory=response['total memory'];
			var percent_memory=used_memory/total_memory*100;
			var cpu=response['cpu usage'];
			var time=new Date($.now());
			var ip_address="172.21.207.180";
			var ip_string="";
			//setting the ip address on top of the dashboard
			ip_string+="<span class='card-title'>"+ip_address+"</span>";
			$('#ip_address1').html(ip_string);
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
			//cpu
			rowstring+="<li class='collection-item avatar'>";
			rowstring+="<img src='images/Cpu-icon.png' alt='' class='circle'>";
			rowstring+="<span class=title'>Load</span>";
			rowstring+="<p>"+cpu+"</p>";
			rowstring+="</li>";
			//current time stamp
			rowstring+="<li class='collection-item avatar'>";
			rowstring+="<img src='images/Clock-icon.png' alt='' class='circle'>";
			rowstring+="<span class=title'>Time</span>";
			rowstring+="<p>"+time+"</p>";
			rowstring+="</li>";
			
			$("#mini_1 ul").html(rowstring);
			$("#mini_1_large").removeClass("card red lighten-1").addClass("card purple darken-4");

			line1.append(time, cpu);
			// Add to SmoothieChart
			smoothie1.addTimeSeries(line1, {lineWidth:2.0,strokeStyle:'#00ff00'});
			
		},

		error:function(){
			$("#mini_1_large").removeClass("card purple darken-4").addClass("card red lighten-1");
			$("#mini_1 ul").html('');
			setTimeout(get_json_dashboard1,1000);  
		},
		cache:false
	});
}

function get_json_dashboard2()
{
	$.ajax({
		url: 'backend/172.21.207.134_details.json',
		datatype:"datatype",

		success: function(response){
			rowstring="";
			var hostname=response['hostname'];
			var used_memory=response['used memory'];
			var total_memory=response['total memory'];
			var percent_memory=used_memory/total_memory*100;
			var cpu=response['cpu usage'];
			var time=new Date($.now());
			var ip_address="172.21.207.180";
			var ip_string="";
			//setting the ip address on top of the dashboard
			ip_string+="<span class='card-title'>"+ip_address+"</span>";
			$('#ip_address2').html(ip_string);
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
			//cpu
			rowstring+="<li class='collection-item avatar'>";
			rowstring+="<img src='images/Cpu-icon.png' alt='' class='circle'>";
			rowstring+="<span class=title'>Load</span>";
			rowstring+="<p>"+cpu+"</p>";
			rowstring+="</li>";
			//current time stamp
			rowstring+="<li class='collection-item avatar'>";
			rowstring+="<img src='images/Clock-icon.png' alt='' class='circle'>";
			rowstring+="<span class=title'>Time</span>";
			rowstring+="<p>"+time+"</p>";
			rowstring+="</li>";
			
			$("#mini_2 ul").html(rowstring);
			$("#mini_2_large").removeClass("card red lighten-1").addClass("card purple darken-4");

			line2.append(time, cpu);
			// Add to SmoothieChart
			smoothie2.addTimeSeries(line2, {lineWidth:2.0,strokeStyle:'#00ff00'});
			
		},

		error:function(){
			$("#mini_2_large").removeClass("card purple darken-4").addClass("card red lighten-1");
			$("#mini_2 ul").html('');
			setTimeout(get_json_dashboard2,1000);  
		},
		cache:false
	});
}


$(document).ready(function() { 	/* documnet is ready now */

	get_json_dashboard1();
	get_json_dashboard2();
	//setTimeout(get_json_sample,1000); 
			 setInterval(function() {
			 	get_json_dashboard1();
			 	get_json_dashboard2();
  				
  				},2000);

});

</script>

</body>
</html>
