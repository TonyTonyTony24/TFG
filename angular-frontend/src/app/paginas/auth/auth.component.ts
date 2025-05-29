import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { Router, RouterModule } from '@angular/router';
import { AuthService } from '../../services/auth.service';


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

  error: string = '';

  constructor(
    private authService: AuthService,
    private router: Router
  ) {}

  setActiveTab(tab: 'login' | 'register') {
    this.activeTab = tab;
  }

  login(): void {
    const { email, password } = this.loginForm;

    this.authService.login(email, password).subscribe({
      next: () => {
        this.router.navigate(['/']);
      },
      error: () => {
        this.error = 'Credenciales incorrectas';
      }
    });
  }

  register(): void {
    console.log(this.registerForm);
  }
}
