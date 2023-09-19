import { Component, OnInit, OnChanges, Input, ChangeDetectorRef, ViewChild, AfterViewChecked, AfterViewInit   } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from 'src/environments/environment';
import { MatPaginator,PageEvent } from '@angular/material/paginator';
import { ConfirmationService, MessageService, ConfirmEventType } from 'primeng/api';

@Component({
  selector: 'app-pharmecy-company-list',
  templateUrl: './pharmecy-company-list.component.html',
  styleUrls: ['./pharmecy-company-list.component.scss'],
  providers: [ConfirmationService, MessageService]
})
export class PharmecyCompanyListComponent {
  @ViewChild(MatPaginator) paginator: MatPaginator;
  @Input() tableData: any[];
  pageSize : number ;
  search_index: string;
  src: string = environment.url + "uploads/pharmacy_companies/";
  default_src: string = environment.url + "assets/frontend/images/general/doctorak_default_logo_img.png";

  constructor(private http: HttpClient, private cdr: ChangeDetectorRef, private confirmationService: ConfirmationService, private messageService: MessageService) {}
  ngOnInit(): void {
    this.http.get<any>(environment.apiUrl + "pharmacy_company/list").
      subscribe((response) => {        
        this.tableData = response.pharmacy_companies["data"];
        this.paginator.pageSize = response.pharmacy_companies["per_page"];
        this.paginator.length = response.pharmacy_companies["total"]; 
      });
  }

  onPageChange(event: any) {
  }

  onSelectChange(event : any) {
    this.pageSize = event.target.value;
    this.ngAfterViewInit();
  }
  onSearchChange(event : any){
    const searchTerm = event.target.value.toLowerCase();
    this.tableData = this.tableData.filter(item => {
      return item[2].toLowerCase().includes(searchTerm) || item[3].toLowerCase().includes(searchTerm);
    });
    this.cdr.detectChanges();
    // console.log(event.target.value);
  }

  ngAfterViewInit() {
    this.paginator.pageSize = this.pageSize;
  }


  //search with the index
  search(){
    if(this.search_index == ""){
      this.ngOnInit();
    }else{
      this.http.post<any>(environment.apiUrl + "pharmacy_company/table", {"search_index": this.search_index.toString()})   
          .subscribe((response)=>{
            this.tableData = response.search_result;
            this.paginator.pageSize = response.search_result.length;
            this.paginator.length = response.search_result.length;
            this.paginator.pageIndex = response.search_result["current_page"]-1;
            this.cdr.detectChanges(); // Manually trigger change detection
            
          })   
    }
  }

  delete(id: number){
    this.confirmationService.confirm({
        message: 'Are you sure to delete?"',
        header: 'Delete Confirmation',
        icon: 'pi pi-info-circle',
        accept: () => {
          this.http.get<any>(environment.apiUrl+ "pharmacy_company/delete/" + id)
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