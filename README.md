# TP Especial Web 2 - API REST Buscador de Conciertos

## Descripción
API REST desarrollada para el Trabajo Práctico Especial de Programación Web 2.
La API permite consultar y administrar bandas musicales y sus respectivos conciertos almacenados en la base de datos del sistema.

---

## Instalación
1. Clonar el repositorio dentro de la carpeta `htdocs` de XAMPP.
2. Iniciar los servicios Apache y MySQL desde el panel de control de XAMPP.
3. Acceder a los endpoints mediante:
```text
http://localhost/tp-web2-api/api
```

---

# Endpoints de Bandas

## Obtener todas las bandas
Retorna la colección completa de bandas.

### Request
```http
GET /api/bandas
```

### Respuesta
**Código:** 200 OK
```json
[
  {
    "id_banda": 1,
    "nombre": "Divididos",
    "genero": "Rock",
    "pais_de_origen": "Argentina",
    "img": "",
    "descripcion": "La aplanadora del rock."
  }
]
```

---

## Filtrar bandas por género
Permite obtener únicamente las bandas pertenecientes a un género determinado.

### Request
```http
GET /api/bandas?genero=Rock
```

### Ejemplos
```http
GET /api/bandas?genero=Rock
```
```http
GET /api/bandas?genero=Heavy Metal
```
```http
GET /api/bandas?genero=Thrash Metal
```

### Respuesta
**Código:** 200 OK
```json
[
  {
    "id_banda": 1,
    "nombre": "Divididos",
    "genero": "Rock",
    "pais_de_origen": "Argentina",
    "img": "",
    "descripcion": "La aplanadora del rock."
  }
]
```

---

## Obtener una banda por ID
Obtiene una banda específica mediante su identificador.

### Request
```http
GET /api/bandas/:id
```

### Ejemplo
```http
GET /api/bandas/1
```

### Respuesta exitosa
**Código:** 200 OK
```json
{
  "id_banda": 1,
  "nombre": "Divididos",
  "genero": "Rock",
  "pais_de_origen": "Argentina",
  "img": "",
  "descripcion": "La aplanadora del rock."
}
```

### Banda inexistente
**Código:** 404 Not Found
```json
"No existe la banda"
```

---

## Crear una banda
Permite registrar una nueva banda en la base de datos.

### Request
```http
POST /api/bandas
```

### Body
```json
{
  "nombre": "Rata Blanca",
  "genero": "Heavy Metal",
  "pais_de_origen": "Argentina",
  "img": "",
  "descripcion": "Banda argentina de heavy metal."
}
```

### Respuesta exitosa
**Código:** 201 Created
```json
{
  "mensaje": "Banda creada",
  "id_banda": 3
}
```

### Datos incompletos
**Código:** 400 Bad Request
```json
"Faltan completar datos"
```

---

## Paginación de bandas
Permite obtener una colección de bandas paginada.

### Request
```http
GET /api/bandas?page=1&limit=2
```

### Parámetros

| Parámetro | Descripción                       |
| --------- | ---------------------------------- |
| page      | Número de página                  |
| limit     | Cantidad de elementos por página  |

### Ejemplos
```http
GET /api/bandas?page=1&limit=2
```
```http
GET /api/bandas?page=2&limit=2
```

### Respuesta
**Código:** 200 OK
```json
[
  {
    "id_banda": 1,
    "nombre": "Divididos",
    "genero": "Rock",
    "pais_de_origen": "Argentina",
    "img": "",
    "descripcion": "La aplanadora del rock."
  },
  {
    "id_banda": 2,
    "nombre": "Metallica",
    "genero": "Thrash Metal",
    "pais_de_origen": "Estados Unidos",
    "img": "",
    "descripcion": "Banda legendaria."
  }
]
```

---

# Endpoints de Conciertos

## Obtener todos los conciertos (Ordenado)
Retorna la colección completa de conciertos. Permite ordenar opcionalmente de forma ascendente o descendente por cualquier columna de la tabla.

### Request
```http
GET /api/conciertos
```

### Parámetros de consulta opcionales

| Parámetro | Descripción | Valores válidos | Valor por defecto |
| --------- | ----------- | --------------- | ----------------- |
| orderBy   | Campo por el cual ordenar | `id_concierto`, `fecha`, `lugar`, `ciudad`, `id_banda`, `precio_platea`, `precio_campo`, `precio_popular` | `id_concierto` |
| order     | Sentido de la ordenación | `ASC`, `DESC` | `ASC` |

### Ejemplos
```http
GET /api/conciertos?orderBy=fecha&order=DESC
```
```http
GET /api/conciertos?orderBy=precio_campo&order=ASC
```

### Respuesta
**Código:** 200 OK
```json
[
  {
    "id_concierto": 1,
    "fecha": "2026-10-15",
    "lugar": "Estadio Vélez Sarsfield",
    "ciudad": "Buenos Aires",
    "id_banda": 1,
    "precio_platea": 15000,
    "precio_campo": 10000,
    "precio_popular": 6000
  }
]
```

---

## Modificar un concierto
Actualiza los datos de un concierto existente a través de su identificador.

### Request
```http
PUT /api/conciertos/:id
```

### Ejemplo
```http
PUT /api/conciertos/1
```

### Body
```json
{
  "fecha": "2026-10-16",
  "lugar": "Estadio Vélez",
  "ciudad": "CABA",
  "id_banda": 1,
  "precio_platea": 18000,
  "precio_campo": 12000,
  "precio_popular": 7000
}
```

### Respuesta exitosa
**Código:** 200 OK
```json
{
  "id_concierto": 1,
  "fecha": "2026-10-16",
  "lugar": "Estadio Vélez",
  "ciudad": "CABA",
  "id_banda": 1,
  "precio_platea": 18000,
  "precio_campo": 12000,
  "precio_popular": 7000
}
```

### Datos incompletos o inválidos
**Código:** 400 Bad Request
```json
"Faltan completar datos"
```

### Concierto inexistente
**Código:** 404 Not Found
```json
"No existe el concierto"
```

---

# Códigos HTTP utilizados

| Código | Descripción                       |
| ------ | --------------------------------- |
| 200    | Operación realizada correctamente |
| 201    | Recurso creado correctamente      |
| 400    | Datos inválidos o incompletos     |
| 404    | Recurso no encontrado             |

---

# Funcionalidades implementadas

### Requerimientos obligatorios
* Obtener una colección entera ordenada (GET) - Miembro A
* Modificar una entidad existente (PUT) - Miembro A
* Obtener una entidad por ID (GET) - Miembro B
* Crear una entidad (POST) - Miembro B
* Manejo de códigos HTTP 200, 201, 400 y 404 - Miembros A y B

### Requerimientos optativos
* Ordenado por cualquier campo de la tabla - Miembro A
* Filtrado de colecciones mediante parámetros de consulta - Miembro B
* Paginación de colecciones mediante parámetros de consulta - Miembro B

---

# Autores
* Hernandez German - Parte A, Ordenado por cualquier campo de la tabla
* Cuchiarelli Juan Bautista - Parte B, Filtrado y Paginación de colecciones mediante parámetros de consulta
