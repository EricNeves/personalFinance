import {Component, EventEmitter, Input, Output} from '@angular/core';
import { FormBuilder, FormGroup, Validators, ReactiveFormsModule } from '@angular/forms';

import { DialogModule } from 'primeng/dialog';
import { ButtonModule } from "primeng/button";
import { MessageService } from 'primeng/api';

import { ToastModule } from "primeng/toast";
import { InputGroupModule } from 'primeng/inputgroup';
import { InputGroupAddonModule } from 'primeng/inputgroupaddon';
import { SelectButtonModule } from 'primeng/selectbutton';
import {UserService} from "@services/user.service";

@Component({
  selector: 'app-modal-change-password',
  standalone: true,
  imports: [
    DialogModule,
    ButtonModule,
    ToastModule,
    InputGroupModule,
    InputGroupAddonModule,
    SelectButtonModule,
    ReactiveFormsModule
  ],
  templateUrl: './modal-change-password.component.html',
  styleUrl: './modal-change-password.component.css',
  providers: [MessageService]
})
export class ModalChangePasswordComponent {
  @Input()  visible: boolean = false;
  @Output() changeVisible: EventEmitter<boolean> = new  EventEmitter();

  submitted: boolean = false;

  changePasswordForm!: FormGroup;

  constructor(
    private readonly messageService: MessageService,
    private readonly userService: UserService,
    private readonly fb: FormBuilder
  ) {
    this.changePasswordForm = this.fb.group({
      old_password: ['', Validators.required],
      new_password: ['', Validators.required],
    })
  }

  onSubmit(): void {
    this.submitted = true;

    if (this.changePasswordForm.invalid) {
      Object.keys(this.changePasswordForm.controls).map((key) => {
        this.getErrorMessage(key);
      });

      this.submitted = false;
      return;
    }

    const { old_password, new_password } = this.changePasswordForm.value

    this.userService.editPassword(old_password, new_password).subscribe({
      next: (response) => {
        this.messageService.add({
          severity: 'success',
          summary: 'Success',
          detail: response.data,
        });

        this.submitted = false
        this.changeVisible.emit(false)
        this.changePasswordForm.reset()
      },
      error: (error) => {
        this.messageService.add({
          severity: 'error',
          summary: 'Warning',
          detail: error.error.message,
        });

        this.changePasswordForm.reset()
        this.submitted = false
      }
    })
  }

  getErrorMessage(controlName: string): void {
    const control = this.changePasswordForm.get(controlName);

    if (control?.hasError('required')) {
      this.messageService.add({
        severity: 'warn',
        summary: 'Warning',
        detail: `The field ${controlName} is required`,
      });
    }
  }

  changeVisibleModal(event: boolean): void {
    this.changePasswordForm.reset()
    this.changeVisible.emit(event)
  }
}
