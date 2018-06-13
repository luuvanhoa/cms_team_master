
CKEDITOR.editorConfig = function( config ) {
	config.language = 'vi';
	config.height	= 100;
	config.toolbar = [
  		{ name: 'basicstyles'	, items: [ 'Bold','Italic','Underline','Strike','-','RemoveFormat' ] },
  		{ name: 'colors'		, items: [ 'TextColor','BGColor' ] },
  		{ name: 'document'		, items: [ 'Source', 'Preview'] },
  	];
};
