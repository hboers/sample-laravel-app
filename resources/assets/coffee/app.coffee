
# *** Rapyd  Functions ***

# hide hide the last grid column

rapyd_grid_action = $("a span.glyphicon.glyphicon-eye-open")
rapyd_grid_action.parents('td').hide()
rapyd_grid_table = rapyd_grid_action.parents('table')
rapyd_grid_table.find('th:last-child').hide()
rapyd_grid_table.find('td').on 'click', (event) =>
  show = $(event.target).parent('tr').find('a span.glyphicon.glyphicon-eye-open')
  if  show
    location = $(show).parent().attr "href"
    if location
      window.location = location

# *** Map Functions ***

element = document.getElementById "map_canvas"
if element

  # mapTypeIds with Open Street Map
  mapTypeIds = []
  for type in google.maps.MapTypeId
    mapTypeIds.push(google.maps.MapTypeId[type])
  mapTypeIds.push "OSM"
  element.mapTypeIds = mapTypeIds

  # Dummy for test only
  element.dummy = () ->
    alert("Dummy called")

  element.marker = (lat,lng, title) ->
    options =
       position: new google.maps.LatLng(lat, lng),
       map: element.map,
       title: title 
    marker = new google.maps.Marker(options)

  # Setup for OSM  
  element.getTileUrl = (coord, zoom) ->
    return "http://tile.openstreetmap.org/" + zoom + "/" + coord.x + "/" + coord.y + ".png"
    
  # Create a map
  element.create = (lat,lng) ->

    mapOptions =
      center: new google.maps.LatLng(lat, lng)
      zoom: 15
      mapTypeId: "OSM"
      mapTypeControlOptions:
        mapTypeIds: mapTypeIds

    tileOptions =
      getTileUrl: element.getTileUrl
      tileSize: new google.maps.Size(256, 256)
      name: "OpenStreetMap"
      maxZoom: 18

    element.map = new google.maps.Map(element, mapOptions)

    element.map.mapTypes.set("OSM", new google.maps.ImageMapType(tileOptions))
   
  # zoom map  
  element.zoom = (zoom) ->
    alert("zoom not implemented")

  # center map  
  element.center = (lat,lng) ->
    alert("center not implemented")


# *** Form handling **
$('form .autofocus').focus()


# *** Resize window handling **

### is replaced by css
$(window).on "resize", (event) ->

  ## Handle Map resizing
  element = $("map_canvas")
  if element
    mapWidth = element.width()
    if mapWidth
      element.height width
###
