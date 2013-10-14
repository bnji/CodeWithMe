<?php
require_once './core/dirHandler.php';
require_once $GLOBALS['dirRoot'].'/libs/external/meekrodb.2.2.class.php';
require_once './core/dbConfig.inc.php';
require_once './core/auth.inc.php';
if(!isUserLoggedIn())
{
	redirect('./');
}
require_once $GLOBALS['dirCore'].'/view/standard/header.inc.php';
?>
<script type="text/javascript" src="<?php echo $GLOBALS['urlLibs']; ?>/external/syntaxhighlighter_3.0.83/scripts/shCore.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['urlLibs']; ?>/external/syntaxhighlighter_3.0.83/scripts/shBrushCSharp.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $GLOBALS['urlLibs']; ?>/external/syntaxhighlighter_3.0.83/styles/shCore.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $GLOBALS['urlLibs']; ?>/external/syntaxhighlighter_3.0.83/styles/shThemeDefault.css" />
<script src="<?php echo $GLOBALS['urlLibs']; ?>/external/spike-engine/js/spike-sdk.js.src.js" type="application/javascript" ></script>
<link rel="stylesheet" href="<?php echo $GLOBALS['urlLibs']; ?>/external/spike-engine/css/styles2.css" type="text/css" />

<!--
<style>
#projects-content {
  position: absolute;
  top: 0;
  /* just used to show how to include the margin in the effect */
  margin-top: 20px;
  border-top: 1px solid purple;
  padding-top: 19px;
}

#projects-content.fixed {
  position: fixed;
  top: 0;
}
</style>-->


<?php require_once $GLOBALS['dirCore'].'/view/standard/navbarSignedIn.inc.php'; ?>

<h1>My shares</h1>

<table class="table">
  <thead>
    <tr>
      <th>Solution</th>
      <th>Project</th>
      <th>File</th>
      <th></th>
    </tr>
  </thead>
  <tbody id="template">
  	<tr>
      <td><span name="solution" datasrc=""></span></td>
      <td><span name="project" datasrc=""></span></td>
      <td><a href="#" name="Navigate" id="fileName"></a></td>
      <td>
      	<div id="action" class='btn-group'>
		  <a class='btn dropdown-toggle' data-toggle='dropdown' href='#'>
		    Action
		    <span class='caret'></span>
		  </a>
		  <ul class='dropdown-menu'>
		    <!-- dropdown menu links -->
		    <li><a name="Delete" href="#">Delete</a></li>
		  </ul>
		</div>
      </td>
    </tr>
  </tbody>
</table>

<?php include $GLOBALS['dirCore'].'/view/standard/footer.inc.php'; ?>

<script>
$(function(){
	$.getJSON('core/controller/getMyShares.php', function(data) {
		for(i = 0; i < data.length; i++) {
			makeClone(data[i]);
		}
	});

	function makeClone(data)
	{

		var obj = $('#template').hide().ModelView({
	        solution: data.solution,
	        project: data.project,
	        url: data.url,
	        fileName: data.fileName
	    }, {
	        controller: MVC.Controller({
	        	Navigate: function() {
	        		window.location = './viewSolutionFile.php?id=' + obj.url;
	        	},
	            Delete: function() {
	            	$.get('core/controller/deleteSolutionFileShare.php', { 'url': obj.url }).done(function(responseData) {
	            		//alert(responseData);
	            		$(obj.GetViewId()).remove();
	            	});
	            	//alert(obj.fileName);
            		//alert("deleting...\n" + JSON.stringify(obj, null, 2));
	            }
	        }),
	        clone: {
	            id: "#" + $.now(),
	            append: function(elem) {
	                $('.table').append(elem);
	                $(elem).show();
	            }
	        }
	    });
	}

});
</script>