var mymap = L.map('mapid').setView([9.8536, -83.9104], 16);


L.tileLayer('https://{s}.tile.openstreetmap.de/tiles/osmde/{z}/{x}/{y}.png', {
    maxZoom: 18,
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(mymap);

rutas = [{
    "puntos": [9.864687, -83.915012],
    "lugar": "Compubetel",
    "icono": "icons/compubetel.png"
}, {
    "puntos": [9.863826, -83.924817],
    "lugar": "Extremetech",
    "icono": "icons/extremetech.png"
}, {
    "puntos": [9.867463, -83.930703],
    "lugar": "Intelec",
    "icono": "icons/intelec.png"
}, {
    "puntos": [9.865359, -83.923612],
    "lugar": "Laptop Center",
    "icono": "icons/laptop.png"
}, {
    "puntos": [9.863331, -83.921193],
    "lugar": "Zona Gamer",
    "icono": "icons/zona.png"
}, {
    "puntos": [9.863499, -83.917341],
    "lugar": "JC Support",
    "icono": "icons/jc.png"
}
]

var markers = L.markerClusterGroup();
var listaRutas = [];

rutas.forEach(direcc => {
    var [lati, longi] = direcc.puntos;
    listaRutas.push([lati, longi]);
    var nombre = direcc.lugar;
    var img = direcc.icono;
    var marcaIcono = L.icon({ iconUrl: img });
    var marker = L.marker([lati, longi], { icon: marcaIcono }).bindPopup(nombre);
    markers.addLayer(marker);
});

mymap.addLayer(markers);

var direcciones = [];
listaRutas.forEach(direcc => {
    direcciones.push(L.latLng(direcc[0], direcc[1]));
})
L.Routing.control({
    waypoints: direcciones
}).addTo(mymap);





