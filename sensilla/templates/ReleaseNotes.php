<?php
/**
 * Template Name: Release Notes
 * Description: This is a template for the Release Notes
 * @package Nu Themes
 */

get_header(); ?>

	<div class="row">
		<main id="content" class="col-sm-8 content-area" role="main">
		<div id="fixed" class="title"> 
		<center><span style="font-size:24px;color:blue">Fixed</span></center>
		</div>
		
		<div id="wip" class="title">
		<center><span style="font-size:24px;color:blue">Work In Progress</span></center>
		</div>

		<div id="known" class="title">
		<center><span style="font-size:24px;color:blue">Known</span></center>
		</div>

	<div id="dialogAdd" title="Input New Entry" style="display:none">
<form method="get" name="newForm">
  <input type="text" id="description" placeholder="Please Enter Text" value="<?=$description;?>" name="description"></input>
  <select id="dropdownStatus" name="dropdownStatus">
  		<option value="1">Fixed</option>
  		<option value="2">Work In Progress</option>
  		<option value="3">Known</option>
   </select>
     <input type="text" name="id" id="id" style="display:none"></input>
	<input type="submit" Value="Submit" id="submitQuery" name="Submit" onClick="buttonSubmit()"> Submit </button>	
</form>
</div>

<div id="dialogRevise" title="Revise Entry" style="display:none" class="dialog-list">
<div id="title">
<div id="title_fixed" class="fixed"></div> 
<div id="title_wip" class="wip"> </div>
<div id="title_known" class="known"> </div>
</div>
</div>

<div id="dialogReviseSQL" title="Modify Entry" style="display:none">
<form method="get" name="reviseForm">
  <input type="text" id="descriptionReviseSQL" placeholder="Please Enter Text" value="<?=$descriptionReviseSQL;?>" name="descriptionReviseSQL"></input>
  <select id="dropdownStatusReviseSQL" name="dropdownStatusReviseSQL">
  		<option value="1">Fixed</option>
  		<option value="2">Work In Progress</option>
  		<option value="3">Known</option>
   </select>
     <input type="text" name="idReviseSQL" id="idReviseSQL" style="display:none"></input>
	<button type="type" id="submitQueryReviseSQL" name="SubmitReviseSQL" onClick="buttonSubmit()">submit</input>	
</form>
</div>

<div id="dialogDel" title="Delete Entry" style="display:none" class="dialog-list">
<div id="del">
<div id="del_fixed" class="fixed"> </div>
<div id="del_wip" class="wip"> </div>
<div id="del_known" class="known"> </div>
</div>
</div>

<div id="dialogDelete" title="Delete" style="display:none">
<form method="get" name="FormDelete">
  
  <input type="text" id="dropdownStatusDelete" name="dropdownStatusDelete" style="display:none">
     <input type="text" name="idDelete" id="idDelete" style="display:none"></input>
     <span>Are you sure you want to delete <input type="text" id="descriptionDelete" name="descriptionDelete" readonly></input>
	<button type="submit" id="submitQueryDelete" name="SubmitDelete" onClick="buttonSubmit()"> Yes </button>
	<button> No</button>	
</form>
</div>




		<!-- #content --></main>

		<?php get_sidebar(); ?>
	<!-- .row --></div>

<?php get_footer(); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/themes/smoothness/jquery-ui.css" />
<!--<link rel="stylesheet" href="screen.css" />-->

<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>
<?php

//Calling an instance of the wpdb (wordpress database) class
global $wpdb;
$release_version = "release_3_0";

	if (isset($_GET['Submit'])){
		$id = $_GET['id'];
		$description = $_GET['description'];
		$dropdownStatus = $_GET['dropdownStatus'];
		$wpdb->insert($release_version, 
						array(
							"id" => $_GET['id'], 
							"descr" => $_GET["description"], 
							"status" => $_GET["dropdownStatus"]
							), 
						array("%d", "%s", "%d"));
	}


	if (isset($_GET['SubmitReviseSQL'])){
		$id = $_GET['idReviseSQL'];
		$description = $_GET['descriptionReviseSQL'];
		$dropdownStatus = $_GET['dropdownStatusReviseSQL'];		
		$wpdb->update($release_version, 
						array(
							"descr" => $_GET["descriptionReviseSQL"], 
							"status" => $_GET["dropdownStatusReviseSQL"]
							),
						array(
							"id"=>$_GET['idReviseSQL']
							), 
						array( "%s", "%d" ), 
						array("%d"));
		}

	if (isset($_GET['SubmitDelete'])){
		$id = $_GET['idDelete'];
		$description = $_GET['descriptionDelete'];
		$dropdownStatus = $_GET['dropdownStatusDelete'];		
		$wpdb->delete($release_version, array("id" => $_GET['idDelete']), array("%d"));
		//DELETE FROM `release`.`release_3_0` WHERE `release_3_0`.`id` = 18
	}
		//}

//selecting all contents of the table release_3_0
$sql = $wpdb->get_results( "SELECT * FROM ".$release_version.""); 
$sql2 = $wpdb->get_results( "SELECT MAX(id) FROM ".$release_version.";");  


//loop through each row and print specific fields
foreach($sql as $row) {
	$id = $row->id;
	$descr = $row->descr;
	$status = $row->status;
	$data = array(
		"id" => $id,
		"descr" => $descr,
		"status" => $status
	);
	?>
	<script type="text/javascript">
	var sqlData = <?php echo json_encode($data); ?>;  //this is to pass data from PHP to JS

	//fixed = 1, WIP = 2, known = 3
	
	if(sqlData.status == "1") {
	$('#fixed').append('<br><span id="status" class="fixed">Fixed</span> <span id="descr" class="descr">'+sqlData.descr+'</span>');
	$('#title_fixed').append('<div class="popup-modify" currentStatus="1" descr="'+sqlData.descr+'" id="'+sqlData.id+'"><span id="fixed" class="fixed">Fixed</span> <span id="descr" class="descr">'+sqlData.descr+'</div></span>');
	$('#del_fixed').append('<div class="popup-delete" currentStatus="1" descr="'+sqlData.descr+'" id="'+sqlData.id+'"><span id="fixed" class="fixed">Fixed</span> <span id="descr" class="descr">'+sqlData.descr+'</div></span>');
	
	}
	if(sqlData.status == "2") {
	$('#wip').append('<br><span id="status" class="wip">WIP</span> <span id="wip" class="wip">'+sqlData.descr+'</span>');
	$('#title_wip').append('<div class="popup-modify" currentStatus="2" descr="'+sqlData.descr+'" id="'+sqlData.id+'"><span id="status" class="wip">WIP</span> <span id="wip" class="wip">'+sqlData.descr+'</div></span>');
	$('#del_wip').append('<div class="popup-delete" currentStatus="2" descr="'+sqlData.descr+'" id="'+sqlData.id+'"><span id="status" class="wip">WIP</span> <span id="wip" class="wip">'+sqlData.descr+'</div></span>');
	
	}
	if(sqlData.status == "3") {
	$('#known').append('<br><span id="status" class="known">Known</span> <span id="known" class="known">'+sqlData.descr+'</span>');
	//$('#title').append('<div class="popup" setit="test3"><span id="status" class="Known_status">Known</span> <span id="known" class="known">'+sqlData.descr+'</div></span>');
	$('#title_known').append('<div class="popup-modify" currentStatus="3" descr="'+sqlData.descr+'" id="'+sqlData.id+'"><span id="status" class="known">Known</span> <span id="known" class="known">'+sqlData.descr+'</span></div>');
	$('#del_known').append('<div class="popup-delete" currentStatus="3" descr="'+sqlData.descr+'" id="'+sqlData.id+'"><span id="status" class="known">Known</span> <span id="known" class="known">'+sqlData.descr+'</span></div>');
	
	}
	
	</script>
 <?php 
} 

?>

<script type="text/javascript">
$(document).ready(function(){
	var sql = <?php echo json_encode($sql2) ?>;
	var splitID = JSON.stringify(sql).split(':"');
	var tempID = splitID[1].split('"');
	var lastID = tempID[0];
	var nextID = parseInt(lastID);
	var finalID = ++nextID;
	var sqlQuery;
	$('#id').val(finalID);
	
	$('.popup-modify').click(function (e) {
		$('#descriptionReviseSQL').val($(this).attr('descr'));
		$('#dropdownStatusReviseSQL').val($(this).attr('currentStatus'));
		$('#idReviseSQL').val($(this).attr('id'));
		$("#dialogReviseSQL").dialog();
});

	$('.popup-delete').click(function (e) {
		$('#descriptionDelete').val($(this).attr('descr'));
		$('#dropdownStatusDelete').val($(this).attr('currentStatus'));
		$('#idDelete').val($(this).attr('id'));
		$("#dialogDelete").dialog();
});




});

function addButton() {
$( "#dialogAdd" ).dialog();
}

function reviseButton() {
$( "#dialogRevise" ).dialog();
}

function deleteButton() {
$( "#dialogDel" ).dialog();
}

</script>