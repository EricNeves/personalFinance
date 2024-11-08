import { Routes } from '@angular/router';

import { PageHomeComponent } from '@pages/page-home/page-home.component'
import { PageRegisterUserComponent } from "@pages/page-register-user/page-register-user.component";

export const routes: Routes = [
  {
    path: '',
    component: PageHomeComponent,
    title: 'Personal Finance - Auth'
  },
  {
    path: 'register',
    component: PageRegisterUserComponent,
    title: 'Personal Finance - Register'
  }
];
