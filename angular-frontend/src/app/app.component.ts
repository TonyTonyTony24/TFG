import { Component, inject } from '@angular/core';
import { RouterOutlet } from '@angular/router';
import { BrowserModule } from '@angular/platform-browser';
import { ToasterService } from "./shared/services/toaster.service"
import { ToastComponent } from './shared/componet/toast/toast.component';

@Component({
  selector: 'app-root',
  imports: [RouterOutlet,ToastComponent],
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']

})

export class AppComponent {
  title = 'angular-frontend';

  private toastService = inject(ToasterService);
  
  showToastSuccess() { 
    this.toastService.success('estupendo', 'ha salido todo bien');
  }

  showToastError() { 
    this.toastService.error('error', 'ha salido todo mal');
  }

  showToastInfo() { 
    this.toastService.info('Info', 'esto es un mensaje de informacion');
  }

  showToastWarning() { 
    this.toastService.warning('Warning', 'esto es un mensaje de advertencia');
  }
}
