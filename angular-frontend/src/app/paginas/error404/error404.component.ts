import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-not-found',
  templateUrl: './not-found.component.html',
  styleUrls: ['./not-found.component.css'],
  standalone: true,
  imports: [CommonModule],
})
export class Error404Component {
  hover = false;

  setHover(value: boolean): void {
    this.hover = value;
  }
}
