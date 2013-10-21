function GetSolutionName() {
	return selectedSolution;//$('#Solution').val()
}

function GetProjectName() {
	return $("select option:selected").val();
}

function LoadFile(solutionName, projectName, fileName) {
	selectedSolution = solutionName;
	selectedProject = projectName;
	selectedFile = fileName;
	$.get('core/controller/readfile.php', { 'solution': solutionName, 'project': projectName, 'title': fileName }).done(function(data) {
		$('#data').html("<pre class='brush: csharp;'>" + data + "</pre>");
	  //$('#data').html(data).attr('class', 'brush: csharp;');
	  //$('#data').innerHTML = "<pre class='brush: csharp;'>" + data + "</pre>";
	  SyntaxHighlighter.highlight();
	});
}

function LoadFriendsSolutions()
{
	$.getJSON('core/controller/getFriendSolutions.php', { 'uid': CWMCommon.GetUid() }).done(function(data) {
		//alert(JSON.stringify(data));
		for (var i = 0; i < data.length; i++) {
			$("#friendSolutionsTop").append("<li id='" + data[i].solutionId + "'><a href='#'>"  + data[i].solutionName + "</a></li>");
	    }
	    /*if(data.length == 0) {
	    	alert("You don't have any solutions shared by your friends...");
	    }*/
	    $("#friendSolutionsTop li").click(function(e) {
	    	var filename = location.pathname.substr(location.pathname.lastIndexOf("/")+1,location.pathname.length);
	    	if(filename != "manage.php") {
	    		window.location = "manage";
	    	}
			//var solutionName = $(this).attr("id");
			//selectedSolutionId = $(this).attr("id");
			var solutionId = $(this).attr('id');
			var solutionName = $(this).text();
			LoadSolutionProjects(solutionId, solutionName);
		});
	});
}

// Loads user solutions
function LoadUserSolutions() {
	$.getJSON('core/controller/getUserSolutions.php', { 'uid': CWMCommon.GetUid() }).done(function(data) {
		for (var i = 0; i < data.length; i++) {
			//$("#solutionsTop").append("<li id='" + data[i].id + "'><a href='#'>"  + data[i].name + "</a></li>");
	    	$("#solutionsTop").append("<li id='" + data[i].id + "'><a href='#'>"  + data[i].name + "</a></li>");
	    }
	    if(data.length == 0) {
	    	alert("Could not load solutions!");
	    }
	    $("#solutionsTop li").click(function(e) {
	    	//var fileName = window.location.replace(/^.*[\\\/]/, '')
	    	var filename = location.pathname.substr(location.pathname.lastIndexOf("/")+1,location.pathname.length);
	    	if(filename != "manage.php") {
	    		//window.location = "manage";
	    	}
			//var solutionName = $(this).attr("id");
			//selectedSolutionId = $(this).attr("id");
			var solutionId = $(this).attr('id');
			var solutionName = $(this).text();
			//alert(solutionId + ", " + solutionName);
			LoadSolutionProjects(solutionId, solutionName);
		});
	});
}

// Loads project files
function LoadSolutionProjects(solutionId, solutionName) {
	// Set solution name in UI
	//$('#Solution').val(solutionName);
	selectedSolution = solutionName;
	$.getJSON('core/controller/readSolutionProjects.php', { 'solutionId': solutionId }).done(function(data) {
	$('#projects-content .solution-title').html(solutionName + " (" + data.length + ")");
		for (var i = 0; i < data.length; i++) {
			GetProjectFiles(data[i].id);
		}
		if(data.length == 0) {
			alert("Could not load solution: " + solutionName);
		}
		else {
			//LoadProjectView();
		}
			//options.append($("<option />").val().text(this));
		//});
	});
}



function makeClone(data)
{

	var obj = $('#project-panel-template').ModelView({
		projectName: data[0].projectName
    }, {
        controller: MVC.Controller({
        	Navigate: function() {
        		window.location = "<?php echo $GLOBALS['urlRoot']; ?>/share/file/" + obj.url;
        	}
        }),
        clone: {
            id: "#" + $.now(),
            append: function(elem) {
            	$('.panel-group').append(elem);
                $(elem).show();
            }
        }
    });
    return obj;
}

// Loads project files
function GetProjectFiles(projectId) {
	//$("#projects2").html("");
	$(".panel-group").html("");
	$.getJSON('core/controller/readProjectFiles.php', { 'uid': storage.get('uid'), 'projectId': projectId }).done(function(data) {

		objClone = makeClone(data);

		var linkName = "collapseBody" + Math.floor((Math.random()*1000)+1);
		$(objClone.GetViewId() + " .accordion-toggle").attr("href", "#" + linkName);
		$(objClone.GetViewId() + " .panel-collapse").attr("id", linkName);
		//$(objClone.GetViewId() + " .panel-body").html("hey");

		//$(objClone.GetViewId() + " .collapse").collapse();

		var projectName = data[0].projectName;
		var solutionName = data[0].solutionName;
		//$(objClone.GetViewId() + " .panel-body #projects2").append($('<li class="nav-header"><a href="#">' + projectName + '</a></li>'));

		for(var j = 0; j < data.length; j++) {
			var shareLink = "";
			var shareUrl = data[j].shareUrl;
			if(shareUrl.length > 0) {
				shareLink = ' - <a href=share/file/'+shareUrl+'>shared</a>';
			}
			var li = $('<li id='+ j +' class="list-group-item"><a href="#">' + data[j].name + '</a>' + shareLink + '</li>');
			li.click(function(e) {
				//alert( $(this).attr('id') + " - " + JSON.stringify(data[$(this).attr('id')]) );
				var index = $(this).attr('id');
				LoadFile(data[index].solutionName, data[index].projectName, data[index].name);
			});
			$(objClone.GetViewId() + " #projectFiles").append(li);
		}
	});
	$(".collapse").collapse();
}

// Loads project files
function LoadProjectFiles(solutionName, projectName) {
	selectedProject = projectName;
	$.getJSON('core/controller/readProjectFiles.php', { 'uid': storage.get('uid'), 'solution': solutionName, 'project': projectName }).done(function(data) {
		var options = [];
		options.push("<option value=''>choose a file...</option>");
		//alert(data.length);
		//$.each(data, function() {
			for (var i = 0; i < data.length; i++) {
				options.push('<option value="',
					data[i], '">',
					data[i], '</option>');
			}
			$("#Files").html(options.join(''));

			if(data.length == 0) {
			//alert("Could not load project: " + projectName);
		}
		else {
			//LoadProjectView();
		}
			//options.append($("<option />").val().text(this));
		//});
});
}