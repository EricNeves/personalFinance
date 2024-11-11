import { Component } from '@angular/core';

import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { ReactiveFormsModule } from '@angular/forms';

import { InputTextModule } from 'primeng/inputtext';
import { MessagesModule } from 'primeng/messages';
import { PasswordModule } from 'primeng/password';
import { ButtonModule } from 'primeng/button';
import { ToastModule } from 'primeng/toast';
import { Router } from '@angular/router';

import { MessageService } from 'primeng/api';

import { User } from "@models/user.model";
import { UserService } from "@services/user.service";
import {StorageService} from "@services/storage.service";

@Component({
  selector: 'app-form-authentication',
  standalone: true,
  imports: [
    InputTextModule,
    MessagesModule,
    PasswordModule,
    ButtonModule,
    ToastModule,
    ReactiveFormsModule
  ],
  providers: [MessageService],
  templateUrl: './form-authentication.component.html',
  styleUrl: './form-authentication.component.css'
})
export class FormAuthenticationComponent {
  submitted: boolean = false;
  loginForm!: FormGroup;

  constructor(
    private readonly fb: FormBuilder,
    private readonly messageService: MessageService,
    private readonly userService: UserService,
    private readonly router: Router,
    private readonly storageService: StorageService
  ) {
    this.loginForm = this.fb.group({
      email: ['', [Validators.required, Validators.email]],
      password: ['', Validators.required],
    });
  }

  onSubmit(): void {
    this.submitted = true;

    if (this.loginForm.invalid) {
      Object.keys(this.loginForm.controls).map((key) => {
        this.getErrorMessage(key);
      });

      this.submitted = false;
      return;
    }

    const user: Partial<User> = this.loginForm.value;

    this.userService.authenticate(user).subscribe({
      next: (response) => {
        this.storageService.setData('jwt', response.data)

        this.router.navigate(['/panel']);

        this.submitted = false
      },
      error: (error: any) => {
        this.messageService.add({
          severity: 'error',
          summary: 'Warning',
          detail: `${error.error.message}`,
        })

        this.submitted = false
      }
    })
  }

  getErrorMessage(controlName: string): void {
    const control = this.loginForm.get(controlName);

    if (control?.hasError('required')) {
      this.messageService.add({
        severity: 'warn',
        summary: 'Warning',
        detail: `The field ${controlName} is required`,
      });
    } else if (control?.hasError('email')) {
      this.messageService.add({
        severity: 'warn',
        summary: 'Warning',
        detail: `The field ${controlName} is not a valid email`,
      });
    }
  }
}
