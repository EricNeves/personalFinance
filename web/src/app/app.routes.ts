import { Routes } from '@angular/router';

import { PageHomeComponent } from '@pages/page-home/page-home.component'
import { PageRegisterUserComponent } from "@pages/page-register-user/page-register-user.component";
import { PageMainComponent } from "@pages/page-main/page-main.component";

import { ensureAuthenticatedGuard } from "@guards/ensure-authenticated.guard";

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
  },
  {
    path: 'panel',
    component: PageMainComponent,
    title: 'Personal Finance - Main Panel',
    canActivate: [ensureAuthenticatedGuard]
  },
];
