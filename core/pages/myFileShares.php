<?php
if(!isUserLoggedIn())
{
  redirect('logout');
}
require_once $GLOBALS['dirCore'].'/view/standard/header.inc.php';
?>

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
	$.getJSON('core/controller/getMyShares.php', { 'uid': storage.get('uid') }).done(function(data) {
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
	        		window.location = "<?php echo $GLOBALS['urlRoot']; ?>/share/file/" + obj.url;
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