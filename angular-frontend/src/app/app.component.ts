import { Component, OnInit } from '@angular/core';
import { RouterOutlet } from '@angular/router';
import { CookieService } from 'ngx-cookie-service';
import { AuthService } from './shared/services/auth.service';
@Component({
  selector: 'app-root',
  imports: [RouterOutlet],
  providers: [CookieService],
  templateUrl: './app.component.html',
  styleUrl: './app.component.css'
})
export class AppComponent {
  title = 'angular-frontend';
  constructor(private authService: AuthService) {}
  // ngOnInit(): void {
  //   this.authService.fetchUser().subscribe(); // Carga el usuario al iniciar app
  // }
}