# Relación de Ubigeos del Perú

> Datos JSON y SQL sobre departamentos, provincias y distritos del Perú.

## Directorio

```sh
.
├── js
│   └── ubigeo.js
├── json
│   ├── departamentos.json
│   ├── distritos.json
│   └── provincias.json
├── php
│   └── ubigeos.json.php
├── README.md
└── sql
    └── ubigeo.sql
```

## Estructura JSON
Estructura de un registro ubigeo

```json
{
  "id_ubigeo": "3789",
  "nombre_ubigeo": "Trujillo",
  "codigo_ubigeo": "01",
  "etiqueta_ubigeo": "Trujillo, La Libertad",
  "buscador_ubigeo": "trujillo la libertad",
  "numero_hijos_ubigeo": "11",
  "nivel_ubigeo": "2",
  "id_padre_ubigeo": "3788"
}
```

## Uso en Javascript

Se debe realizar las busquedas considerando la propiedad `id_ubigeo` o `id_padre_ubigeo` respectivamente.

Archivo: `js/ubigeo.js`

```js
var ubigeo = window.ubigeo

var departamentos = ubigeo.departamentos
var distritos     = ubigeo.distritos
var provincias    = ubigeo.provincias

// Obteniendo una provincia específica por `id_ubigeo`
var trujillo = provincias[3789]

// {
//  "id_ubigeo": "3789",
//  "nombre_ubigeo": "Trujillo",
//  "codigo_ubigeo": "01",
//  "etiqueta_ubigeo": "Trujillo, La Libertad",
//  "buscador_ubigeo": "trujillo la libertad",
//  "numero_hijos_ubigeo": "11",
//  "nivel_ubigeo": "2",
//  "id_padre_ubigeo": "3788"
//}
```

## Licencia

MIT license

© 2015 [José Luis Quintana](http://quintana.io)
