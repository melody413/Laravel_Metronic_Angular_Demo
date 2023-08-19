import { AfterViewInit, Component, OnInit, TemplateRef, ViewChild } from '@angular/core';
import { ADTSettings,  } from 'angular-datatables/src/models/settings';
import { Subject } from 'rxjs';
import { HttpClient } from '@angular/common/http';
import { environment } from 'src/environments/environment';
import { TableModule, SharedModule } from '@coreui/angular';

@Component({
  selector: 'app-bodypart-list',
  templateUrl: './bodypart-list.component.html',
  styleUrls: ['./bodypart-list.component.scss']
})
export class BodypartListComponent implements OnInit{
  constructor(private http: HttpClient) { }
  ngOnInit(): void {
      this.http.get(environment.apiUrl + "bodypart/list").
      subscribe((response)=>{
        console.log(response);
      })
  }
}