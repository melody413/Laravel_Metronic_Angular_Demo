import { ComponentFixture, TestBed } from '@angular/core/testing';

import { LabCompanyListComponent } from './lab-company-list.component';

describe('LabCompanyListComponent', () => {
  let component: LabCompanyListComponent;
  let fixture: ComponentFixture<LabCompanyListComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [LabCompanyListComponent]
    });
    fixture = TestBed.createComponent(LabCompanyListComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
