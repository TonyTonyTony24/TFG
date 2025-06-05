import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

export interface Mantenimiento {
  fecha: string;
  tipo: string;
  observaciones: string;
  vehiculoId: number;
}

@Injectable({
  providedIn: 'root'
})
export class MantenimientoService {
  private apiUrl = 'http://localhost:8000/api/mantenimientos';

  constructor(private http: HttpClient) {}

  registrarMantenimiento(mantenimiento: Mantenimiento): Observable<any> {
    return this.http.post<any>(this.apiUrl, mantenimiento);
  }
}
