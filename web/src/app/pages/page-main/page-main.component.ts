import { Component, OnInit } from '@angular/core';

import { ButtonModule } from "primeng/button";

import { MenubarComponent } from "@components/menubar/menubar.component";
import { CardTotalBalanceComponent } from "@components/card-total-balance/card-total-balance.component";
import { CardTotalIncomeComponent } from "@components/card-total-income/card-total-income.component";
import { CardTotalExpenseComponent } from "@components/card-total-expense/card-total-expense.component";
import { ModalAddTransactionComponent } from "@components/modal-add-transaction/modal-add-transaction.component";
import { ModalChangeUsernameComponent } from "@components/modal-change-username/modal-change-username.component";
import { ModalChangePasswordComponent } from "@components/modal-change-password/modal-change-password.component";
import { TableTransactionsLogsComponent } from "@components/table-transactions-logs/table-transactions-logs.component";

import { MessageService } from 'primeng/api';

import { BalanceService } from "@services/balance.service";
import { Balance } from "@models/balance.model";
import { User } from "@models/user.model";
import { forkJoin } from "rxjs";
import { TransactionService } from "@services/transaction.service";
import {Transactions, TransactionWithBalance} from "@models/transaction.model";

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
    ModalChangeUsernameComponent,
    ModalChangePasswordComponent,
    TableTransactionsLogsComponent
  ],
  templateUrl: './page-main.component.html',
  styleUrl: './page-main.component.css',
  providers: [MessageService]
})
export class PageMainComponent implements OnInit {
  visibleModalAddTransaction: boolean = false;
  visibleModalChangeUsername: boolean = false;
  visibleModalChangePassword: boolean = false;

  balance: Balance = {
    balance: 0,
    income: 0,
    expense: 0
  };

  user: User = {
    name: '',
    email: ''
  }

  transactions: Transactions = {
    items: [],
    total: 0
  }

  constructor(
    private readonly balanceService: BalanceService,
    private readonly messageService: MessageService,
    private readonly transactionService: TransactionService
  ) {
  }

  ngOnInit() {
    forkJoin({
      balance: this.balanceService.balance(),
      transactionsAll: this.transactionService.all()
    })
      .subscribe({
        next: (response) => {
          this.balance = response.balance.data
          this.transactions = response.transactionsAll.data
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

  registeredTransaction(transactionWithBalance: TransactionWithBalance): void {
    this.balance = {
      ...this.balance,
      ...transactionWithBalance.balance
    }

    this.transactions.items.unshift(transactionWithBalance.transaction)
    this.transactions.total += 1

    if (this.transactions.items.length > 4) {
      this.transactions.items.pop()
    }
  }

  changeUserInfo(user: User): void {
    this.user = {
      ...this.user,
      ...user
    }
  }

  changeBalanceValue(balance: Balance) {
    this.balance = balance
  }

  showModalAddTransaction(): void {
    this.visibleModalAddTransaction = !this.visibleModalAddTransaction
  }

  showModalChangeUsername(isVisible: boolean): void {
    this.visibleModalChangeUsername = isVisible
  }

  showModalChangePassword(isVisible: boolean): void {
    this.visibleModalChangePassword = isVisible
  }
}
