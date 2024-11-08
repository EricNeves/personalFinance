import { Component } from '@angular/core';
import { RouterModule } from '@angular/router';

import {FormRegisterUserComponent} from "@components/form-register-user/form-register-user.component";

@Component({
  selector: 'app-page-register-user',
  standalone: true,
  imports: [RouterModule, FormRegisterUserComponent],
  templateUrl: './page-register-user.component.html',
  styleUrl: './page-register-user.component.css'
})
export class PageRegisterUserComponent {

}
