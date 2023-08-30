import { ComponentFixture, TestBed } from '@angular/core/testing';

import { MedicineCompanyListComponent } from './medicine-company-list.component';

describe('MedicineCompanyListComponent', () => {
  let component: MedicineCompanyListComponent;
  let fixture: ComponentFixture<MedicineCompanyListComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [MedicineCompanyListComponent]
    });
    fixture = TestBed.createComponent(MedicineCompanyListComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
