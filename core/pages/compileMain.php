<?php
if(!isUserLoggedIn())
{
  #redirect('logout');
}
$url = $f3->get('PARAMS.id');
$sourceDraft = DB::queryFirstRow("SELECT * FROM CWM_SourceDraft WHERE Url=%?", $url);
$sourceLanguage = $sourceDraft['Language'];
$sourceContent = htmlentities($sourceDraft['Content']);
$sourceTheme = $sourceDraft['Theme'];

require_once $GLOBALS['dirCore'].'/view/standard/header.inc.php';
?>
<link rel="stylesheet" type="text/css" href="<?php echo $GLOBALS['urlLibs']; ?>/external/typeahead/typeahead.js-bootstrap.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $GLOBALS['urlCore']; ?>/view/standard/css/compiler.css" />

<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">

    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="./">CodeWithMe</a>
    </div>
    <div class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
        <li><a id="save" href="#"><span class="glyphicon glyphicon-floppy-disk"></span> Save changes</a></li>
        <li class="active"><a id="compile" href="#"><span class="glyphicon glyphicon-cog"></span> Compile & Run</a></li>
        <li><a href="#">Theme:</a></li>
        <li style="padding-top:7px;">
          <select id="theme" class="selectpicker" data-live-search="true"></select>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-list"></span> More... <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a id="fork" href="#"> <span class="glyphicon glyphicon-random"></span> Fork</a></li>
            <!--<li class="divider"></li>
            <li class="dropdown-header"></li>-->
            <li><a id="download" href="#"> <span class="glyphicon glyphicon-download-alt"></span> Download</a></li>
            <li class="divider"></li>
            <li><a id="delete" href="#"> <span class="glyphicon glyphicon-trash"></span> Delete</a></li>
          </ul>
        </li>
      </ul>
      <!--<div class="col-sm-3 col-md-3">
        <form class="navbar-form" role="search">
          <input id="programming-language" class="form-control typeahead tt-query" type="text" placeholder="Programming language..." autocomplete="off" spellcheck="false" dir="auto" style="position: relative; vertical-align: top;">
        </form>
        <select id="programming-language" class="selectpicker" data-live-search="true"></select>
      </div>-->
    </div><!--/.nav-collapse -->

</div>
<div id="editor"><?php echo $sourceContent; ?></div>
<div id="outputContainer">
  <div class="super-container">
         <div id="output" class="aspect-critical-content">

         </div>
     </div>
</div>
  <!--<div id="output">
    <div class="head">Output:</div>
    <div class="body">
      <div class="content"></div>
    </div>
  </div>-->
</div>

<?php include $GLOBALS['dirCore'].'/view/standard/footer.inc.php'; ?>

<script src="<?php echo $GLOBALS['urlLibs']; ?>/external/typeahead/typeahead.js" type="text/javascript" charset="utf-8"></script>

<script src="<?php echo $GLOBALS['urlLibs']; ?>/external/ace-builds/src-noconflict/ace.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
  var sourceLang = "<?php echo $sourceLanguage; ?>";
  var url = "<?php echo $url; ?>";
  var themeBase = "ace/theme/";


  var editor = ace.edit("editor");
  var editorMode = sourceLang;
  if(sourceLang == 'c' || sourceLang == 'cpp') {
    editorMode = 'c_cpp';
  }
  else if(sourceLang == 'vbnet') {
    editorMode = 'vbscript';
  }
  else if(sourceLang == 'processing') {
    editorMode = 'java';
  }
  editor.getSession().setMode("ace/mode/" + editorMode);


  function getSourceCode() {
    return editor.getValue();
  }

  function getTheme() {
    return editor.getTheme().replace(themeBase, "");
  }

  function updateOutputWindow() {
    setTimeout(function() {
      bgColor = $('#editor').css('background-color');
      //rgb = invert(bgColor);
      //r = bgColor.split(16);
      rgb = bgColor.replace(/^(rgb|rgba)\(/,'').replace(/\)$/,'').replace(/\s/g,'').split(',');

      r = 255 - rgb[0];
      g = 255 - rgb[0];
      b = 255 - rgb[0];
      rgbInvert = "rgba("+r+","+g+","+b+",1)";

      //alert(rgbInvert);
      //txtColor = rgbToHex(invert(bgColor));
      //alert(bgColor);
      //alert(txtColor);
      $('#output').css('background-color', bgColor).css('color', rgbInvert);
    }, 50);
  }

  function invert(rgb) {
    rgb = [].slice.call(arguments).join(",").replace(/rgb\(|\)|rgba\(|\)|\s/gi, '').split(',');
    for (var i = 0; i < rgb.length; i++) rgb[i] = (i === 3 ? 1 : 255) - rgb[i];
    return rgb;
    //return rgb.join(", ");
  }

  function rgbToHex(r, g, b) {
    return "#" + componentToHex(r) + componentToHex(g) + componentToHex(b);
  }

  function componentToHex(c) {
    var hex = c.toString(16);
    return hex.length == 1 ? "0" + hex : hex;
  }

  $(function() {


    $('#editor').css('top', $('.navbar').height());

    $('.aspect-critical-content').css('padding-top', $('.navbar').height());
    //$('#output2').height($('#output').height() - $('.navbar').height());
    /*$('.typeahead').typeahead({
      prefetch: "<?php echo $GLOBALS['urlLibs']; ?>/internal/ide/data/languages.json",
      limit: 10
    });*/

    CompileLib.loadLanguages("#programming-language",
                  "<?php echo $GLOBALS['urlLibs']; ?>/internal/ide/data/languages.json",
                  "<?php echo $sourceLanguage; ?>");



    $.getJSON("<?php echo $GLOBALS['urlLibs']; ?>/internal/ide/data/editor_skins.json", function(data) {
      var c = 0;
      $.each(data, function(key, val) {
        theme = "chrome";
        $('#theme').append($('<optgroup id="' + key + '" label="' + key + '">'));
        $.each(data[key], function(key2, val2) {
          option = $('<option />').attr('value', themeBase + val2).text(val2);
          if(val2 === "<?php echo $sourceTheme; ?>") {
            theme = val2;
            option.attr("selected", "selected");
          }
          $('#theme #' + key).append(option);
        });
        $('#theme').append($('</optgroup>'));
        editor.setTheme(themeBase+theme);
        updateOutputWindow();

      });
    });

    setTimeout(function() {
      $('#compile').trigger('click');
    }, 250);

    $("#theme").on('change', function(e) {
      editor.setTheme($(this).val());
      updateOutputWindow();

    });

    function write(val) {
      $("#output").html(val);
    }

    function writeln(val) {
      $("#output").html(val + "<br />");
    }

    updateOutputWindow();
    //$('#programming-language').val("<?php echo $sourceLanguage; ?>");

    /*editor.find('n = ',{
      backwards: false,
      wrap: false,
      caseSensitive: false,
      wholeWord: false,
      regExp: false
    });*/

    // events

    $('#save').click(function(e) {
      writeln("Saving changes...");
      $.post("<?php echo $GLOBALS['urlLibs']; ?>/internal/ide/controller/saveSourceDraft.php",
        {
          'url' : url,
          'content' : getSourceCode(),
          'theme' : getTheme()
        })
        .done(function(data) {
          writeln("Done saving!");
        });
    });

    $('#delete').click(function(e) {
      $.post("<?php echo $GLOBALS['urlLibs']; ?>/internal/ide/controller/deleteSourceDraft.php",
        {
          'url' : url,
          'language' : sourceLang
        })
        .done(function(data) {
          if(parseInt(data) === 1) {
            window.location = '../compile';
          }
        });
    });

    $('#fork').click(function(e) {
      $.post("<?php echo $GLOBALS['urlLibs']; ?>/internal/ide/controller/createSourceDraft.php", {
        'language' : sourceLang,
        'theme' : getTheme(),
        'content' : getSourceCode()
      }, function(data) {
        window.location = data;
      });
      /*$.post("<?php echo $GLOBALS['urlCore']; ?>/controller/forkSourceDraft.php",
        {
          'url' : url
        })
        .done(function(data) {
          window.location = '../compile/'+data;
        });*/
    });

    $('#download').click(function(e) {
      CWMCommon.DownloadFile("<?php echo $GLOBALS['urlLibs']; ?>/internal/ide/controller/downloadSourceDraft.php?fileName=" + url + "&fileExtension=.txt", "text/plain");
    });

    $('#compile').click(function(e) {

      //var sourceLang = "<?php echo $sourceLanguage; ?>";//$('#programming-language option:selected').val();
      langInfo = CompileLib.getLanguageInfo(sourceLang);
      /*alert(langInfo === null);
      if(langInfo === null) {
        alert("error: no languages loaded!");
      }*/
      //alert(langInfo);
      if(langInfo['type'] == "web") {
        $.post("<?php echo $GLOBALS['urlLibs']; ?>/internal/ide/controller/saveWebFile.php", {
            'content' : getSourceCode(),
            'file' : sourceLang+"/hello."+langInfo['ext']
          })
          .done(function(data) {
            //alert(data);
            if(data.indexOf("0 errors") !== -1) {
              //alert("OK");
            }
            $("#output")
              .html($('<iframe>')
              .attr('width', '100%')
              .attr('height', '100%')
              .attr('src', "<?php echo $GLOBALS['urlLibs']; ?>/internal/ide/web_render/"+sourceLang));
        });
      }
      else {
        $('#output').html("Compiling...<br />");
        $.post("<?php echo $GLOBALS['urlLibs']; ?>/internal/ide/controller/compile.php",
          {
            'url' : url,
            'content' : getSourceCode(),
            'language' : sourceLang
          })
          .done(function(data) {
            jsonData = JSON.parse(data);
            //alert(JSON.stringify(jsonData));
            buildStatus = parseInt(jsonData['buildStatus']);
            executeStatus = parseInt(jsonData['executeStatus']);
            buildResult = jsonData['output'];
            //alert(buildStatus);
            if(buildStatus != 0) {
              switch(buildStatus) {
                case 1:
                  buildStatusMessage =  "General error";
                break;
              }
              $('#output').append("Error code: " + buildStatus + "<br />Error message: " + buildStatusMessage + "<br />");
            }
            if(buildStatus !== 0) {
             // alert("error");
              buildResult = "";
              $('#output').append("Error compiling!<br />" + jsonData['log'] + "<br />");
            }

            /*if(data.indexOf("0 errors") !== -1) {
              //alert("OK");
            }*/
            $('#output').append("Result:<br />" + buildResult);
        });
      }
    });

  });

  $(window).on('load', function () {
    $('.selectpicker').selectpicker({
      'selectedText': "<?php echo $sourceLanguage; ?>"
    });
  });

</script>