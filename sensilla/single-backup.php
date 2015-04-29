<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Nu Themes
 */

get_header(); ?>
<?php

?>


	<div class="row">
		<main id="content" class="col-sm-8 content-area" role="main">
			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'page' ); ?>

			<?php endwhile; ?>
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
  <center><select id="dropdownStatus" name="dropdownStatus">
  		<option value="1">Fixed</option>
  		<option value="2">Work In Progress</option>
  		<option value="3">Known</option>
   </select></center>
<br>
  <center><textarea rows="4" cols="50" id="description" placeholder="Please Enter Text" value="<?=$description;?>" name="description"></textarea></center>
     <input type="text" name="id" id="id" style="display:none"></input>
	<br><center><input type="submit" Value="Submit" id="submitQuery" name="Submit" onClick="buttonSubmit()"></button></center>	
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
  <select id="dropdownStatusReviseSQL" name="dropdownStatusReviseSQL">
  		<option value="1">Fixed</option>
  		<option value="2">Work In Progress</option>
  		<option value="3">Known</option>
   </select>

  <input type="text" id="descriptionReviseSQL" placeholder="Please Enter Text" value="<?=$descriptionReviseSQL;?>" name="descriptionReviseSQL"></input>
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
$release_version = setURL();
createTable($release_version);


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
	/*var str, res, tmp;
	if(sqlData.descr.length > 20){
		str = sqlData.descr;
		res = str.split("");
		tmp = res[0];
		alert(tmp);
	}*/
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

// This is used to set the URL for WPDB to access databases
function setURL() {
$whole_url = $_SERVER["REQUEST_URI"];
$parts=explode('release-', $whole_url);
$target_part = $parts[1];
$target_first=explode('/', $target_part);
$replace =  str_replace("-", "_", $target_first[0]);
$release_version = "RELEASE_" . $replace;
return $release_version;
}

function createTable(&$release_version) {
global $wpdb;
$charset_collate = $wpdb->get_charset_collate();
$sql = "CREATE TABLE $release_version (
  id int(7) NOT NULL AUTO_INCREMENT,
  descr varchar(255) NOT NULL,
  status int(1) NOT NULL,
  UNIQUE KEY id (id)
) $charset_collate;";

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $sql );
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
		$("#dialogRevise").dialog("close");
});

	$('.popup-delete').click(function (e) {
		$('#descriptionDelete').val($(this).attr('descr'));
		$('#dropdownStatusDelete').val($(this).attr('currentStatus'));
		$('#idDelete').val($(this).attr('id'));
		$("#dialogDelete").dialog();
		$("#dialogDel").dialog("close");
});




});

$(window).resize(function () {
    fluidDialog();
});

// catch dialog if opened within a viewport smaller than the dialog width
$(document).on("dialogopen", ".ui-dialog", function (event, ui) {
    fluidDialog();
});

function fluidDialog() {
    var $visible = $(".ui-dialog:visible");
    $visible.each(function () {
        var $this = $(this);
        var dialog = $this.find(".ui-dialog-content").data("ui-dialog");
        if (dialog.options.fluid) {
            var wWidth = $(window).width();
            if (wWidth < (parseInt(dialog.options.maxWidth) + 50))  {
                $this.css("max-width", "75%");
            } else {
                // fix maxWidth bug
                $this.css("max-width", dialog.options.maxWidth + "px");
            }
            //reposition dialog
            dialog.option("position", dialog.options.position);
        }
    });

}

function addButton() {
$( "#dialogAdd" ).dialog({
	 width: 'auto', 
    maxWidth: 750,
    height: 'auto',
    modal: true,
    fluid: true, 
    resizable: false
});
}

function reviseButton() {
$( "#dialogRevise" ).dialog({
	 width: 'auto', 
    maxWidth: 750,
    height: 'auto',
    modal: true,
    fluid: true, 
    resizable: false
});
}

function deleteButton() {
$( "#dialogDel" ).dialog({
	 width: 'auto', 
    maxWidth: 750,
    height: 'auto',
    modal: true,
    fluid: true, 
    resizable: false
});
}

</script>