import {Component, OnInit} from '@angular/core';

import { MenuItem } from 'primeng/api';
import { MenubarModule } from 'primeng/menubar';
import {StorageService} from "@services/storage.service";
import {Router} from "@angular/router";

@Component({
  selector: 'app-menubar',
  standalone: true,
  imports: [
    MenubarModule
  ],
  templateUrl: './menubar.component.html',
  styleUrl: './menubar.component.css'
})
export class MenubarComponent implements OnInit {
  menu: MenuItem[] | undefined;

  ngOnInit() {
    this.menu = [
      {
        label: 'Export',
        icon: 'pi pi-file-export',
        items: [
          {
            label: 'Export as PDF',
            icon: 'pi pi-file-pdf'
          },
          {
            label: 'Export as CSV',
            icon: 'pi pi-file-o'
          }
        ]
      },
      {
        label: 'User - Eric Neves',
        icon: 'pi pi-user',
        items: [
          {
            label: 'Change Username',
            icon: 'pi pi-sign-out'
          },
          {
            label: 'Change Password',
            icon: 'pi pi-lock'
          },
          {
            label: 'Sign Out',
            icon: 'pi pi-pen-to-square',
            command: () => this.logout()
          }
        ]
      }
    ]
  }

  constructor(private readonly storageService: StorageService, private readonly router: Router) {}

  logout(): void {
    this.storageService.removeData('jwt')

    this.router.navigate(['/'])
  }
}
