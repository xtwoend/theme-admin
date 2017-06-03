
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./plugins/trumbowyg/trumbowyg');
require('./plugins/trumbowyg/plugins/upload/trumbowyg.upload');
require('./plugins/trumbowyg/plugins/noembed/trumbowyg.noembed');
require('./plugins/trumbowyg/plugins/pasteimage/trumbowyg.pasteimage');
require('./plugins/trumbowyg/plugins/base64/trumbowyg.base64');
require('./plugins/trumbowyg/plugins/insertaudio/trumbowyg.insertaudio');
require('./plugins/trumbowyg/plugins/table/trumbowyg.table');
require('./plugins/datetimepicker');
require('./plugins/jquery.slimscroll.min');
require('./plugins/timecircles/TimeCircles');
require('./plugins/jquery.form');
// require('./plugins/jquery.filer.js');
require('./app/bajax');
require('./app/jq-grid');
require('./app/app');
require('./app/app.plugin');

// require('./plugins/trumbowyg/plugins/cleanpaste/trumbowyg.cleanpaste');
require('sweetalert');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app'
});
