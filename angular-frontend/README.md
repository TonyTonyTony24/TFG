
# AngularFrontend

This project was generated using [Angular CLI](https://github.com/angular/angular-cli) version 19.2.0.

## Development server

To start a local development server, run:

```bash
ng serve
```

Once the server is running, open your browser and navigate to `http://localhost:4200/`. The application will automatically reload whenever you modify any of the source files.

## Code scaffolding

Angular CLI includes powerful code scaffolding tools. To generate a new component, run:

```bash
ng generate component component-name
```

For a complete list of available schematics (such as `components`, `directives`, or `pipes`), run:

```bash
ng generate --help
```

## Building

To build the project run:

```bash
ng build
```

This will compile your project and store the build artifacts in the `dist/` directory. By default, the production build optimizes your application for performance and speed.

## Running unit tests

To execute unit tests with the [Karma](https://karma-runner.github.io) test runner, use the following command:

```bash
ng test
```

## Running end-to-end tests

For end-to-end (e2e) testing, run:

```bash
ng e2e
```

Angular CLI does not come with an end-to-end testing framework by default. You can choose one that suits your needs.

## Additional Resources

For more information on using the Angular CLI, including detailed command references, visit the [Angular CLI Overview and Command Reference](https://angular.dev/tools/cli) page.

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
El frontend estará disponible en: http://localhost:4200

El backend (API Symfony) en: http://localhost:8000

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

7c03bab63811cc85ab0b725cffaa5b1ce8050c6f
