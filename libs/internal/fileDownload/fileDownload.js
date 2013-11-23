(function($){

	$.fn.downloadFile = function(fileName, fileFullName, contentType) {
		baseUrl = location.protocol + '//' + document.domain + '/CodeWithMe/libs/internal/fileDownload';
		//alert(location.protocol);
		$('body').append(
						$('<iframe></iframe>')
						.attr('src', baseUrl + '/fileDownload.php?fileName=' + fileName + '&fileFullName=' + fileFullName + '&contentType=' + contentType)
						.remove()
		);
	}
}(jQuery));