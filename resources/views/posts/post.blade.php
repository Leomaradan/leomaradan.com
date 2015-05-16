@section('content')    
@parent    
	<div class="blog-post">
		@if ($image) 
		<img src='{{ asset('images/blog/' . $image) }}' class="img-responsive">
		@endif
		<h2 class="blog-post-title">{{ $titre }}</h2>
		<p class="blog-post-meta">le {{ $date }} par <a href="#">Léo</a></p>

		{!! Markdown::convertToHtml($contenu) !!}

		@if(isset($url))
		<p><a href="{{ $url }}">Lire la suite</a></p>			
		@endif

		@if(isset($disqus))
		<div id="disqus_thread"></div>
		<script type="text/javascript">
		/* * * CONFIGURATION VARIABLES * * */
		var disqus_shortname = 'leomardan';
	    var disqus_identifier = '{{ $disqus['id'] }}';
	    var disqus_title = '{{ $titre }}';
	    var disqus_url = '{{ $disqus['url'] }}';

		/* * * DON'T EDIT BELOW THIS LINE * * */
		(function() {
		    var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
		    dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
		    (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
		})();
		</script>
		<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript" rel="nofollow">comments powered by Disqus.</a></noscript>
		@endif
    </div>
@stop