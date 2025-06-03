import { Component, inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { Router, RouterModule } from '@angular/router';
import { AuthService } from '../../shared/services/auth.service';
import { RegistroService } from '../../shared/services/registro.service';

@Component({
  selector: 'app-auth',
  standalone: true,
  imports: [CommonModule, FormsModule, RouterModule],
  templateUrl: './auth.component.html',
  styleUrls: ['./auth.component.css']
})
export class AuthComponent {
  activeTab: 'login' | 'register' = 'login';
  isLoading = false;
  error = '';
  showPassword = false;

  loginForm = {
    email: '',
    password: ''
  };

  registerForm = {
    name: '',
    email: '',
    password: ''
  };

  private authService = inject(AuthService);
  private registroService = inject(RegistroService);
  private router = inject(Router);

  setActiveTab(tab: 'login' | 'register'): void {
    this.error = '';
    this.activeTab = tab;
  }

  togglePassword(): void {
    this.showPassword = !this.showPassword;
  }

  login(): void {
    const { email, password } = this.loginForm;

    if (!email || !password) {
      this.error = 'Completa todos los campos';
      return;
    }

    this.isLoading = true;
    this.authService.login(this.loginForm).subscribe({
      next: () => {
        this.authService.fetchUser().subscribe({
          next: (user) => {
            if (!user) {
              this.error = 'Error al obtener usuario';
              this.isLoading = false;
              return;
            }
            const role = user.role[0];
            this.redirectUser(role);
          },
          error: () => {
            this.error = 'No se pudo obtener el usuario';
            this.isLoading = false;
          }
        });
      },
      error: () => {
        this.error = 'Credenciales incorrectas o error del servidor';
        this.isLoading = false;
      }
    });
  }

  register(): void {
    const { name, email, password } = this.registerForm;

    if (!name || !email || !password) {
      this.error = 'Todos los campos son obligatorios';
      return;
    }

    this.isLoading = true;

    this.registroService.sendData({ name, email, password }).subscribe({
      next: () => {
        alert('Te has registrado exitosamente.\nRevisa tu email para activar tu cuenta.');
        this.setActiveTab('login');
        this.isLoading = false;
      },
      error: () => {
        this.error = 'Error al registrar. Intenta nuevamente.';
        this.isLoading = false;
      }
    });
  }

  private redirectUser(role: string): void {
    switch (role) {
      case 'ROLE_SUPERADMIN':
        this.router.navigate(['/dashboardadmin']);
        break;
      case 'ROLE_USER':
        this.router.navigate(['/dashboardusuario']);
        break;
      default:
        this.router.navigate(['/']);
    }
  }
}
