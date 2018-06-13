
CKEDITOR.editorConfig = function( config ) {
	config.language = 'vi';
	config.height	= 500;
  	config.toolbarGroups = [
	    { name: 'links' },
	    { name: 'insert' },
	    { name: 'tools' },
	    { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
	    { name: 'paragraph',   groups: [ 'list', 'blocks', 'align'] },
	    { name: 'styles' },
	    { name: 'colors' },
	    { name: 'about' }
	];
};
