import { Component } from '@angular/core';

import { CardModule } from 'primeng/card';

@Component({
  selector: 'app-card-total-balance',
  standalone: true,
  imports: [
    CardModule
  ],
  templateUrl: './card-total-balance.component.html',
  styleUrl: './card-total-balance.component.css'
})
export class CardTotalBalanceComponent {

}
