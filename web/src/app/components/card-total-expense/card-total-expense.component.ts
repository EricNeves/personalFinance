import {Component, Input, OnChanges, SimpleChanges} from '@angular/core';
import { CardModule } from "primeng/card";
import {convertMoneyToReal} from "@utils/converter";

@Component({
  selector: 'app-card-total-expense',
  standalone: true,
    imports: [
        CardModule
    ],
  templateUrl: './card-total-expense.component.html',
  styleUrl: './card-total-expense.component.css'
})
export class CardTotalExpenseComponent implements OnChanges {
  @Input() expenseValue: number = 0;

  expenseValueBRL: string = ''

  ngOnChanges(changes: SimpleChanges) {
    if (changes['expenseValue']) {
      this.expenseValueBRL = convertMoneyToReal(this.expenseValue)
    }
  }
}
