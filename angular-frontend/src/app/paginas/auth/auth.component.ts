import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { Router, RouterModule } from '@angular/router';

interface LoginForm {
  email: string;
  password: string;
}

interface RegisterForm {
  fullName: string;
  email: string;
  password: string;
  confirmPassword: string;
}

@Component({
  selector: 'app-auth',
  standalone: true,
  imports: [CommonModule, FormsModule, RouterModule],
  templateUrl: './auth.component.html',
  styles: [`
    :host {
      display: contents;
    }
    .auth-background::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      opacity: 0.1;
      background-image: radial-gradient(#2c74b3 0.75px, transparent 0.75px);
      background-size: 24px 24px;
      pointer-events: none;
    }
  `]
})
export class AuthComponent {
  activeTab: 'login' | 'register' = 'login';

  loginForm: LoginForm = {
    email: '',
    password: ''
  };

  registerForm: RegisterForm = {
    fullName: '',
    email: '',
    password: '',
    confirmPassword: ''
  };

  constructor(private router: Router) {}

  setActiveTab(tab: 'login' | 'register'): void {
    this.activeTab = tab;
  }

  login(): void {
    console.log('✅ login ejecutado');

    if (this.loginForm.email && this.loginForm.password) {
      localStorage.setItem('token', 'usuario-autenticado');
      this.router.navigateByUrl('/').then(() => location.reload());
    } else {
      alert('Completa todos los campos');
    }
  }

  register(): void {
    console.log('✅ register ejecutado');

    const { fullName, email, password, confirmPassword } = this.registerForm;

    if (!fullName || !email || !password || !confirmPassword) {
      alert('Todos los campos son obligatorios');
      return;
    }

    if (password !== confirmPassword) {
      alert('Las contraseñas no coinciden');
      return;
    }

    localStorage.setItem('token', 'usuario-autenticado');
    this.router.navigateByUrl('/').then(() => location.reload());
  }
}
