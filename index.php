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
				<div id="main">
				</div>
			</div>


		<script type="text/javascript">

var dashboard_count=0;

function create_dashboard_obj(ip)
{
	//incrementing the dashboard count with object creation
	dashboard_count=dashboard_count+1;
	
	//object specifications
	this.ip_address = ip;
	this.dashboard_id=dashboard_count;
	
	//creating card related html elements
	var card_skeleton_container = $(document.createElement('div'));
	var card_skeleton=	"";
	card_skeleton+='<div class="col s3">';
	card_skeleton+='<div class="card purple darken-4" id=card_'+this.dashboard_id+'>';
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
	$('#main').append(card_skeleton_container);

	this.smoothie = new SmoothieChart({millisPerPixel:32,maxValue:10,minValue:0,timestampFormatter:SmoothieChart.timeFormatter});
	
	this.smoothie.streamTo(document.getElementById("graph_"+this.dashboard_id));
	// Data
	this.line = new TimeSeries();
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
			$('#graph_div_'+dashboard_obj.dashboard_id).show();
			$('#parameter_list_'+dashboard_obj.dashboard_id+' ul').html(rowstring);
			$('#card_'+dashboard_obj.dashboard_id).removeClass("card red lighten-1").addClass("card purple darken-4");

			dashboard_obj.line.append(time, cpu);
			// Add to SmoothieChart
			dashboard_obj.smoothie.addTimeSeries(dashboard_obj.line, {lineWidth:2.0,strokeStyle:'#00ff00'});
			
		},

		error:function(){
			$('#card_'+dashboard_obj.dashboard_id).removeClass("card purple darken-4").addClass("card red lighten-1");
			$('#parameter_list_'+dashboard_obj.dashboard_id+' ul').html('');
			$('#graph_div_'+dashboard_obj.dashboard_id).hide();
			
		},
		cache:false
	});
}

$(document).ready(function(){

	var obj1 = new create_dashboard_obj("135.243.94.118");
	var obj2 = new create_dashboard_obj("172.21.207.134");
	var obj3 = new create_dashboard_obj("172.21.207.22");

	ajax_function_generalized(obj1);
	ajax_function_generalized(obj2);
	ajax_function_generalized(obj3);

	setInterval(function() {
			 	ajax_function_generalized(obj1);
				ajax_function_generalized(obj2);
  				ajax_function_generalized(obj3);
  				},2000);

});
		</script>
	</body>
</html>