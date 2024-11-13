import {Component, EventEmitter, Input, Output} from '@angular/core';

import { DialogModule } from 'primeng/dialog';
import { ButtonModule } from "primeng/button";

@Component({
  selector: 'app-modal-add-transaction',
  standalone: true,
  imports: [
    DialogModule,
    ButtonModule
  ],
  templateUrl: './modal-add-transaction.component.html',
  styleUrl: './modal-add-transaction.component.css'
})
export class ModalAddTransactionComponent {
  @Input() visible: boolean = false;
  @Output() changeVisible = new  EventEmitter();

  changeVisibleModal(event: boolean): void {
    this.changeVisible.emit(event)
  }
}
