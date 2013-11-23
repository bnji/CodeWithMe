var CompileLib = {

  languages : {},

  getLanguageInfo : function(name) {
    if(_.size(languages) !== 0)
      return languages[name];
    else
      return null;
  },

  loadLanguages : function(id, url, selLang) {
    $.getJSON(url, function(data) {
      languages = data;
      $.each(data, function(key, val) {
        var option = $("<option></option>")
                    .attr("value",val['name'])
                    .text(val['name']);
        if(val === selLang) {
          option.attr("selected", "selected");
        }
        $(id).append(option);
      });
    });
  },
  generateFile : function(url, selectId, fileFullName, onSuccess) {
    $.post(url, {
            'selectId' : selectId,
            'fileFullName' : fileFullName
          })
          .done(function(data) {
            onSuccess(data);
        });
  }
}