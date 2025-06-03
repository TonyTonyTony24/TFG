import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { environment } from '../../environment/environment';
import { RegistroInterface } from '../interfaces/registro-interface';
@Injectable({
  providedIn: 'root'
})
export class RegistroService {
  constructor(private _http:HttpClient) { }
  sendData(modelo: RegistroInterface): Observable<any> {
    return this._http.post(
      `${environment.api}auth/register`,
      modelo,
      {
        headers: { 'Content-Type': 'application/json' },
      }
    );
  }
}