import { Component } from '@angular/core';
import { RouterLink } from "@angular/router";

import { FormAuthenticationComponent } from "@components/form-authentication/form-authentication.component";

@Component({
  selector: 'app-page-home',
  standalone: true,
  imports: [
    RouterLink,
    FormAuthenticationComponent
  ],
  templateUrl: './page-home.component.html',
  styleUrl: './page-home.component.css'
})
export class PageHomeComponent {

}
