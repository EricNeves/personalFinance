import { Component, EventEmitter, Input, Output } from '@angular/core';
import { FormBuilder, FormGroup, Validators, ReactiveFormsModule } from '@angular/forms';

import { DialogModule } from 'primeng/dialog';
import { ButtonModule } from "primeng/button";
import { MessageService } from 'primeng/api';

import { ToastModule } from "primeng/toast";
import { InputGroupModule } from 'primeng/inputgroup';
import { InputGroupAddonModule } from 'primeng/inputgroupaddon';
import { SelectButtonModule } from 'primeng/selectbutton';
import { TransactionBody, TransactionWithBalance } from "@models/transaction.model";
import { TransactionService } from "@services/transaction.service";

@Component({
  selector: 'app-modal-add-transaction',
  standalone: true,
  imports: [
    DialogModule,
    ButtonModule,
    InputGroupModule,
    InputGroupAddonModule,
    SelectButtonModule,
    ReactiveFormsModule,
    ToastModule
  ],
  providers: [MessageService],
  templateUrl: './modal-add-transaction.component.html',
  styleUrl: './modal-add-transaction.component.css'
})
export class ModalAddTransactionComponent {
  @Input() visible: boolean = false;
  @Output() changeVisible: EventEmitter<boolean> = new  EventEmitter();
  @Output() registeredTransaction: EventEmitter<TransactionWithBalance> = new EventEmitter();

  submitted: boolean = false;

  transactionForm!: FormGroup;

  transactionOptions: any[] = [
    { label: 'Income',  value: 'income' },
    { label: 'Expense', value: 'expense' }
  ];

  constructor(
    private readonly formBuilder: FormBuilder,
    private readonly messageService: MessageService,
    private readonly transactionService: TransactionService
  ) {
    this.transactionForm = this.formBuilder.group({
      amount: ['', Validators.required],
      description: ['', Validators.required],
      transaction_type: ['', Validators.required]
    })
  }

  onSubmit(): void {
    this.submitted = true;

    if (this.transactionForm.invalid) {
      Object.keys(this.transactionForm.controls).map((key) => {
        this.getErrorMessage(key);
      });

      this.submitted = false;
      return;
    }

    const transactionBody: TransactionBody = this.transactionForm.value

    this.transactionService.register(transactionBody).subscribe({
      next: (response) => {
        this.messageService.add({
          severity: 'success',
          summary: 'Success',
          detail: `Transaction registered successfully`,
        });

        this.registeredTransaction.emit(response.data)

        this.transactionForm.reset()
        this.submitted = false;
        this.changeVisible.emit(false)
      },
      error: (error) => {
        this.messageService.add({
          severity: 'warn',
          summary: 'Warning',
          detail: error.error.message,
        });

        this.submitted = false
      }
    })
  }

  getErrorMessage(controlName: string): void {
    const control = this.transactionForm.get(controlName);

    if (control?.hasError('required')) {
      this.messageService.add({
        severity: 'warn',
        summary: 'Warning',
        detail: `The field ${controlName} is required`,
      });
    }
  }

  changeVisibleModal(event: boolean): void {
    this.transactionForm.reset()
    this.changeVisible.emit(event)
  }
}
