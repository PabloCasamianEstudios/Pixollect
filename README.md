
<div align="center">

![Header](public/images/header.png)
# Pixollect

Pixollect es una aplicación de gestión, que busca centralizar en un mismo sitio un registro de toda tu colección de videjuegos. 

</div>

## Requisitos del sistema

Para ejecutar correctamente la aplicación, se requiere el siguiente entorno:

- PHP >= 8.1
- Composer
- Node.js >= 18 + NPM
- MySQL o MariaDB
- Laravel 10.x
- Navegador moderno (Chrome, Opera, Firefox...)

## Proceso de instalación

### 1. **Clonar el repositorio**
   ```bash
   git clone https://github.com/PabloCasamianEstudios/Pixollect.git
   cd Pixollect
```

### 2. **Instalar dependencias del backend**
   ```bash
    composer install
```

### 3. **Instalar dependencias del frontend**
   ```bash
   npm install
```

### 4. **Configurar el entorno**
   ```bash
   cp .env.example .env
```

    *Editar el .env y configurar la conexión a base de datos

   ```bash
   DB_DATABASE=nombre_base_datos
DB_USERNAME=usuario
DB_PASSWORD=contraseña
```

### 5. **Generar clave de aplicación y migrar**
   ```bash
    php artisan key:generate
    php artisan migrate –seed
```

> La versión local de Pixollect cuenta con unos pocos juegos para empezar, deberás añadir el resto por cuenta propia.

### 6. **Compilar assets**
   ```bash
   npm run dev
```

### 7. **Levantar el servidor**
   ```bash
   php artisan serve
```

### 8. **Acceder desde el navegador al localhost en http://localhost:8000 **

Por defecto, el usuario administrador creado desde el seeder es: 
   ```bash
   git clone https://github.com/PabloCasamianEstudios/Pixollect.git
   cd Pixollect
```
