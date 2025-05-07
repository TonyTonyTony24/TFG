import { Routes } from '@angular/router';
import { TasksComponent } from './modules/tasks/tasks.component';
import { LandingComponent } from './modules/landing/landing.component';
import { AuthComponent } from './paginas/auth/auth.component';

export const routes: Routes = [
    {path: "", component: LandingComponent},
    {path: "tasks", component: TasksComponent},
    {path: "auth", component: AuthComponent},

];
