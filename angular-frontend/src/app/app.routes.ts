import { Routes } from '@angular/router';

import { LandingComponent } from './modules/landing/landing.component';
import { GestionVehiculoComponent } from './paginas/gestion-vehiculo/gestion-vehiculo.component';
import { RecordatorioComponent } from './paginas/recordatorio/recordatorio.component';
import { SegurosComponent } from './paginas/seguros/seguros.component';
import { ItvComponent } from './paginas/itv/itv.component';
import { AdminComponent } from './paginas/admin/admin.component';

export const routes: Routes = [
  { path: '', component: LandingComponent },

  // Ruta de autenticación (lazy-loaded)
  {
    path: 'auth',
    loadComponent: () =>
      import('./paginas/auth/auth.component').then((m) => m.AuthComponent)
  },

  // Página para gestionar vehículos
  { path: 'vehiculo', component: GestionVehiculoComponent },

  // Página para seguros
  { path: 'seguros', component: SegurosComponent },

  // Página para ITV
  { path: 'itv', component: ItvComponent },

  // Página de recordatorios
  { path: 'recordatorio', component: RecordatorioComponent },

  // Panel de administrador con rutas hijas
  {
    path: 'admin',
    component: AdminComponent,
    children: [
      {
        path: '',
        loadComponent: () =>
          import('./paginas/admin/dashboard/dashboard.component').then(
            (m) => m.DashboardComponent
          )
      },
      {
        path: 'usuarios',
        loadComponent: () =>
          import('./paginas/admin/usuarios/usuarios.component').then(
            (m) => m.UsuariosComponent
          )
      },
      {
        path: 'configuracion',
        loadComponent: () =>
          import('./paginas/admin/configuracion/configuracion.component').then(
            (m) => m.ConfiguracionComponent
          )
      }
    ]
  },

  // Ruta de error 404 (fallback)
  {
    path: '**',
    loadComponent: () =>
      import('./paginas/error404/error404.component').then(
        (m) => m.Error404Component
      )
  }
];
