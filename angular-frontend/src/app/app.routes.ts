import { Routes } from '@angular/router';

import { LandingComponent } from './modules/landing/landing.component';
import { AdminComponent } from './paginas/admin/admin.component';
import { VehiculoDetalleComponent } from './paginas/admin/vehiculo-detalle/vehiculo-detalle.component';

export const routes: Routes = [
  { path: '', component: LandingComponent },

  {
    path: 'auth',
    loadComponent: () =>
      import('./paginas/auth/auth.component').then((m) => m.AuthComponent)
  },

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
        path: 'vehiculos/nuevo',
        loadComponent: () =>
          import('./paginas/gestion-vehiculo/gestion-vehiculo.component').then(
            (m) => m.GestionVehiculoComponent
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
      },
      {
        path: 'mantenimientos',
        loadComponent: () =>
          import('./paginas/admin/vehiculo-mantenimientos/vehiculo-mantenimientos.component').then(
            (m) => m.VehiculoMantenimientosComponent
          )
      },
      {
        path: 'seguros',
        loadComponent: () =>
          import('./paginas/admin/vehiculo-seguros/vehiculo-seguros.component').then(
            (m) => m.VehiculoSegurosComponent
          )
      },
      {
        path: 'itv',
        loadComponent: () =>
          import('./paginas/admin/vehiculo-itv/vehiculo-itv.component').then(
            (m) => m.VehiculoItvComponent
          )
      },
      // ✅ RUTA para listado de vehículos
      {
        path: 'vehiculos',
        loadComponent: () =>
          import('./paginas/admin/vehiculos.component').then(
            (m) => m.VehiculosComponent
          )
      },
      // ✅ RUTA para detalle de un vehículo
      {
        path: 'vehiculos/:id',
        component: VehiculoDetalleComponent,
        children: [
          {
            path: 'itv',
            loadComponent: () =>
              import('./paginas/admin/vehiculo-itv/vehiculo-itv.component').then(
                (m) => m.VehiculoItvComponent
              )
          },
          {
            path: 'seguros',
            loadComponent: () =>
              import('./paginas/admin/vehiculo-seguros/vehiculo-seguros.component').then(
                (m) => m.VehiculoSegurosComponent
              )
          },
          {
            path: 'mantenimientos',
            loadComponent: () =>
              import('./paginas/admin/vehiculo-mantenimientos/vehiculo-mantenimientos.component').then(
                (m) => m.VehiculoMantenimientosComponent
              )
          }
        ]
      }
    ]
  },

  {
    path: '**',
    loadComponent: () =>
      import('./paginas/error404/error404.component').then(
        (m) => m.Error404Component
      )
  }
];
