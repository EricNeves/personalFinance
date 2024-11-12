import { Component } from '@angular/core';

import { MenubarComponent } from "@components/menubar/menubar.component";
import { CardTotalBalanceComponent } from "@components/card-total-balance/card-total-balance.component";
import { CardTotalIncomeComponent } from "@components/card-total-income/card-total-income.component";
import { CardTotalExpenseComponent } from "@components/card-total-expense/card-total-expense.component";

@Component({
  selector: 'app-page-main',
  standalone: true,
  imports: [
    MenubarComponent,
    CardTotalBalanceComponent,
    CardTotalIncomeComponent,
    CardTotalExpenseComponent
  ],
  templateUrl: './page-main.component.html',
  styleUrl: './page-main.component.css'
})
export class PageMainComponent {

}
