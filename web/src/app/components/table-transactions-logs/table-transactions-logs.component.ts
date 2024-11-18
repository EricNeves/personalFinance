import {Component, EventEmitter, Input, OnChanges, Output, SimpleChanges} from '@angular/core';

import { TableModule } from "primeng/table";
import { TagModule } from 'primeng/tag';
import { ButtonModule } from "primeng/button";

import {Transactions} from "@models/transaction.model";
import {Balance} from "@models/balance.model";

import { convertDateTimeToDate, convertMoneyToReal } from '@utils/converter'

import { NgxPaginationModule } from 'ngx-pagination'
import { TransactionService } from "@services/transaction.service";
import { ConfirmationService, MessageService } from "primeng/api";
import { ConfirmDialogModule } from 'primeng/confirmdialog';
import { ToastModule } from "primeng/toast";

@Component({
  selector: 'app-table-transactions-logs',
  standalone: true,
  imports: [
    TableModule,
    TagModule,
    ButtonModule,
    ConfirmDialogModule,
    NgxPaginationModule,
    ToastModule
  ],
  templateUrl: './table-transactions-logs.component.html',
  styleUrl: './table-transactions-logs.component.css',
  providers: [MessageService, ConfirmationService]
})
export class TableTransactionsLogsComponent implements OnChanges {
  @Input() transactions: Transactions = {
    items: [],
    total: 0
  }
  @Output() changeBalance: EventEmitter<Balance> = new EventEmitter()

  isLoading: boolean = false;

  currentPageTransactions: number = 1

  constructor(
    private readonly transactionService: TransactionService,
    private readonly messageService: MessageService,
    private readonly confirmationService: ConfirmationService
  ) {
  }

  ngOnChanges(changes: SimpleChanges) {
    if (changes['transactions']) {
      this.transactions.items = changes['transactions'].currentValue.items
    }
  }

  convertMoneyValueToReal(amount: number): string {
    return convertMoneyToReal(amount)
  }

  convertDateTimeValueToDate(dateTime: string): string {
    return convertDateTimeToDate(dateTime);
  }

  changePageTransactions(page: number): void {
    this.isLoading = true;

    this.currentPageTransactions = page

    this.transactionService.all(this.currentPageTransactions).subscribe({
      next: (response) => {
        this.transactions.items = response.data.items

        this.isLoading = false
      },
      error: (error) => {
        this.messageService.add({
          severity: 'error',
          summary: 'Warning',
          detail: `${error.error.message}`,
        })

        this.isLoading = false
      }
    })
  }

  removeTransaction(event: Event, transactionId: string): void {
    this.confirmationService.confirm({
      target: event.target as EventTarget,
      message: 'Do you want to delete this record?',
      header: 'Delete Confirmation',
      icon: 'pi pi-info-circle',
      acceptButtonStyleClass:"p-button-danger p-button-text",
      rejectButtonStyleClass:"p-button-text p-button-text",
      acceptIcon:"none",
      rejectIcon:"none",
      accept: () => {
        this.transactionService.remove(transactionId).subscribe({
          next: (response) => {
            this.changePageTransactions(this.currentPageTransactions)

            this.changeBalance.emit(response.data.balance)

            this.messageService.add({ severity: 'success', summary: 'Confirmed', detail: 'Record deleted' });
          },
          error: (error) => {
            this.messageService.add({ severity: 'error', summary: 'Error', detail: error.error.message });
          }
        })
      }
    });
  }
}
