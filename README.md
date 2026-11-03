# 📸 Red Social - PHP & MySQL (MVC)

Proyecto académico de una red social funcional desarrollada en **PHP nativo** bajo el patrón de arquitectura **MVC (Modelo - Vista - Controlador)** y base de datos **MySQL**, enfocada en buenas prácticas de estructuración, seguridad básica y diseño responsive.

---

## 🚀 Características principales

- **Autenticación segura:** Registro e inicio de sesión con contraseñas encriptadas mediante `password_hash()` y prevención de usuarios duplicados.
- **Muro social (Feed):** Publicación de fotografías con texto descriptivo, ordenadas cronológicamente.
- **Interacciones:** Sistema de *likes* y comentarios por cada publicación.
- **Sistema de amigos:** Relaciones de amistad bidireccionales, buscador de usuarios y gestión de contactos.
- **Galería / Perfil:** Visualización de perfiles de usuario y cuadrícula con sus publicaciones.
- **Seguridad:** Uso de sentencias preparadas con **PDO** contra inyección SQL, control de sesiones y escape de salidas con `htmlspecialchars` contra ataques XSS.

---

## 🛠️ Tecnologías utilizadas

- **Lenguaje:** PHP 8.x
- **Arquitectura:** MVC (Modelo-Vista-Controlador)
- **Base de datos:** MySQL / MariaDB (acceso mediante PDO)
- **Frontend:** HTML5, CSS3 nativo (Grid & Flexbox)
- **Servidor local:** Apache (vía XAMPP)

---

## 📁 Estructura del proyecto

```text
redSocial/
├── config/              # Conexión a la base de datos (PDO)
├── controllers/         # Lógica de controladores (auth, post, user)
├── models/              # Modelos y repositorios de datos
├── views/               # Vistas y plantillas de interfaz
├── public/              # Archivos estáticos (CSS, imágenes, uploads)
├── index.php            # Enrutador central de la aplicación
└── schema.sql           # Estructura de la base de datos
