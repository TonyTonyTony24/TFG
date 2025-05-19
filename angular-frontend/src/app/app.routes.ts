import { Routes } from '@angular/router';
import { LandingComponent } from './modules/landing/landing.component';
import { TasksComponent } from './modules/tasks/tasks.component';
import { GestionVehiculoComponent } from './paginas/gestion-vehiculo/gestion-vehiculo.component';
import { RecordatorioComponent } from './paginas/recordatorio/recordatorio.component';
import { SegurosComponent } from './paginas/seguros/seguros.component';
import { ItvComponent } from './paginas/itv/itv.component';
import { AdminComponent } from './paginas/admin/admin.component';

export const routes: Routes = [
  { path: '', component: LandingComponent },
  { path: 'tasks', component: TasksComponent },
  {
    path: 'auth',
    loadComponent: () =>
      import('./paginas/auth/auth.component').then(m => m.AuthComponent)
  },
  { path: 'vehiculo', component: GestionVehiculoComponent },
  { path: 'recordatorio', component: RecordatorioComponent },
  { path: 'seguros', component: SegurosComponent },
  { path: 'itv', component: ItvComponent },
  { path: 'global', component: GestionVehiculoComponent },
  { path: 'admin', component: AdminComponent }, 
  {
    path: '**',
    loadComponent: () =>
      import('./paginas/error404/error404.component').then(m => m.Error404Component)
  }
];
