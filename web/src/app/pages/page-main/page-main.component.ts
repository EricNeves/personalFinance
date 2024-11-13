import { Component } from '@angular/core';

import { ButtonModule } from "primeng/button";

import { MenubarComponent } from "@components/menubar/menubar.component";
import { CardTotalBalanceComponent } from "@components/card-total-balance/card-total-balance.component";
import { CardTotalIncomeComponent } from "@components/card-total-income/card-total-income.component";
import { CardTotalExpenseComponent } from "@components/card-total-expense/card-total-expense.component";
import { ModalAddTransactionComponent } from "@components/modal-add-transaction/modal-add-transaction.component";

@Component({
  selector: 'app-page-main',
  standalone: true,
  imports: [
    MenubarComponent,
    CardTotalBalanceComponent,
    CardTotalIncomeComponent,
    CardTotalExpenseComponent,
    ButtonModule,
    ModalAddTransactionComponent
  ],
  templateUrl: './page-main.component.html',
  styleUrl: './page-main.component.css'
})
export class PageMainComponent {
  visibleModalAddTransaction: boolean = false;

  showModalAddTransaction() {
    this.visibleModalAddTransaction = !this.visibleModalAddTransaction
  }
}
