# Factor

API de consulta de datos de Stack Overflow

## Instalación

- **apache**: Copiar esta carpeta y crear un virtual host donde el document root 
apunte a la carpeta public de este proyecto.
- **docker**: ejecutar el comando docker-compose up

Ejecutar composer install en la carpeta del proyecto.

## Uso

La api está disponible en HostName/api p.e. localhost/api.
Esta api acepta 3 parametros:
- **tagged**: son las etiquetas por las que se desea buscar, este parametro es obligatorio
y se pueden especificar hasta 5 separados por ";"
- **fromdate**: fecha mínima de publicación de la pregunta, debe ser una fecha YYYY-MM-DD o 
un número (UNIX TIMESTAMP).
- **todate**: fecha máxima de publicación de la pregunta, acepta el mismo formato que fromdate.

Ejemplos:
localhost/api?tagged=symfony
localhost/api?tagged=symfony&fromdate=2021-05-01
localhost/api?tagged=symfony&todate=16743754