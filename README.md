Plataforma Web de Gestión Vehicular 🚗
Este proyecto es un Trabajo de Fin de Grado (TFG) que consiste en una plataforma web para la gestión de vehículos. Permite gestionar mantenimientos, seguros, recordatorios e ITV desde un único lugar.

🛠 Tecnologías utilizadas
Frontend: Angular 16, HTML, SCSS, Angular Material

Backend: Symfony + API REST

Base de datos: PostgreSQL

Contenedores: Docker + Docker Compose

Control de versiones: Git + GitHub

📦 Estructura del proyecto
bash
/angular-frontend       → Código del frontend (Angular)
  └── src/app/...       → Componentes, páginas y servicios
/symfony-backend        → Código del backend (Symfony)
/docker-compose.yml     → Configuración de contenedores

🚀 Cómo ejecutar el proyecto
Asegúrate de tener Docker y Docker Compose instalados. Luego, en la raíz del proyecto, ejecuta:
docker compose up --build


docker compose up --build
El frontend estará disponible en: http://localhost:4300

El backend (API Symfony) en: http://localhost:8010

📱 Funcionalidades implementadas
Página de inicio con presentación de servicios

Gestión de vehículos

Recordatorios personalizados (ITV, mantenimientos, etc.)

Información de seguros

Control y estado de revisiones ITV

🔗 Repositorio
Este es el repositorio oficial del proyecto:
https://github.com/TonyTonyTony24/TFG
![QR del repositorio](https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=https://github.com/TonyTonyTony24/TFG)



