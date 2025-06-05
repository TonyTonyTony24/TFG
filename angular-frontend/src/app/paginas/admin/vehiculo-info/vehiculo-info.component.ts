import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-vehiculo-recordatorios',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './vehiculo-recordatorios.component.html',
  styleUrls: ['./vehiculo-recordatorios.component.css']
})
export class VehiculoRecordatoriosComponent {
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
}
