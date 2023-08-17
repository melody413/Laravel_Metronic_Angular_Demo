import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-toggle-switch',
  templateUrl: './toggle-switch.component.html',
  styleUrls: ['./toggle-switch.component.scss']
})
export class ToggleSwitchComponent implements OnInit {
  selected: boolean = false;
  constructor() { }

  ngOnInit() {
  }

}