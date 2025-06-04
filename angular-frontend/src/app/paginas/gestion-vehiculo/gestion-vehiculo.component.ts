import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { HttpClient, HttpClientModule } from '@angular/common/http';

@Component({
  selector: 'app-gestion-vehiculo',
  standalone: true,
  imports: [CommonModule, FormsModule, HttpClientModule],
  templateUrl: './gestion-vehiculo.component.html',
  styleUrls: ['./gestion-vehiculo.component.css']
})
export class GestionVehiculoComponent {
  vehicle = {
    marca: '',
    modelo: '',
    matricula: '',
    anio: null
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

  constructor(private http: HttpClient) {}

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

  registrarVehiculo() {
    this.http.post('http://localhost:8000/api/vehiculos', this.vehicle).subscribe({
      next: () => alert('Vehículo registrado correctamente'),
      error: (err) => alert('Error al registrar vehículo: ' + err.message)
    });
  }
}
