@extends('frontend.site')

@section('content')
<div class="content Masonry">
    <main>
        @yield('main')
    </main>
</div>
@stop

@section('style')
.grid-item {
  float: left;
  width: 80px;
  height: 60px;
  border: 2px solid hsla(0, 0%, 0%, 0.5);
}

.grid-item--width2 { width: 160px; }
.grid-item--height2 { height: 140px; }
@stop

@section('scripts')
<script type="text/javascript">
    $('main').masonry({
      itemSelector: 'article',
      columnWidth: 200
    });
</script>
@stop

  

  <div class="grid-item">
    <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/82/submerged.jpg" />
  </div>
  <div class="grid-item">
    <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/82/look-out.jpg" />
  </div>
  <div class="grid-item">
    <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/82/one-world-trade.jpg" />
  </div>
  <div class="grid-item">
    <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/82/drizzle.jpg" />
  </div>
  <div class="grid-item">
    <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/82/cat-nose.jpg" />
  </div>
  <div class="grid-item">
    <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/82/contrail.jpg" />
  </div>
  <div class="grid-item">
    <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/82/golden-hour.jpg" />
  </div>
  <div class="grid-item">
    <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/82/flight-formation.jpg" />
  </div>