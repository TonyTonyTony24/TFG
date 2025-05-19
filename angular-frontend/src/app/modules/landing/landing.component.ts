import { Component } from '@angular/core';
import { Router } from '@angular/router';
import { CommonModule } from '@angular/common';
import { RouterModule } from '@angular/router';

@Component({
  selector: 'app-landing',
  standalone: true,
  imports: [CommonModule, RouterModule],
  templateUrl: './landing.component.html',
  styleUrls: ['./landing.component.css']
})
export class LandingComponent {
  activeTab = 'login';

  loginForm = {
    email: '',
    password: ''
  };

  registerForm = {
    fullName: '',
    email: '',
    password: '',
    confirmPassword: ''
  };

  constructor(private router: Router) {}

  setActiveTab(tab: string) {
    this.activeTab = tab;
  }

  login() {
    if (this.loginForm.email && this.loginForm.password) {
      localStorage.setItem('token', 'usuario-autenticado');
      this.router.navigate(['/tasks']);
    } else {
      alert('Completa todos los campos');
    }
  }

  register() {
    if (
      this.registerForm.fullName &&
      this.registerForm.email &&
      this.registerForm.password === this.registerForm.confirmPassword
    ) {
      localStorage.setItem('token', 'usuario-autenticado');
      this.router.navigate(['/tasks']);
    } else {
      alert('Completa correctamente todos los campos');
    }
  }

  isLoggedIn(): boolean {
    return !!localStorage.getItem('token');
  }

  logout(): void {
    localStorage.removeItem('token');
    this.router.navigate(['/']);
  }

  goTo(section: string): void {
    if (!this.isLoggedIn()) {
      alert('Debes iniciar sesión para acceder a los servicios.');
      this.router.navigate(['/auth']);
      return;
    }

    switch (section) {
      case 'vehiculo':
        this.router.navigate(['/vehiculo']);
        break;
      case 'recordatorio':
        this.router.navigate(['/recordatorio']);
        break;
      case 'seguros':
        this.router.navigate(['/seguros']);
        break;
      case 'itv':
        this.router.navigate(['/itv']);
        break;
      default:
        this.router.navigate(['/tasks']);
        break;
    }
  }
}
