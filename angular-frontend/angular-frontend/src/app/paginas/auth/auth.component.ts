import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { RouterModule } from '@angular/router';

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
  templateUrl: './auth.component.html',
  standalone: true,
  imports: [CommonModule, FormsModule, RouterModule],
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

  setActiveTab(tab: 'login' | 'register'): void {
    this.activeTab = tab;
  }
}
