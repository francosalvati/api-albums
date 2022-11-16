Esta es un api RESTfull de albums,

otorga:
    -una lista de albums.
    -se puede eliminar filas
    -con un token se puede insertar o modificar filas.

Importar la base de datos

usuario = admin1
contrasenia = admin1



(get)
El endpoint de la API es: http://localhost/API/api/albums
(delete)
El endpoint de la API es: http://localhost/API/api/albums/:ID
(get)
El endpoint de la API es: http://localhost/API/api/albums/:ID
(edit)
El endpoint de la API es: http://localhost/API/api/albums/:ID/
(insert)
El endpoint de la API es: http://localhost/API/api/albums/

:token = 1

para ordenar =  sort = "columna"
                order= "ASC or DESC"

para filtrar =  search = "filtro"

para paginar =  limit = "cantidad de filas"
                page = "numero de pagina"