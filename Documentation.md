# Documentación de la API creada en Laravel
## Instalación:
Esta aplicación esta pensada para ser ejecutada en un entorno de docker. Necesitaremos tener instalado docker y docker-compose en el ordenador el cual pretendamos instalarla.

### 1. Instalar docker
- Sistema operativo **__Windows__**: Deberemos seguir esta [guía][docker_install_windows] para instalar la aplicación docker desktop en nuestro ordenador.
- Sistema operativo **__Mac__**: Deberemos seguir esta [guía][docker_install_mac] para instalar la aplicación docker desktop en nuestro ordenador.
- Sistema operativo **__Linux__**: Deberemos seguir esta [guía][docker_install_windows] para instalar el motor de docker en nuestro ordenador. Para instalar docker-compose en linux debemos de seguir esta [guia][docker_compose_install_linux].

### 2. Levantar contenedores docker.
Debemos de copiar el archivo **__.env.example__** y el nuevo archivo resultante le llamamos **__.env__**.

Una vez tengamos docker y docker-compose instalado correctamente en nuestro ordenador, nos iremos a la terminal de nuestro ordenador e iremos a la raiz del proyecto. Una vez allí ejecutaremos el comando
~~~
docker-compose up -d
~~~
Este proceso nos tiene que informar de que los 3 contenedores se han creado correctamente.

### 3. Configurar proyecto
Accediendo al contenedor de docker **__tornado-app__** debemos ejecutar:
~~~~
composer install
~~~~
Esto nos instalará todas las dependecias del proyecto.

Ahora ejecutaremos
~~~~
php artisan migrate
~~~~
Con este comando, crearemos todas las tablas de la base de datos necesarias para el correcto funcionamiento de la aplicación.

Con estos dos pasos, ya podremos solicitar cualquier endpoint a la aplicación a traves de la url **__http://localhost:8082__**
## Endpoints:

**LIBROS:**
### **GET**: __'/api/books/'__
Con este endpoint obtendremos todos los libros almacenados en la base de datos. De cada libro, obtendremos su titulo, autor y la fecha en la que ha sido publicado.

### **GET**: __'/api/books/{book_id}'__
Con este endpoint obtendremos el libro al que perteneza el id que hemos pasado en la URL. Obtendremos su titulo, autor y la fecha en la que ha sido publicado.
En caso de que no exista el libro solicitado obtendremos un error 404.

### **POST**: __'/api/books/'__
Con este endpoint podremos crear un libro, el cual será almacenado en la base de datos. Debemos de pasar un objeto JSON en el body de la petición HTTP. La estructura del JSON es:
- **__title__**: Tiene que ser de tipo texto. Hace referencia al titulo del libro.
- **__author__**: Tiene que ser de tipo texto. Hace referencia al Autor del libro.
- **__published_at__**: Tiene que ser de tipo fecha. Hace referencia a la fecha de cuando ha sido publicado el libro.

### **PUT/PATCH**: __'/api/books/{book_id}'__
Con este endpoint podremos editar un libro existe. Debemos indicar al final de la URL el id del libro que queremos actualizar y ademas de pasar un objeto JSON en el body de la petición HTTP. La estructura del JSON es:
- **__title__**: Tiene que ser de tipo texto. Hace referencia al titulo del libro.
- **__author__**: Tiene que ser de tipo texto. Hace referencia al Autor del libro.
- **__published_at__**: Tiene que ser de tipo fecha. Hace referencia a la fecha de cuando ha sido publicado el libro.

En caso de que no exista el libro solicitado para actualizarlo obtendremos un error 404.

### **DELETE**: __'/api/books/{book_id}'__
Con este endpoint eliminaremos de la base de datos el libro que corresponda con el id pasado por la URL. Obtendremos una respuesta sin contenido si el libro se ha borrado correctamente.

En caso de que no exista el libro que pretendemos eliminar obtendremos un error 404.

**CAPÍTULOS:**
### **GET**: __'/api/books/{book_id}/chapters__
Con este endpoint obtendremos todos los capítulos asociados al libro el cual pertenece el id pasado por la URL. Obtendremos un objeto JSON con los datos del libro pedido y un array con todos los capítulos en la propiedad __chapters__, de los cuales por cada capítulo podremos ver la información de su número de capítulo, titulo y resumen.

Si el libro no existe, obtendremos un error 404.

### **GET**: __'/api/books/{book_id}'/chapters/{chapter_id}__
Con este endpoint obtendremos el capítulo el cual tiene el id pasado por URL asociados al libro el cual pertenece el id pasado por la URL. Obtendremos su número de capítulo, titulo y resumen.
En caso de que no exista el libro y/o el capítulo solicitado(s) obtendremos un error 404.

### **POST**: __'/api/books/{book_id}/chapters__
Con este endpoint podremos crear un capítulo, el cual será almacenado en la base de datos y asociado al libro pasado por la URL. Debemos de pasar un objeto JSON en el body de la petición HTTP. La estructura del JSON es:
- **__number_chapter__**: Tiene que ser de tipo texto. Hace referencia al número del capítulo.
- **__title__**: Tiene que ser de tipo texto. Hace referencia al título del capítulo.
- **__summaryt__**: Tiene que ser de tipo texto. Hace referencia al resumen del capítulo.

Si el libro no existe, obtendremos un error 404.

### **PUT/PATCH**: __'/api/books/{book_id}'/chapters/{chapter_id}__
Con este endpoint podremos editar un capítulo existe asociado al libro pasado por URL. Debemos indicar al final de la URL el id del capítulo que queremos actualizar y ademas de pasar un objeto JSON en el body de la petición HTTP. La estructura del JSON es:
- **__number_chapter__**: Tiene que ser de tipo texto. Hace referencia al número del capítulo.
- **__title__**: Tiene que ser de tipo texto. Hace referencia al título del capítulo.
- **__summaryt__**: Tiene que ser de tipo texto. Hace referencia al resumen del capítulo.

En caso de que no exista el libro y/o el capítulo solicitado(s) obtendremos un error 404.

### **DELETE**: __'/api/books/{book_id}'/chapters/{chapter_id}__
Con este endpoint eliminaremos de la base de datos el capítulo que corresponda con el id del capítulo pasado por la URL. Ademas, este capítulo tiene que estar asociado al libro pasado tambien por URL. Obtendremos una respuesta sin contenido si el capítulo se ha borrado correctamente.

En caso de que no exista el libro y/o el capítulo solicitado(s) obtendremos un error 404.

[docker_install_windows]: https://docs.docker.com/desktop/install/windows-install/
[docker_install_mac]: https://docs.docker.com/desktop/install/mac-install/
[docker_install_linux]: https://docs.docker.com/engine/install/ubuntu/
[docker_compose_install_linux]: https://www.digitalocean.com/community/tutorials/how-to-install-and-use-docker-compose-on-ubuntu-20-04-es