/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */
	//CKEDITOR.replace( 'ckeditor',{});

	
	CKEDITOR.config.extraPlugins = 'insertpre';
	CKEDITOR.config.toolbar =
			[
				[ 'Bold','Italic','Underline','Strike'],
				['Link','Unlink'],
				['Undo','Redo'],
				['Code'],
				[ 'NumberedList','BulletedList','-','Blockquote','InsertPre'] ,
			];
	
	// Remove some buttons, provided by the standard plugins, which we don't
	// need to have in the Standard(s) toolbar.
	//CKEDITOR.config.removeButtons = 'Subscript,Superscript';

	// Se the most common block elements.
	CKEDITOR.config.format_tags = 'p;h1;h2;h3';

	// Make dialogs simpler.
	//CKEDITOR.config.removeDialogTabs = 'image:advanced;link:advanced';

