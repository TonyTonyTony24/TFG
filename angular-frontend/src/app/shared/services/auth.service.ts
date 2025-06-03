import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable, of, tap, catchError } from 'rxjs';
import { Router } from '@angular/router';
import { environment } from '../../environment/environment';
import { LoginInterface } from '../interfaces/login-interface';
import {jwtDecode} from 'jwt-decode';
export interface MeResponse {
  id: number;
  name: string;
  role: string[];
  exp: number;
}
@Injectable({
  providedIn: 'root',
})
export class AuthService {
  private user: MeResponse | null = null;
  constructor(private http: HttpClient, private router: Router) {}
  login(credentials: LoginInterface): Observable<any> {
    return this.http.post(`${environment.api}auth/login`, credentials, {
      withCredentials: true, // MUY IMPORTANTE para que Angular reciba la cookie del backend
    }).pipe(
      tap(() => {
        // Después del login, podrías llamar a this.fetchUser() si lo necesitas al instante
      })
    );
  }
  fetchUser(): Observable<MeResponse | null> {
    return this.http.get<MeResponse>(`${environment.api}auth/me`, {
      withCredentials: true, // También importante aquí
    }).pipe(
      tap(user => this.user = user),
      catchError(err => {
        this.user = null;
        return of(null);
      })
    );
  }
  getUser(): MeResponse | null {
    return this.user;
  }
  getDecodedToken(): any {
    const token = this.getCookie('X-AUTH-TOKEN');
    return token ? jwtDecode(token) : null;
  }
  private getCookie(name: string): string | null {
    const match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
    return match ? match[2] : null;
  }
  logout(): void {
    this.http.get(`${environment.api}auth/logout`, {
      withCredentials: true
    }).subscribe({
      next: () => {
        this.user = null;
        this.router.navigate(['/login']);
      },
      error: (err) => {
        console.error('Error en logout:', err);
        // Incluso si hay error, puedes limpiar el estado local
        this.user = null;
        this.router.navigate(['/login']);
      }
    });
  }
  isLoggedIn(): boolean {
    return !!this.user;
  }
  getUserName(): string {
    if (this.user) {
      return this.user.name;
    } else {
      // OJO: Esto no actualiza dinámicamente el nombre en la vista
      this.fetchUser().subscribe(); // Esto es asíncrono
      return 'Cargando...'; // String temporal
    }
  }
  getUserRole(): string[] {
    return this.user?.role ?? [];
  }
}