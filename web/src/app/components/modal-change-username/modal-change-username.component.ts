import {Component, EventEmitter, Input, OnChanges, Output, SimpleChanges} from '@angular/core';
import { FormBuilder, FormGroup, Validators, ReactiveFormsModule } from '@angular/forms';

import { DialogModule } from 'primeng/dialog';
import { ButtonModule } from "primeng/button";
import { MessageService } from 'primeng/api';

import { ToastModule } from "primeng/toast";
import { InputGroupModule } from 'primeng/inputgroup';
import { InputGroupAddonModule } from 'primeng/inputgroupaddon';
import { SelectButtonModule } from 'primeng/selectbutton';
import {UserService} from "@services/user.service";
import {User} from "@models/user.model";

@Component({
  selector: 'app-modal-change-username',
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
  templateUrl: './modal-change-username.component.html',
  styleUrl: './modal-change-username.component.css',
  providers: [MessageService]
})
export class ModalChangeUsernameComponent implements OnChanges {
  @Input()  visible: boolean = false;
  @Input() username: string = '';
  @Output() changeVisible: EventEmitter<boolean> = new  EventEmitter();
  @Output() userInfo: EventEmitter<User> = new EventEmitter();

  submitted: boolean = false;

  changeUsernameForm!: FormGroup;

  constructor(
    private readonly messageService: MessageService,
    private readonly formBuilder: FormBuilder,
    private readonly userService: UserService
  ) {
    this.changeUsernameForm = this.formBuilder.group({
      name: ['', Validators.required],
    })
  }

  ngOnChanges(changes: SimpleChanges) {
    if (changes['username']) {
      this.changeUsernameForm.patchValue({
        name: changes['username'].currentValue
      })
    }
  }

  onSubmit(): void {
    this.submitted = true;

    if (this.changeUsernameForm.invalid) {
      Object.keys(this.changeUsernameForm.controls).map((key) => {
        this.getErrorMessage(key);
      });

      this.submitted = false;
      return;
    }

    const { name } = this.changeUsernameForm.value

    this.userService.editUsername(name).subscribe({
      next: (response) => {
        this.userInfo.emit(response.data)

        this.submitted = false;
        this.changeVisible.emit(false)
      },
      error: (error) => {
        this.messageService.add({
          severity: 'error',
          summary: 'Warning',
          detail: error.error.message,
        });

        this.submitted = false
      }
    })
  }

  getErrorMessage(controlName: string): void {
    const control = this.changeUsernameForm.get(controlName);

    if (control?.hasError('required')) {
      this.messageService.add({
        severity: 'warn',
        summary: 'Warning',
        detail: `The field ${controlName} is required`,
      });
    }
  }

  changeVisibleModal(event: boolean): void {
    this.changeVisible.emit(event)
  }
}
