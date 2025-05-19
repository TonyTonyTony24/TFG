import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

@Component({
  selector: 'app-admin',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './admin.component.html',
  styleUrls: ['./admin.component.css']
})
export class AdminComponent {
  navigationItems = ['Dashboard', 'Usuarios', 'Vehículos', 'Mantenimientos', 'Configuración'];

  searchTerm: string = '';
  selectedUserId: number | null = null;

  users = [
    {
      id: 1,
      name: 'Juan Pérez',
      email: 'juan@email.com',
      vehicles: [
        { brand: 'Toyota', model: 'Corolla', plate: '1234ABC', year: 2020 },
        { brand: 'Ford', model: 'Focus', plate: '5678XYZ', year: 2018 }
      ]
    },
    {
      id: 2,
      name: 'María García',
      email: 'maria@email.com',
      vehicles: [
        { brand: 'Volkswagen', model: 'Golf', plate: '1111BBB', year: 2021 }
      ]
    }
  ];

  notifications = [
    { message: 'ITV próxima a vencer: Toyota Corolla (7 días)', type: 'warning' },
    { message: 'Seguro vencido: Ford Focus', type: 'error' },
    { message: 'Nuevo usuario registrado: Ana López', type: 'info' }
  ];

  getStats() {
    return {
      totalUsers: this.users.length,
      totalVehicles: this.users.reduce((acc, user) => acc + user.vehicles.length, 0),
      totalMaintenance: 45 // Simulado para la demo
    };
  }

  filterUsers() {
    return this.users.filter(user =>
      user.name.toLowerCase().includes(this.searchTerm.toLowerCase()) ||
      user.email.toLowerCase().includes(this.searchTerm.toLowerCase())
    );
  }

  showVehicles(userId: number) {
    this.selectedUserId = this.selectedUserId === userId ? null : userId;
  }

  trackByItem(index: number, item: string) {
    return item;
  }

  trackByStat(index: number, stat: any) {
    return stat.title;
  }

  trackByUser(index: number, user: any) {
    return user.id;
  }

  trackByVehicle(index: number, vehicle: any) {
    return vehicle.plate;
  }

  trackByNotification(index: number, notification: any) {
    return notification.message;
  }

  getNotificationBackground(type: string) {
    switch (type) {
      case 'warning':
        return '#FEF3C7';
      case 'error':
        return '#FECACA';
      case 'info':
        return '#DBEAFE';
      default:
        return '#E5E7EB';
    }
  }

  getNotificationColor(type: string) {
    switch (type) {
      case 'warning':
        return '#92400E';
      case 'error':
        return '#991B1B';
      case 'info':
        return '#1D4ED8';
      default:
        return '#374151';
    }
  }
}
