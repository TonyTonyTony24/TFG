import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { HttpClient, HttpClientModule } from '@angular/common/http';
import { RouterModule, Router } from '@angular/router';

@Component({
  selector: 'app-vehiculos',
  standalone: true,
  imports: [CommonModule, HttpClientModule, RouterModule],
  template: `
    <div class="p-6 bg-white rounded-lg shadow">
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-slate-700">📋 Lista de Vehículos</h2>
        <button
          class="px-4 py-2 bg-emerald-500 text-white rounded hover:bg-emerald-600"
          (click)="registrarNuevo()"
        >
          ➕ Registrar nuevo
        </button>
      </div>

      <table class="w-full table-auto border-collapse">
        <thead>
          <tr class="border-b">
            <th class="px-4 py-2 text-left">Marca</th>
            <th class="px-4 py-2 text-left">Modelo</th>
            <th class="px-4 py-2 text-left">Matrícula</th>
            <th class="px-4 py-2 text-left">Año</th>
            <th class="px-4 py-2">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr *ngFor="let vehiculo of vehiculos" class="border-b hover:bg-gray-50">
            <td class="px-4 py-2">{{ vehiculo.marca }}</td>
            <td class="px-4 py-2">{{ vehiculo.modelo }}</td>
            <td class="px-4 py-2">{{ vehiculo.matricula }}</td>
            <td class="px-4 py-2">{{ vehiculo.anio }}</td>
            <td class="px-4 py-2 text-center">
              <button
                class="text-blue-600 hover:underline"
                (click)="verDetalle(vehiculo.id)"
              >
                Ver Detalle
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  `
})
export class VehiculosComponent implements OnInit {
  vehiculos: any[] = [];

  constructor(private http: HttpClient, private router: Router) {}

  ngOnInit(): void {
    this.http.get<any[]>('http://localhost:8000/api/vehiculos').subscribe({
      next: (res) => (this.vehiculos = res),
      error: (err) => console.error('Error al cargar vehículos', err)
    });
  }

  verDetalle(id: number) {
    this.router.navigate(['/admin/vehiculos', id]);
  }

  registrarNuevo() {
    this.router.navigate(['/admin/vehiculos/nuevo']);
  }
}
