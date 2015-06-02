<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <!-- import materialize.css -->
        <link rel="stylesheet" type="text/css" href="css/materialize.min.css"media="screen,projection"/>
        <link rel="stylesheet" type="text/css" href="css/main.css"/>
        <!-- import jQuerry before material.js -->
        <script type="text/javascript" src="jquery/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="js/materialize.min.js"></script>
        <script type="text/javascript" src="js/smoothie.js"></script>
    </head>

    
    
    <!-- reading the ip_list and providing the array of ip -->
    <?php
        $myfile = fopen("backend/ip_list", "r") or die("There seems to be a problem. The server data couldn't be accessed right now!");
        $_err_internal = 'FILE_OPEN_FAILED';
        $ip_list = array();
        while(!feof($myfile)) {
            $line = fgets($myfile);
            $pieces = explode(" ", $line); 
            if (count($pieces) > 1) {
                $ip_list[] = $pieces[0];
            }
        }
        $ip_array = $ip_list;
    ?>

    <body>  
<div class="navbar-fixed">
   <nav class="cyan darken-2">
    <div class="nav-wrapper">
      <a href="#" class="brand-logo center" >LiMON - Live Server Monitor for U</a>
      <ul id="nav-mobile" class="right hide-on-med-and-down">
       
        <li><a href="sass.html">Contact Us</a></li>
       </ul>
     
    </div>
  </nav>
</div>
  <!-- Modal Structure -->
  <div id="modal1" class="modal">
    <div class="modal-content">
      <h4>Enter the Server Details</h4>
      
    <!-- the form to get input from user on ip address and related credentials -->
        <div class="row">
            <div class="col s6 offset-s3  ">
                <div class="card blue-grey darken-1">
                    <div class="card-content white-text">
                        <form class="col s12"  method="post" action="">
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
                                    <button class="btn waves-effect waves-light" type="submit" id="submit" name="submit" onclick="">Submit<i class="mdi-content-send right"></i>
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
      
    </div>
  </div>

    
        <div class="row">
            <div id="main" >
            </div>
        </div>

         <!-- Modal Trigger -->
        <div class="fixed-action-btn" style="bottom: 60px; right: 60px;">
            <a class="btn-floating btn-large red darken-1 tooltipped" data-delay="50" dataposition="" data-tooltip="Add Server to Watch" onclick="openModal_helper()">
              <i class="large mdi-content-add"></i>
            </a>
        </div>

        <script type="text/javascript">

//global variables
var dashboard_count=0; //stores the count of the dashboard objects
var dashboards = []; //stores the dashboard objects

//ip_array to store the ip address fetched from ip_list containing the (ip_address username password)
var ip_array = <?php echo json_encode($ip_array); ?>;
var no_of_lines = ip_array.length;

//opens the modal box containing the form
function openModal_helper() {

    $('#modal1').openModal();
}


//submit action fetches the ip_address and credentials 
//pushes them to ip_list file on separate lines -> carried out by form_to_list.php

$(function(){
        $("#submit").click(function() {

            var ip_textcontent = $("#ip_address").val();
            var uname_textcontent = $("#uname").val();
            var password_textcontent = $("#password").val();
            var dataString = 'content='+ ip_textcontent+' '+uname_textcontent+' '+password_textcontent;
            if(ip_textcontent=='')
            {
                alert("Enter the IP ADDRESS please..");
                $("#ip_address").focus();
            }
            else if(uname_textcontent=='')
            {
                alert("Enter the USER NAME please..");
                $("#uname").focus();
            }
            else if(password_textcontent=='')
            {
                alert("Enter the PASSWORD please..");
                $("#password").focus();
            }
            else
            {
                $.ajax({
                    type: "POST",
                    url: "form_to_ip_list.php",
                    data: dataString,
                    cache: true,
                    success: function(html)
                    {
                        $("#show").after(html);
                        document.getElementById('ip_address').value='';
                        document.getElementById('uname').value='';
                        document.getElementById('password').value='';
                        $('#modal1').closeModal();

                        var obj= new create_dashboard_obj(ip_textcontent);
                        dashboards.push(obj);
                        Materialize.toast('Adding '+ip_textcontent+' to watch :)', 3000, 'rounded') // 'rounded' is the class I'm removing the dashboard
                    }  
                });

            }
            return false;
        });

}); 

remove_dashboard=function(id)
{
    counter=0;
    var ip_address="";
    while(counter!=dashboards.length)   
    {
        if(id==dashboards[counter].dashboard_id)
        {
            ip_address=dashboards[counter].ip_address;
        }
        counter+=1;
    }
    var dataString= 'content='+ip_address;
    $.ajax({
                    type: "POST",
                    url: "delete_ip_address_from_ip_list.php",
                    data: dataString,
                    cache: true,
                    success: function(html)
                    {
                        
                        $('#card_skeleton_container_'+id).delay(100).fadeOut(1000);
                        Materialize.toast('Removed '+ip_address+' from watch :(', 3000, 'rounded') // 'rounded' is the class I'm removing the dashboard
                    }  
                });

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
    card_skeleton+='<div class="card deep-orange lighten-2" data-ip='+this.ip_address+' id=card_'+this.dashboard_id+'>';
    card_skeleton+='<a class="btn-floating btn waves-effect waves-light red accent-4 right" onclick="remove_dashboard('+this.dashboard_id+')"><i class="mdi-navigation-cancel right"></i></a>';
    card_skeleton+='<div class="card-content white-text">';
    card_skeleton+='<span class="card-title">'+this.ip_address+'</span>';
    card_skeleton+='<p>Dashboard</p>';
    card_skeleton+='</div>';
    card_skeleton+='<div id=parameter_list_'+this.dashboard_id+'>';
    card_skeleton+='<ul class="collection">';
    card_skeleton+='</ul>';
    card_skeleton+='<div id=graph_div_'+this.dashboard_id+'>';
    card_skeleton+='<canvas id=graph_'+this.dashboard_id+'></canvas>';
    card_skeleton+='</div>';
    card_skeleton+='</div>';
    card_skeleton+='</div>';
    $(card_skeleton_container).append(card_skeleton);
    $('#main').append(card_skeleton_container).hide().fadeIn(800);;

    this.smoothie = new SmoothieChart({millisPerPixel:32,maxValue:10,minValue:0});
    
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
        timeout: 10000,
        datatype:"datatype",

        success: function(response){
            rowstring="";
            var hostname=response['hostname'];
            var os_version=response['os_version'];
            var used_memory=response['used memory'];
            var total_memory=response['total memory'];
            var percent_memory=used_memory/total_memory*100;
            var current_time=response['time'];
            var up_time=response['up_time'];
            var cpu=response['cpu usage'];
            var time=new Date($.now());
            
            

            //hostname
            rowstring+="<li class='collection-item avatar'>";
            rowstring+="<img src='images/Server-icon.png' alt='' class='circle'>";
            rowstring+="<span class=title'>Hostname</span>";
            rowstring+="<p>"+hostname+"</p>";
            rowstring+="</li>";

             //OS_Version
            rowstring+="<li class='collection-item avatar'>";
            rowstring+="<img src='images/OSVersion-icon-linux.png' alt='' class='circle'>";
            rowstring+="<span class=title'>OS Version</span>";
            rowstring+="<p>"+os_version+"</p>";
            rowstring+="</li>";

            //used_memory
            rowstring+="<li class='collection-item avatar'>";
            rowstring+="<img src='images/Ram-icon.png' alt='' class='circle'>";
            rowstring+="<span class=title'>Used Memory</span>";
            rowstring+="<p>"+used_memory+"/"+total_memory+"</p>";
            rowstring+="<div style='width:200px; height:8px;background-color: #F0ED00'>";
            rowstring+="<div style='width:"+percent_memory+"%;height:8px;background-color: #1BA612;'></div></div>";
            rowstring+="</li>";
            
            //current_time
            rowstring+="<li class='collection-item avatar'>";
            rowstring+="<img src='images/Clock-icon.png' alt='' class='circle'>";
            rowstring+="<span class=title'>Current Time</span>";
            rowstring+="<p>"+current_time+"</p>";
            rowstring+="</li>";

             //up_time
            rowstring+="<li class='collection-item avatar'>";
            rowstring+="<img src='images/Uptime-icon.png' alt='' class='circle'>";
            rowstring+="<span class=title'>UP Time</span>";
            rowstring+="<p>"+up_time+"</p>";
            rowstring+="</li>";

            //cpu
            rowstring+="<li class='collection-item avatar'>";
            rowstring+="<img src='images/Cpu-icon.png' alt='' class='circle'>";
            rowstring+="<span class=title'>Load</span>";
            rowstring+="<p>"+cpu+"</p>";
            rowstring+="</li>";

            $('#graph_div_'+dashboard_obj.dashboard_id).show();
            $('#parameter_list_'+dashboard_obj.dashboard_id+' ul').html(rowstring);
            $('#card_'+dashboard_obj.dashboard_id).removeClass("card deep-orange lighten-2").addClass("card  cyan");

            //dashboard_obj.line.append(time , cpu);
            dashboard_obj.line.append(time , cpu);
            // Add to SmoothieChart
            dashboard_obj.smoothie.addTimeSeries(dashboard_obj.line, {lineWidth:2.0,strokeStyle:'#00ff00'});
            
        },

        error:function(){
            $('#card_'+dashboard_obj.dashboard_id).removeClass("card cyan").addClass("card deep-orange lighten-2");
            $('#parameter_list_'+dashboard_obj.dashboard_id+' ul').html('');
            $('#graph_div_'+dashboard_obj.dashboard_id).hide();
            
        },
        cache:false
    });
}



$(document).ready(function(){
    
    
    var i;
    for (i = 0; i < no_of_lines ; i++) {
        dashboards.push(new create_dashboard_obj(ip_array[i]));
    }
    setInterval(function() {
        for (i = 0; i < dashboards.length ; i++) { 
            ajax_function_generalized(dashboards[i]);
        }
    },5000);
});
        </script>
    </body>
</html>