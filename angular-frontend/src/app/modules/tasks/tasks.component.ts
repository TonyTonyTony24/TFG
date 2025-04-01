import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { TaskService } from '../../shared/services/task-service.service';
import { Task } from '../../shared/interfaces/task';
import { RouterModule } from '@angular/router';
import { FormGroup, FormBuilder, Validators, ReactiveFormsModule, FormControl } from '@angular/forms';
import { Subject, takeUntil, debounceTime, distinctUntilChanged } from 'rxjs';
@Component({
  selector: 'app-tasks',
  imports: [CommonModule, RouterModule, ReactiveFormsModule],
  templateUrl: './tasks.component.html',
  styleUrls: ['./tasks.component.scss'],
})


export class TasksComponent implements OnInit {
  userTask!: FormGroup;
  searchBar = new FormControl('');
  tasks: Task[] = [];
  filteredTasks: Task[] = [];
  private readonly destroy$ = new Subject <void>();
  constructor(private taskService: TaskService, private fb: FormBuilder) {}
  ngOnInit(): void {
    this.loadTasks();
    this.searchSubscription();
    this.userTask = this.fb.group({
      id: ['0'],
      title: ['', [Validators.required, Validators.minLength(3)]],
      completed: [false],
    });
  }
  loadTasks(): void {
    this.taskService.getTasks().pipe(takeUntil(this.destroy$)).subscribe(
      (tasks) => {
        this.tasks = tasks;
        this.filterTasks(this.searchBar.value || '');
      },
      (error) => console.error('Error fetching tasks:', error)
    );
  }
  searchSubscription(): void {
    this.searchBar.valueChanges.pipe(
        debounceTime(200),
        distinctUntilChanged(),
        takeUntil(this.destroy$)
      )
      .subscribe(userInput => {
        this.filterTasks(userInput || '');
      });
  }
  filterTasks(userInput: string): void {
    if (!userInput) {
      this.filteredTasks = [...this.tasks];
      return;
    }
    const lowerCase = userInput.toLowerCase();
    this.filteredTasks = this.tasks.filter(task =>
      task.title.toLowerCase().includes(lowerCase)
    );
  }
  addTask(title: string): void {
    if (this.userTask.valid) {
      const newTask: Task = this.userTask.value;
      this.taskService.addTask(newTask).subscribe(() => this.loadTasks());
      this.userTask.reset();
    }
  }
  get title() {
    return this.userTask.get('title');
  }
  toggleTask(task: Task): void {
    task.completed = !task.completed;
    this.taskService.updateTask(task).subscribe(() => this.loadTasks());
  }
  deleteTask(id: number): void {
    this.taskService.deleteTask(id).subscribe(() => this.loadTasks());
  }
}
