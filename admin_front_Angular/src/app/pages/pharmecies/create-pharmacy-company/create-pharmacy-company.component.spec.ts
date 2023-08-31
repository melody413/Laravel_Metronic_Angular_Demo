import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CreatePharmacyCompanyComponent } from './create-pharmacy-company.component';

describe('CreatePharmacyCompanyComponent', () => {
  let component: CreatePharmacyCompanyComponent;
  let fixture: ComponentFixture<CreatePharmacyCompanyComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [CreatePharmacyCompanyComponent]
    });
    fixture = TestBed.createComponent(CreatePharmacyCompanyComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
