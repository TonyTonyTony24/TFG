import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-dashboard',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.css']
})
export class DashboardComponent {
  totalUsuarios = 2;
  totalVehiculos = 3;
  totalMantenimientos = 45;

  usuarios = [
    {
      nombre: 'Juan Pérez',
      email: 'juan@email.com',
      vehiculos: 2
    },
    {
      nombre: 'María García',
      email: 'maria@email.com',
      vehiculos: 1
    }
  ];

  notificaciones = [
    {
      mensaje: 'ITV próxima a vencer: Toyota Corolla (7 días)',
      color: 'yellow'
    },
    {
      mensaje: 'Seguro vencido: Ford Focus',
      color: 'red'
    },
    {
      mensaje: 'Nuevo usuario registrado: Ana López',
      color: 'blue'
    }
  ];
}
