<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<script type="text/javascript" src="jquery/jquery-2.1.1.min.js"></script>
	</head>
	<body>
		<div id="main">
			<input type="button" id="btAdd" value="Add Dashboard">
			<input type="button" id="btRemove" value="Remove Dashboard">
		</div>
		<script type="text/javascript">


$(document).ready(function(){

	var container_count=0;

	//DIV element created using JQuery
	var container = $(document.createElement('div')).css({
		padding: '5px', margin: '20px', width: '170px', border: '1px dashed',
        borderTopColor: '#999', borderBottomColor: '#999',
        borderLeftColor: '#999', borderRightColor: '#999'
	});

	$('#btAdd').click(function(){
		if (container_count<=20)
		{
			container_count+=1;

		//adding textbox 
			$(container).append('<input type="text" id="tb'+container_count+'"" value="Text Element '+container_count+'"/>');

			//generate the submit button when at least 1 element is created
			if (container_count==1)
			{

				var submitDiv = $(document.createElement('div'));
				$(submitDiv).append('<input type="button" onClick="GetTextValue()" id="btSubmit" value="submit">')
				$('#btRemove').removeAttr('disabled'); 
			}

			//adding both the divs to main container
			
		}
		else
		{
			$(container).append('<label> Reached the limit </limit>');
			$('#btAdd').attr('disabled','disabled');
		}
		$('#main').after(container,submitDiv);

	});

	$('#btRemove').click(function(){

		if (container_count !=0) 
		{
			$('#tb'+container_count).remove();
			container_count-=1;
			$('#btAdd').removeAttr('disabled');  
		}
		if (container_count == 0)
		{
			$(container).empty();
			$('#btRemove').attr('disabled','disabled');
			$('#btSubmit').remove(); 
			$('#btAdd').removeAttr('disabled');  
		}
	});
});
		</script>
	</body>

</html>