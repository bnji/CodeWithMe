<?php
if(isUserLoggedIn())
{
	#checkSession();
	#redirect('manage');
}

require_once $GLOBALS['dirCore'].'/view/standard/header.inc.php';
?>
<link href="<?php echo $GLOBALS['urlCore']; ?>/view/standard/css/sign-in.css" rel="stylesheet" />

<div class="container">
	<form class="form-signin" name="sign-in">
		<h1>
			CodeWithMe
		</h1>
		<p class="text-primary">
			Online IDE - Ideal for rapid prototyping or testing of code.
			<br />
			The service is provided for free and always will!
		</p>
		<br />
		<p>
			Start by choosing a programming language
		</p>
		<div class="form-horizontal">
			<select id="programming-language" class="" data-live-search="true"></select>
			<button id="create" type="button" class="btn btn-primary">Start coding</button>
		</div>
	</form>
</div> <!-- /container -->

<?php include $GLOBALS['dirCore'].'/view/standard/footer.inc.php'; ?>

<script type="text/javascript">
$(function() {

	// setup
	/*CompileLib.loadLanguages("#programming-language",
                  "<?php echo $GLOBALS['urlLibs']; ?>/internal/ide/data/languages.json",
                  "csharp");*/


	var url = "<?php echo $GLOBALS['urlLibs']; ?>/internal/ide/data/languages.json";
	var id = "#programming-language";
	var selLang = "cpp";

	$.getJSON(url, function(data) {
      $.each(data, function(key, val) {
      	//console.log(key + " : " + val);
      	var option = $("<option></option>")
                    .attr("value",key)
                    .text(val['name']);
        if(val['name'] === selLang) {
          option.attr("selected", "selected");
        }
        $(id).append(option);
      });
      $(id)
      	.addClass('selectpicker')
	    .selectpicker({
			'selectedText': selLang
		});
    });

	//events
	$('#create').click(function(e){
		var language = $('#programming-language option:selected').val();
		$.post("<?php echo $GLOBALS['urlLibs']; ?>/internal/ide/controller/createSourceDraft.php", {
			'language' : language,
			'theme' : 'monokai'
		}, function(data) {
			window.location = 'compile/' + data;
		});
	});

});
$(window).on('load', function () {
	$('.selectpicker').selectpicker({
		'selectedText': "csharp"
	});
});
</script>