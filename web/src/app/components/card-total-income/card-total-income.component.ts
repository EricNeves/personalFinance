import {Component, Input, OnChanges, SimpleChanges} from '@angular/core';
import { CardModule } from "primeng/card";
import { convertMoneyToReal } from "@utils/converter";

@Component({
  selector: 'app-card-total-income',
  standalone: true,
    imports: [
        CardModule
    ],
  templateUrl: './card-total-income.component.html',
  styleUrl: './card-total-income.component.css'
})
export class CardTotalIncomeComponent implements OnChanges {
  @Input() incomeValue: number = 0;

  incomeValueBRL: string = ''

  ngOnChanges(changes: SimpleChanges) {
    if (changes['incomeValue']) {
      this.incomeValueBRL = convertMoneyToReal(this.incomeValue)
    }
  }
}
