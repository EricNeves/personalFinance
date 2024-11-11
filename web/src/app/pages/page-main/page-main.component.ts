import { Component } from '@angular/core';

import { MenubarComponent } from "@components/menubar/menubar.component";

@Component({
  selector: 'app-page-main',
  standalone: true,
  imports: [
    MenubarComponent
  ],
  templateUrl: './page-main.component.html',
  styleUrl: './page-main.component.css'
})
export class PageMainComponent {

}
