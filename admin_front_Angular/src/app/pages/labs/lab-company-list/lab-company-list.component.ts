import { Component, OnInit, OnChanges, Input, ChangeDetectorRef, ViewChild, AfterViewChecked, AfterViewInit   } from '@angular/core';
import { HttpClient, HttpParams } from '@angular/common/http';
import { environment } from 'src/environments/environment';
import { MatPaginator,PageEvent } from '@angular/material/paginator';
import { ConfirmationService, MessageService, ConfirmEventType } from 'primeng/api';
import { Router } from '@angular/router';

@Component({
  selector: 'app-lab-company-list',
  templateUrl: './lab-company-list.component.html',
  styleUrls: ['./lab-company-list.component.scss'],
  providers: [ConfirmationService, MessageService]

})
export class LabCompanyListComponent {
  @ViewChild(MatPaginator) paginator: MatPaginator;
  @Input() tableData: any[];
  pageSize : number ;
  search_result: any[];
  search_index: string = "";
  src: string = environment.url + "uploads/lab_companies/";
  default_src: string = environment.url + "assets/frontend/images/general/doctorak_default_logo_img.png";
  constructor(private http: HttpClient, private cdr: ChangeDetectorRef, private confirmationService: ConfirmationService, private messageService: MessageService) {}
  ngOnInit(): void {
    this.http.get<any>(environment.apiUrl + "lab_company/list").
      subscribe((response) => {        
        this.tableData = response.lab_companies["data"];
        this.paginator.pageSize = 15;
        this.paginator.length = response.lab_companies["total"];      
      });
  }

  onPageChange(event: any) {
    this.pageChange();
  }

  onSelectChange(event : any) {
    this.pageSize = event.target.value;
    this.paginator.pageSize = event.target.value;
    this.paginator.pageIndex = 0;
    this.pageChange();
  }

  //search with the index
  search(){
    if(this.search_index == ""){
      this.ngOnInit();
    }else{
      this.http.post<any>(environment.apiUrl + "lab_company/table", {"search_index": this.search_index.toString()})   
          .subscribe((response)=>{
            this.tableData = response.search_result;
            this.paginator.pageSize = response.search_result.length;
            this.paginator.length = response.search_result.length;
            this.paginator.pageIndex = response.search_result["current_page"]-1;
            this.cdr.detectChanges(); // Manually trigger change detection
            
          })   
    }
  }
  pageChange(){
    if(this.paginator.pageIndex == 0 && this.paginator.pageSize == 10){
      this.pageSize = 10;
      this.ngOnInit();
    }else{
      this.http.post<any>(environment.apiUrl + "lab_company/table", {
        params: new HttpParams()
          .set('pageSize', this.paginator.pageSize.toString())
          .set('pageIndex', this.paginator.pageIndex.toString())
      }).subscribe((response)=>{
        this.tableData = response.search_result["data"];
        this.paginator.pageSize = response.search_result["per_page"];
        this.paginator.length = response.search_result["total"];
        this.paginator.pageIndex = response.search_result["current_page"]-1;
        this.cdr.detectChanges(); // Manually trigger change detection
        this.cdr.detectChanges(); // Manually trigger change detection
      })
    }
  }

  //delete the data

  delete(id: number){
    this.confirmationService.confirm({
        message: 'Are you sure to delete?"',
        header: 'Delete Confirmation',
        icon: 'pi pi-info-circle',
        accept: () => {
          this.http.get<any>(environment.apiUrl+ "lab_company/delete/" + id)
          .subscribe((response)=>{
            if(response.flash_type == "success"){
              this.messageService.add({ severity: 'info', summary: 'Confirmed', detail: 'Record deleted' });
              this.ngOnInit();
            }else{
              this.messageService.add({ severity: 'error', summary: 'Error', detail: 'server Error' });
            }
          })
        },
        reject: (type:any) => {
            switch (type) {
                case ConfirmEventType.REJECT:
                  this.messageService.add({ severity: 'error', summary: 'Rejected', detail: 'You have rejected' });
                  break;
                case ConfirmEventType.CANCEL:
                    this.messageService.add({ severity: 'warn', summary: 'Cancelled', detail: 'You have cancelled' });
                    break;
            }
        }
    });
  }
}


