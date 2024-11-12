import { Component } from '@angular/core';
import { CardModule } from "primeng/card";

@Component({
  selector: 'app-card-total-expense',
  standalone: true,
    imports: [
        CardModule
    ],
  templateUrl: './card-total-expense.component.html',
  styleUrl: './card-total-expense.component.css'
})
export class CardTotalExpenseComponent {

}
