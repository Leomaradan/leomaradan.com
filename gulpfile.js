const elixir = require('laravel-elixir');

require('laravel-elixir-vue');

elixir.config.sourcemaps = false;

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
            .scripts('../bower_components/jquery/dist/jquery.js', 'public/js/lib/')
            .scripts(['../bower_components/bootstrap/dist/js/bootstrap.js', 
                      '../bower_components/bootstrap-combobox/js/bootstrap-combobox.js'], 'public/js/lib/bootstrap.js')
    
            .scripts(['../bower_components/markdown/lib/markdown.js', 
                      '../bower_components/to-markdown/dist/to-markdown.js',
                      '../bower_components/bootstrap-markdown/js/bootstrap-markdown.js'], 'public/js/lib/markdown.js')
                  
            .scripts(['../bower_components/jquery-ui/jquery-ui.js',
                      '../bower_components/jqueryui-timepicker-addon/dist/jquery-ui-timepicker-addon.js',
                      '../bower_components/jqueryui-timepicker-addon/dist/jquery-ui-sliderAccess.js'], 'public/js/lib/jquery-ui.js')
		
            .scripts(['sortable.js', '../bower_components/masonry/dist/masonry.pkgd.js', '../bower_components/taggingJS/tagging.js'], 'public/js/lib/jquery.plugins.js')
	;

	/** CSS */
	mix
		.copy('resources/assets/bower_components/bootstrap-markdown/css/bootstrap-markdown.min.css', 'public/css/lib/markdown.css') // déja minifié
		
                .styles(['../bower_components/jquery-ui/themes/ui-lightness/jquery-ui.css', 
                         '../bower_components/jquery-ui-boostrap/css/custom-theme/jquery-ui-1.10.3.custom.css',
                         '../bower_components/jqueryui-timepicker-addon/dist/jquery-ui-timepicker-addon.css'], 'public/css/lib/jquery-ui.css')

		.styles('../bower_components/taggingJS/example/tag-basic-style.css', 'public/css/lib/jquery.plugins.css')
	;

	/** Other resources */
	mix
		.copy('resources/assets/bower_components/jqueryui-timepicker-addon/dist/i18n/', 'public/js/lib/i18n/')
		.copy('resources/assets/bower_components/jquery-ui/themes/ui-lightness/images/', 'public/css/lib/images/')
		.copy('resources/assets/bower_components/jquery-ui-boostrap/css/custom-theme/images/', 'public/css/lib/images/')
		.copy('resources/assets/bower_components/bootstrap/dist/fonts/*.*', 'public/fonts/')
	;		
}

elixir(mix => {
    mix
       .sass(['bootstrap.scss', '../bower_components/bootstrap-combobox/css/bootstrap-combobox.css'], 'public/css/lib/bootstrap.css')
       .sass('backend.scss')
       .sass('style.scss')
       .webpack('lib.js')
       .scripts('backend.js')
       .scripts(['parallax.js','app.js'], 'public/js/app.js')
       .copy('resources/assets/fonts/*.*', 'public/fonts/')
    ;
    
    bower(mix);
       
});