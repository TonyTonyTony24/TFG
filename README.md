# GMV – Gestión de Mantenimiento de Vehículos 🚗

Este proyecto forma parte del Trabajo de Fin de Grado del Grado en Ingeniería Informática, y consiste en el desarrollo de una plataforma web para la gestión de vehículos, recordatorios de mantenimiento, seguros e ITV, con una interfaz tanto para usuarios como para administradores.

---

## 🧾 Descripción general

La aplicación permite:

- Registro e inicio de sesión de usuarios.
- Gestión de información de vehículos personales.
- Registro de mantenimientos realizados.
- Creación de recordatorios para mantenimientos futuros e ITV.
- Gestión de seguros.
- Visualización administrativa con estadísticas y control de usuarios.

---

## 🛠️ Tecnologías utilizadas

- **Frontend:** Angular 17, TypeScript, HTML, CSS, Tailwind
- **Backend:** Symfony 6, PHP 8, Doctrine ORM
- **Autenticación:** JWT (LexikJWTAuthenticationBundle)
- **Base de datos:** Posgresql
- **Infraestructura:** Docker, Docker Compose

---

## 📦 Requisitos

Antes de empezar, asegúrate de tener instalado:

- Docker
- Docker Compose
- Node.js (v18 recomendado)
- Angular CLI (`npm install -g @angular/cli`)

---

## 🚀 Cómo ejecutar la aplicación

### 1. Clonar el repositorio

```bash
git clone https://github.com/TonyTonyTony24/TFG.git
cd TFG

Asegúrate de tener Docker y Docker Compose instalados. Luego, en la raíz del proyecto, ejecuta:
docker compose up --build

2. Levantar el backend con Docker

Desde la raíz del proyecto:
docker compose -f angular-frontend/docker-compose.yml up -d

Esto levantará el backend Symfony con su base de datos en:
http://localhost:8000

3. Iniciar el frontend Angular
cd angular-frontend
npm install
ng serve

La aplicación Angular estará accesible desde:
http://localhost:4200

Acceso de prueba

Puedes utilizar los siguientes datos para acceder a la aplicación:

    Usuario: demo@email.com

    Contraseña: demo123
Rutas principales
Ruta	Descripción
/auth	Inicio de sesión y registro de usuarios
/tasks	Panel principal tras iniciar sesión
/vehiculo	Gestión de vehículos del usuario
/seguros	Gestión de seguros de vehículos
/recordatorio	Recordatorios de mantenimiento e ITV
/itv	Estado de inspecciones técnicas
/admin	Panel de administración con estadísticas

 Estructura del proyecto
TFG/
├── angular-frontend/         # Aplicación Angular
├── symfony-backend/          # API Symfony
├── docker-compose.yml        # Orquestación de contenedores
└── README.md                 # Documentación del proyecto


Funcionalidades implementadas
Página de inicio con presentación de servicios

Gestión de vehículos

Recordatorios personalizados (ITV, mantenimientos, etc.)

Información de seguros

Control y estado de revisiones ITV

🔗 Repositorio
Este es el repositorio oficial del proyecto:
https://github.com/TonyTonyTony24/TFG
![QR del repositorio](https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=https://github.com/TonyTonyTony24/TFG)



