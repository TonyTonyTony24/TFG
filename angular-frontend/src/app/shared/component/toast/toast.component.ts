import { Component, inject, OnDestroy, OnInit } from '@angular/core';
import { ToasterService } from '../../../services/toaster.service';
import { NgClass, NgFor, NgIf } from '@angular/common';
import { Subscription } from 'rxjs';
import { Toast } from '../../interfaces/toast';


@Component({
  selector: 'app-toast',
  imports: [NgClass, NgFor, NgIf],
  templateUrl: './toast.component.html',
  styleUrl: './toast.component.css'
})
export class ToastComponent implements OnInit, OnDestroy {

  private toasterService = inject(ToasterService);
  toasts: Toast[] = [];
  private subcription: Subscription | undefined;

  ngOnInit(): void {
    this.subcription = this.toasterService.toast$.subscribe(toasts => this.toasts = toasts)

  }

  ngOnDestroy(): void {
    if (this.subcription) {
      this.subcription.unsubscribe()
    }
  }

  removeToast(id: number) {
    this.toasterService.remove(id)
  }

  trackToast(index: number, toast: Toast) {
    return toast.id;
  }


}
