import { Component, OnInit, inject} from '@angular/core';
import { CommonModule } from '@angular/common';
import { TaskService } from '../../services/task-service.service';





import { Task } from '../../shared/interfaces/task';
import { RouterModule } from '@angular/router';
import {
  FormControl,
  FormGroup,
  ReactiveFormsModule,
  Validators,
} from '@angular/forms';
import { debounceTime, distinctUntilChanged } from 'rxjs';
import { ToastComponent } from '../../shared/component/toast/toast.component';

import { ToasterService } from '../../services/toaster.service';
import { Toast } from '../../shared/interfaces/toast';
 
 
@Component({
  selector: 'app-tasks',
  imports: [CommonModule, RouterModule, ReactiveFormsModule,],
  templateUrl: './tasks.component.html',
  styleUrls: ['./tasks.component.scss']
})
 
export class TasksComponent implements OnInit {
 
  tasks: Task[] = [];
  taskForm: FormGroup;
  filteredTasks: Task[] = [];
  searchControl: FormControl;
 
  private toastService = inject(ToasterService)
 
  constructor(private taskService: TaskService) {
    this.taskForm = new FormGroup({
      title: new FormControl('',[Validators.required, Validators.minLength(3)])
    });
 
    this.searchControl = new FormControl('');
  }
 
  ngOnInit(): void {
    this.loadTasks();
 
    this.searchControl.valueChanges
    .pipe(
      debounceTime(100),
      distinctUntilChanged()
    ).subscribe(value => this.filterTasks(value))
  }
 
  loadTasks(): void {
    this.taskService.getTasks().subscribe(
      (tasks) => 
        {
          this.tasks = tasks
          this.filteredTasks = [];
        },
      (error) => console.error('Error fetching tasks:', error)
    );
  }
 
  addTask(): void {
    if (this.taskForm.invalid) return;
 
    const newTask: Task = {
       id: 0, 
       title: this.taskForm.value.title, 
       completed: false,
       createdAt: new Date().toISOString()
      };
 
    this.taskService.addTask(newTask).subscribe(() => 
      {
        this.loadTasks();
        this.taskForm.reset();
      });
  }
 
 
  toggleTask(task: Task): void {
    task.completed = !task.completed;
    this.taskService.updateTask(task).subscribe(() => this.loadTasks());
  }
 
  deleteTask(id: number): void {
    this.taskService.deleteTask(id).subscribe(() => this.loadTasks());
  }
 
  filterTasks(searchTerm: string): void {
    const term = searchTerm.toLowerCase();
 
    if (term === '') {
      this.filteredTasks = [];
      return;
    }
    this.filteredTasks = this.tasks.filter(task =>
      task.title.toLowerCase().includes(term)
    )
  }
 
  currentOrder: 'ASC' | 'DESC' | null = null;
 
  orderByCreatedAt(order: 'ASC'|'DESC'): void {
    this.currentOrder = order;
    this.taskService.getTaskByCreatedDate(order).subscribe(
      (tasks) => {
      this.tasks = tasks;
      this.filteredTasks = [];
    })
  }
 
 
  showToastSuccess() {
    this.toastService.success('Perfecto', 'esto es un mensaje success')
  }
 
  showToastError() {
    this.toastService.error('Error', 'esto es un mensaje de error')
  }
 
  onSubmit(): void {
    if (this.taskForm.valid) {
      this.addTask();
      this.showToastSuccess();
    } else {
      this.taskForm.markAllAsTouched(); // Muestra los errores si el usuario intenta enviar sin completar bien
    }
  }
 
}
 