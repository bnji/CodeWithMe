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
	    		//window.location = "manage.php";
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
	    		//window.location = "manage.php";
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
	$('#Solution').val(solutionName);
	selectedSolution = solutionName;
	$.getJSON('core/controller/readSolutionProjects.php', { 'solutionId': solutionId }).done(function(data) {
		for (var i = 0; i < data.length; i++) {
			GetProjectFiles(data[i].id, data[i].name);
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

// Loads project files
function GetProjectFiles(projectId, projectName) {
	selectedProject = projectName;
	$("#projects2").html("");
	$.getJSON('core/controller/readProjectFiles.php', { 'uid': storage.get('uid'), 'projectId': projectId }).done(function(data) {
		//var listItems = [];
		$("#projects2").append($('<li class="nav-header"><a href="#">' + projectName + '</a></li>'));

		for(var j = 0; j < data.length; j++) {
			var li = $('<li><a href="#">' + data[j].name + '</a></li>');
			li.click(function() {
				//alert(JSON.stringify(data[$(this).index()-1]));
				var d = data[$(this).index()-1];
				//alert(d.solutionName + ", " + d.projectName);
				LoadFile(d.solutionName, d.projectName, d.name);
			});
			//listItems.push($(li));
			$("#projects2").append(li);
			//if(j == 0) listItems.push('<li class="active"><a href="#">' + data[j] + '</a></li>');
			//else listItems.push('<li><a href="#">' + data[j] + '</a></li>');
		}
	});
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