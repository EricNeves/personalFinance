import { Component } from '@angular/core';
import { CardModule } from "primeng/card";

@Component({
  selector: 'app-card-total-income',
  standalone: true,
    imports: [
        CardModule
    ],
  templateUrl: './card-total-income.component.html',
  styleUrl: './card-total-income.component.css'
})
export class CardTotalIncomeComponent {

}
