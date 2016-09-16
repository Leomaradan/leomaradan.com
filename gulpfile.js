const elixir = require('laravel-elixir');

require('laravel-elixir-vue');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

function bower(mix) {

	/** JavaScript */
	mix
		.scripts('../bower_components/bootstrap/dist/js/bootstrap.js', 'public/js/lib/')
		.scripts('../bower_components/bootstrap-markdown/js/bootstrap-markdown.js', 'public/js/lib/')
		.scripts('../bower_components/jquery-ui/jquery-ui.js', 'public/js/lib/')
		.scripts('../bower_components/jqueryui-timepicker-addon/dist/jquery-ui-timepicker-addon.js', 'public/js/lib/')
		.scripts('../bower_components/jqueryui-timepicker-addon/dist/jquery-ui-sliderAccess.js', 'public/js/lib/')
		
		.scripts('../bower_components/markdown/lib/markdown.js', 'public/js/lib/')
		.scripts('../bower_components/to-markdown/dist/to-markdown.js', 'public/js/lib/')
		.scripts('../bower_components/taggingJS/tagging.js', 'public/js/lib/')
	;

	/** CSS */
	mix
		.copy('resources/assets/bower_components/bootstrap-markdown/css/bootstrap-markdown.min.css', 'public/css/lib/bootstrap-markdown.css') // déja minifié
		.styles('../bower_components/jquery-ui/themes/ui-lightness/jquery-ui.css', 'public/css/lib/')
		
		.styles('../bower_components/jquery-ui-boostrap/css/custom-theme/jquery-ui-1.10.3.custom.css', 'public/css/lib/jquery-ui-custom.css')
		
		.styles('../bower_components/jqueryui-timepicker-addon/dist/jquery-ui-timepicker-addon.css', 'public/css/lib/')
		.styles('../bower_components/taggingJS/example/tag-basic-style.css', 'public/css/lib/')
	;

	/** Other resources */
	mix
		.copy('resources/assets/bower_components/jqueryui-timepicker-addon/dist/i18n/', 'public/js/lib/i18n/')
		.copy('resources/assets/bower_components/jquery-ui/themes/ui-lightness/images/', 'public/css/lib/images/')
		.copy('resources/assets/bower_components/jquery-ui-boostrap/css/custom-theme/images/', 'public/css/lib/images/')
		.copy('resources/assets/bower_components/bootstrap/dist/fonts/*', 'public/fonts/')
	;		
}

elixir(mix => {
    mix
       .sass('bootstrap.scss', 'public/css/lib/')
       .sass('backend.scss')
       .sass('style.scss')
       .webpack('lib.js')
       .scripts('backend.js')
       .scripts('app.js')
    ;

    bower(mix);
});
