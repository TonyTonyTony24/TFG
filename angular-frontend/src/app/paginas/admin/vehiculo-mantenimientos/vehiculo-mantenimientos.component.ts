import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

@Component({
  selector: 'app-vehiculo-mantenimientos',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './vehiculo-mantenimientos.component.html',
  styleUrls: ['./vehiculo-mantenimientos.component.css']
})
export class VehiculoMantenimientosComponent {
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
