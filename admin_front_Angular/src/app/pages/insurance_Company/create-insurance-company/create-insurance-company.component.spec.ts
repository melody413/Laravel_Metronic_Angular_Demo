import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CreateInsuranceCompanyComponent } from './create-insurance-company.component';

describe('CreateInsuranceCompanyComponent', () => {
  let component: CreateInsuranceCompanyComponent;
  let fixture: ComponentFixture<CreateInsuranceCompanyComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [CreateInsuranceCompanyComponent]
    });
    fixture = TestBed.createComponent(CreateInsuranceCompanyComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
