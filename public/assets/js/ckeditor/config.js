/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
    // Define changes to default configuration here. For example:
    // config.language = 'fr';
    // config.uiColor = '#AADC6E';
    
    config.allowedContent = true;
    config.extraAllowedContent = 'p h1[*]';
    CKEDITOR.dtd.$removeEmpty['i'] = false;
    
    config.filebrowserBrowseUrl = base_url+'assets/admin/ckeditor/browse.php?type=images',
    config.filebrowserUploadUrl = base_url+'assets/admin/ckeditor/upload.php?type=images',
    config.filebrowserImageWindowWidth = '720',
    config.filebrowserImageWindowHeight = '540';
};
