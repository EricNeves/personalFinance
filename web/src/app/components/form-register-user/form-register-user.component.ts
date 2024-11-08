import { Component } from '@angular/core';

import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { ReactiveFormsModule } from '@angular/forms';

import { InputTextModule } from 'primeng/inputtext';
import { MessagesModule } from 'primeng/messages';
import { PasswordModule } from 'primeng/password';
import { ButtonModule } from 'primeng/button';
import { ToastModule } from 'primeng/toast';

import { MessageService } from 'primeng/api';

@Component({
  selector: 'app-form-register-user',
  standalone: true,
  imports: [
    InputTextModule,
    MessagesModule,
    PasswordModule,
    ButtonModule,
    ToastModule,
    ReactiveFormsModule,
  ],
  providers: [MessageService],
  templateUrl: './form-register-user.component.html',
  styleUrl: './form-register-user.component.css'
})
export class FormRegisterUserComponent {
  submitted: boolean = false;
  loginForm!: FormGroup;

  constructor(
    private fb: FormBuilder,
    private messageService: MessageService
  ) {
    this.loginForm = this.fb.group({
      name: ['', Validators.required],
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

    const user = this.loginForm.value;

    console.log(user)
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
