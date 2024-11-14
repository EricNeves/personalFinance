import { Component, OnInit } from '@angular/core';

import { ButtonModule } from "primeng/button";

import { MenubarComponent } from "@components/menubar/menubar.component";
import { CardTotalBalanceComponent } from "@components/card-total-balance/card-total-balance.component";
import { CardTotalIncomeComponent } from "@components/card-total-income/card-total-income.component";
import { CardTotalExpenseComponent } from "@components/card-total-expense/card-total-expense.component";
import { ModalAddTransactionComponent } from "@components/modal-add-transaction/modal-add-transaction.component";

import { MessageService } from 'primeng/api';

import { BalanceService } from "@services/balance.service";
import { Balance } from "@models/balance.model";

import { JsonPipe } from "@angular/common";

@Component({
  selector: 'app-page-main',
  standalone: true,
  imports: [
    MenubarComponent,
    CardTotalBalanceComponent,
    CardTotalIncomeComponent,
    CardTotalExpenseComponent,
    ButtonModule,
    ModalAddTransactionComponent,
    JsonPipe
  ],
  templateUrl: './page-main.component.html',
  styleUrl: './page-main.component.css',
  providers: [MessageService]
})
export class PageMainComponent implements OnInit {
  visibleModalAddTransaction: boolean = false;

  balance: Balance = {
    balance: 0,
    income: 0,
    expense: 0
  };

  constructor(
    private readonly balanceService: BalanceService,
    private readonly messageService: MessageService,
  ) {
  }

  ngOnInit() {
    this.balanceService.balance().subscribe({
      next: (response) => {
        this.balance = response.data
      },
      error: (error) => {
        this.messageService.add({
          severity: 'error',
          summary: 'Warning',
          detail: `${error.error.message}`,
        })
      }
    })
  }

  registeredTransaction(balance: Balance): void {
    this.balance = {
      ...this.balance,
      ...balance
    }
  }

  showModalAddTransaction() {
    this.visibleModalAddTransaction = !this.visibleModalAddTransaction
  }
}
