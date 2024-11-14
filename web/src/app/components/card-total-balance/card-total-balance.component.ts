import {Component, Input, OnChanges, OnInit, SimpleChanges} from '@angular/core';

import { CardModule } from 'primeng/card';
import { convertMoneyToReal } from "@utils/converter";

@Component({
  selector: 'app-card-total-balance',
  standalone: true,
  imports: [
    CardModule
  ],
  templateUrl: './card-total-balance.component.html',
  styleUrl: './card-total-balance.component.css'
})
export class CardTotalBalanceComponent implements OnChanges {
  @Input() balanceValue: number = 0;

  balanceValueBRL: string = ''

  ngOnChanges(changes: SimpleChanges) {
    if (changes['balanceValue']) {
      this.balanceValueBRL = convertMoneyToReal(this.balanceValue)
    }
  }
}
