@extends('master')
<!-- Judul Halaman disini -->
@section('title', 'Peta Witel Maluku')

<!-- Insert tambahan CSS disini -->
@section('added_css')
<style>
  /* Set the size of the div element that contains the map */
#map {
  height: 500px;  /* The height is 500 pixels */
  width: 100%;  /* The width is the width of the web page */
  }
</style>
@stop

@section('content')
<div class="row">
  <div class="col-md-12">
      <div id="map"></div>
  </div>
<!-- /.col -->
</div>
<!-- /.row -->
@stop

@section('added_script')
<script>
        function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: new google.maps.LatLng(-3.6959109, 128.180494),
          zoom: 11
        });
		    map.setTilt(45);
        var infoWindow = new google.maps.InfoWindow;

          // Change this depending on the name of your PHP or XML file
          downloadUrl('http://localhost/witel/xml.php', function(data) {
            var xml = data.responseXML;
            var markers = xml.documentElement.getElementsByTagName('marker');
            Array.prototype.forEach.call(markers, function(markerElem) {
              var DATEL = markerElem.getAttribute('DATEL');
              var ODP_NAME = markerElem.getAttribute('ODP_NAME');
              var point = new google.maps.LatLng(
                  parseFloat(markerElem.getAttribute('lat')),
                  parseFloat(markerElem.getAttribute('lng')));

              var infowincontent = document.createElement('div');
              var strong = document.createElement('strong');
              strong.textContent = ODP_NAME
              infowincontent.appendChild(strong);
              infowincontent.appendChild(document.createElement('br'));

              var text = document.createElement('text');
              text.textContent = DATEL
              infowincontent.appendChild(text);
              var marker = new google.maps.Marker({
                map: map,
                position: point
              });
              marker.addListener('click', function() {
                infoWindow.setContent(infowincontent);
                infoWindow.open(map, marker);
              });
            });
          });
        }



      function downloadUrl(url, callback) {
        var request = window.ActiveXObject ?
            new ActiveXObject('Microsoft.XMLHTTP') :
            new XMLHttpRequest;

        request.onreadystatechange = function() {
          if (request.readyState == 4) {
            request.onreadystatechange = doNothing;
            callback(request, request.status);
          }
        };

        request.open('GET', url, true);
        request.send(null);
      }

      function doNothing() {}
    </script>
	
<script async defer
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD-LQbkGW4BGrVcB_sFV157dmtrZmbMvOI&callback=initMap">
</script>
@stop
