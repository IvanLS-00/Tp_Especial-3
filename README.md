Tp_Especial 3
Esta es la documentación para usar la API de la tienda de ropa. La base de datos es la misma que la del trabajo anterior.

Endpoints

GET
http://localhost/TP_Especial 3/ropa

Obtiene todas las prendas cargadas.

Para ordenar: Se pueden pasar parámetros opcionales para ordenar la lista.

Ejemplo: http://localhost/TP_Especial 3/ropa?sort=precio&order=DESC

Parámetros:
sort: Campo por el cual ordenar (ej: precio, nombre, ropa_id, nombre_talle).
order: ASC (ascendente) o DESC (descendente).

http://localhost/TP_Especial 3/ropa/:id

Ejemplo: http://localhost/TP_Especial 3/ropa/9

Obtiene una prenda específica por su ID. Si no existe, devuelve error 404.


POST
http://localhost/TP_Especial 3/ropa

Agrega una nueva prenda. Se debe enviar el JSON en el body del request.

Body (JSON):

{
    "nombre": "Pantalon de Jean",
    "precio": 45000,
    "talle_id": 4
}

Requisitos:
nombre: Texto con el nombre de la prenda.
precio: Número con el valor de la prenda.
talle_id: El ID de un talle que ya exista en la base de datos.

Si falta algún dato, devuelve error 400.
Si se crea correctamente, devuelve código 201.


PUT
http://localhost/TP_Especial 3/ropa/:id

Ejemplo URL: http://localhost/TP_Especial 3/ropa/12

Modifica una prenda existente.

Body (JSON):

{
    "nombre": "Pantalon de Jean Negro",
    "precio": 55000,
    "talle_id": 2
}

Se deben enviar todos los campos para actualizar.

Si falta algún dato, devuelve error 400.
Si el ID de la prenda no existe, devuelve error 404.
