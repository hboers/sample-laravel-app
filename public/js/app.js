(function() {
  var element, i, len, mapTypeIds, rapyd_grid_action, rapyd_grid_table, ref, type;

  rapyd_grid_action = $("a span.glyphicon.glyphicon-eye-open");

  rapyd_grid_action.parents('td').hide();

  rapyd_grid_table = rapyd_grid_action.parents('table');

  rapyd_grid_table.find('th:last-child').hide();

  rapyd_grid_table.find('td').on('click', (function(_this) {
    return function(event) {
      var location, show;
      show = $(event.target).parent('tr').find('a span.glyphicon.glyphicon-eye-open');
      if (show) {
        location = $(show).parent().attr("href");
        if (location) {
          return window.location = location;
        }
      }
    };
  })(this));

  element = document.getElementById("map_canvas");

  if (element) {
    mapTypeIds = [];
    ref = google.maps.MapTypeId;
    for (i = 0, len = ref.length; i < len; i++) {
      type = ref[i];
      mapTypeIds.push(google.maps.MapTypeId[type]);
    }
    mapTypeIds.push("OSM");
    element.mapTypeIds = mapTypeIds;
    element.dummy = function() {
      return alert("Dummy called");
    };
    element.marker = function(lat, lng, title) {
      var marker, options;
      options = {
        position: new google.maps.LatLng(lat, lng),
        map: element.map,
        title: title
      };
      return marker = new google.maps.Marker(options);
    };
    element.getTileUrl = function(coord, zoom) {
      return "http://tile.openstreetmap.org/" + zoom + "/" + coord.x + "/" + coord.y + ".png";
    };
    element.create = function(lat, lng) {
      var mapOptions, tileOptions;
      mapOptions = {
        center: new google.maps.LatLng(lat, lng),
        zoom: 15,
        mapTypeId: "OSM",
        mapTypeControlOptions: {
          mapTypeIds: mapTypeIds
        }
      };
      tileOptions = {
        getTileUrl: element.getTileUrl,
        tileSize: new google.maps.Size(256, 256),
        name: "OpenStreetMap",
        maxZoom: 18
      };
      element.map = new google.maps.Map(element, mapOptions);
      return element.map.mapTypes.set("OSM", new google.maps.ImageMapType(tileOptions));
    };
    element.zoom = function(zoom) {
      return alert("zoom not implemented");
    };
    element.center = function(lat, lng) {
      return alert("center not implemented");
    };
  }

  $('form .autofocus').focus();


  /* is replaced by css
  $(window).on "resize", (event) ->
  
    ## Handle Map resizing
    element = $("map_canvas")
    if element
      mapWidth = element.width()
      if mapWidth
        element.height width
   */

}).call(this);

//# sourceMappingURL=app.js.map