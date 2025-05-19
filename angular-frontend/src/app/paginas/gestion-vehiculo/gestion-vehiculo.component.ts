import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

@Component({
  selector: 'app-gestion-vehiculo',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './gestion-vehiculo.component.html',
  styleUrls: ['./gestion-vehiculo.component.css']
})
export class GestionVehiculoComponent {
  vehicle = {
    brand: 'Toyota',
    model: 'Corolla',
    plate: '1234-ABC',
    year: 2020
  };

  alerts = [
    {
      type: 'ITV',
      dueDate: '2025-07-10',
      status: 'warning'
    },
    {
      type: 'Seguro',
      dueDate: '2025-05-20',
      status: 'danger'
    }
  ];

  maintenanceRecords = [
    {
      date: '2024-03-01',
      type: 'Cambio de aceite',
      notes: 'Cambio de aceite realizado correctamente'
    },
    {
      date: '2024-04-10',
      type: 'Revisión de frenos',
      notes: 'Pastillas delanteras cambiadas'
    }
  ];

  nuevoMantenimiento = {
    fecha: '',
    tipo: '',
    observaciones: ''
  };

  guardarMantenimiento() {
    this.maintenanceRecords.push({
      date: this.nuevoMantenimiento.fecha,
      type: this.nuevoMantenimiento.tipo,
      notes: this.nuevoMantenimiento.observaciones
    });

    this.nuevoMantenimiento = {
      fecha: '',
      tipo: '',
      observaciones: ''
    };
  }
}
