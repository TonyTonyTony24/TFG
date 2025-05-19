import { Component, inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Router, RouterOutlet } from '@angular/router'; // RouterOutlet va aquí
import { RouterModule } from '@angular/router'; // Este también es necesario
import { ToastComponent } from './shared/component/toast/toast.component';
import { ToasterService } from './shared/services/toaster.service';

@Component({
  selector: 'app-root',
  standalone: true,
  imports: [CommonModule, RouterModule, RouterOutlet, ToastComponent],
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  title = 'angular-frontend';

  private toastService = inject(ToasterService);
  private router = inject(Router);

  showToastSuccess() {
    this.toastService.success('Estupendo', 'Ha salido todo bien');
  }

  showToastError() {
    this.toastService.error('Error', 'Ha salido todo mal');
  }

  showToastInfo() {
    this.toastService.info('Info', 'Esto es un mensaje de información');
  }

  showToastWarning() {
    this.toastService.warning('Warning', 'Esto es un mensaje de advertencia');
  }

  isLoggedIn(): boolean {
    return !!localStorage.getItem('token');
  }

  logout(): void {
    localStorage.removeItem('token');
    this.router.navigate(['/']);
  }
}
