import { ComponentFixture, TestBed } from '@angular/core/testing';

import { EditPharmacyCompanyComponent } from './edit-pharmacy-company.component';

describe('EditPharmacyCompanyComponent', () => {
  let component: EditPharmacyCompanyComponent;
  let fixture: ComponentFixture<EditPharmacyCompanyComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [EditPharmacyCompanyComponent]
    });
    fixture = TestBed.createComponent(EditPharmacyCompanyComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
