import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { environment } from '../../environment/environment';
import { LoginInterface } from '../interfaces/login-interface';
@Injectable({
  providedIn: 'root'
})
export class LoginService {
  constructor(private _http:HttpClient) { }
  sendData(modelo: LoginInterface): Observable<{ token: string }> {
    return this._http.post<{ token: string }>(
      `${environment.api}auth/login`,
      modelo,
      {
        headers: { 'Content-Type': 'application/json' },
      }
    );
  }
}
