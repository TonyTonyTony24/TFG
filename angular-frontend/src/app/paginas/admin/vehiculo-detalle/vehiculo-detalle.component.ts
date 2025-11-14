import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule } from '@angular/router';

@Component({
  selector: 'app-vehiculo-detalle',
  standalone: true,
  imports: [CommonModule, RouterModule ],
  templateUrl: './vehiculo-detalle.component.html',
  styleUrls: ['./vehiculo-detalle.component.css']
})
export class VehiculoDetalleComponent {}
