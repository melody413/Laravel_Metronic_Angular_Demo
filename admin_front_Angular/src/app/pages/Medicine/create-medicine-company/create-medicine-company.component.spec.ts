import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CreateMedicineCompanyComponent } from './create-medicine-company.component';

describe('CreateMedicineCompanyComponent', () => {
  let component: CreateMedicineCompanyComponent;
  let fixture: ComponentFixture<CreateMedicineCompanyComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [CreateMedicineCompanyComponent]
    });
    fixture = TestBed.createComponent(CreateMedicineCompanyComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
